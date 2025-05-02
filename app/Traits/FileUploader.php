<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Log;

trait FileUploader
{
    /**
     * Store and optionally resize an image.
     */
    public function handleImage(
        ?UploadedFile $file,
        string $path,
        ?string $oldFile = null,
        ?int $width = null,
        ?int $height = null,
        int $quality = 90,
        ?string $format = null,
        string $disk = 'uploads'
    ): ?string {
        if ($file === null) {
            return null;
        }

        // Delete the old file if it exists
        if ($oldFile && Storage::disk($disk)->exists($oldFile)) {
            Storage::disk($disk)->delete($oldFile);
        }

        // Determine the final extension
        $extension = $format ? strtolower($format) : $file->getClientOriginalExtension();

        // Create a unique filename
        $filename = Str::random(35) . '-' . time() . '.' . $extension;
        $fullPath = $path . '/' . $filename;

        // Read the image using Intervention
        $image = Image::read($file);

        // Resize logic
        if ($width && $height) {
            $image->resize($width, $height);
        } elseif ($width) {
            $image->scaleDown(width: $width);
        } elseif ($height) {
            $image->scaleDown(height: $height);
        }

        // Format-specific encoding
        $encodedImage = match ($extension) {
            'jpg', 'jpeg' => $image->toJpeg(quality: $quality),
            'png' => $image->toPng(),
            'webp' => $image->toWebp(quality: $quality),
            'avif' => $image->toAvif(quality: $quality),
            'heic' => $image->toHeic(quality: $quality),
            'gif' => $image->toGif(),
            'bmp' => $image->toBitmap(),
            default => $image->toJpeg(quality: $quality),
        };

        // Store the file
        try {
            Storage::disk($disk)->put($fullPath, $encodedImage);
        } catch (Exception $exception) {
            // Log the error or handle it appropriately
            Log::error("Failed to store image: {$exception->getMessage()}");

            return null;
        }

        return $fullPath;
    }

    /**
     * Store a regular file (non-image) and optionally delete the old one.
     *
     * @param  UploadedFile|null  $file  The uploaded file
     * @param  string  $path  Storage path
     * @param  string|null  $oldFile  Old file path to delete
     * @param  string  $disk  Filesystem disk (default: 'uploads')
     * @return string|null Path to the stored file
     */
    public function handleFile(
        ?UploadedFile $file,
        string $path,
        ?string $oldFile = null,
        string $disk = 'uploads'
    ): ?string {
        if ($file === null) {
            return null;
        }

        if ($oldFile && Storage::disk($disk)->exists($oldFile)) {
            Storage::disk($disk)->delete($oldFile);
        }

        return $file->store($path, $disk);
    }
}
