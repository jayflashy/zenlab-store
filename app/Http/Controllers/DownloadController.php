<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Auth;
use Storage;
use Str;

class DownloadController extends Controller
{
    /**
     * Initiate download for purchased product
     *
     * @param  string  $id
     */
    public function download($id)
    {
        $orderItem = OrderItem::where('id', $id)
            ->whereHas('order', function ($query): void {
                $query->where('user_id', Auth::id())->where('order_status', 'completed');
            })->with('product', 'order')->firstOrFail();

        $product = $orderItem->product;

        if (! $product) {
            return back()->with('error', 'Product not found');
        }

        // Validate support period
        $supportEndDate = now()->diffInDays($orderItem->support_end_date);
        $daysSinceOrder = $orderItem->order->created_at->diffInDays(now());

        if ($daysSinceOrder > $supportEndDate) {
            return back()->with('error', 'Support period has expired');
        }

        if (empty($product->download_url)) {
            return back()->with('error', 'Download file not available');
        }

        $product->increment('downloads_count');

        if ($product->download_type === 'file') {
            $filePath = $product->file_path;
            $fileName = Str::slug(get_setting('name') . ' ' . $product->name) . '.' . pathinfo($filePath, PATHINFO_EXTENSION);
            if (! Storage::disk('uploads')->exists($filePath)) {
                return back()->with('error', 'Download file not found');
            }

            return Storage::disk('uploads')->download($filePath, $fileName);
        }

        return redirect($product->download_url);
    }

    public function certificate($id)
    {
        $userId = Auth::id();

        $orderItem = OrderItem::where('id', $id)
            ->whereHas('order', fn ($query) => $query->where('user_id', $userId))
            ->firstOrFail();

        return view('user.certificate', [
            'item' => $orderItem,
            'order' => $orderItem->order,
        ]);
    }
}
