<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use Storage;

class DownloadController extends Controller
{
    /**
     * Initiate download for purchased product
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        $orderItem = OrderItem::where('id', $id)
            ->whereHas('order', function ($query) {
                $query->where('user_id', auth()->id())
                    ->where('order_status', 'completed');
            })
            ->with('product')
            ->firstOrFail();

        // Check if download limit has been reached based on support preiod
        if ($orderItem->download_limit > 0 && $orderItem->download_count >= $orderItem->download_limit) {
            return back()->with('error', 'Download limit reached for this product');
        }

        // Check if product exists and has a file to download
        if (!$orderItem->product || !$orderItem->product->file_path) {
            return back()->with('error', 'Download file not available');
        }

        // Increment download count
        $orderItem->increment('download_count');

        // Get file path from the product
        $filePath = $orderItem->product->file_path;
        $fileName = $orderItem->product->name . '.' . pathinfo($filePath, PATHINFO_EXTENSION);

        // Check if file exists in storage
        if (!Storage::disk('uploads')->exists($filePath)) {
            return back()->with('error', 'Download file not found');
        }

        // Return file download response
        return Storage::disk('uploads')->download($filePath, $fileName);
    }
}
