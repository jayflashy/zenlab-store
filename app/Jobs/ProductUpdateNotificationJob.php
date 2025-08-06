<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProductUpdateNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Product $product)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $usersToNotify = User::whereHas('orders', function ($query) {
            $query->where('order_status', 'completed')
                ->whereHas('items', function ($itemQuery) {
                    $itemQuery->where('product_id', $this->product->id);
                });
        })->whereHas('notificationPreferences', function ($prefQuery) {
            $prefQuery->where('product_id', $this->product->id)
                ->where('type', 'product_update')
                ->where('active', true);
        })->get();

        if ($usersToNotify->isEmpty()) {
            Log::info('No users to notify for product update: ' . $this->product->name);

            return;
        }

        foreach ($usersToNotify as $user) {
            $orderItem = $user->orders()
                ->where('order_status', 'completed')
                ->whereHas('items', fn ($q) => $q->where('product_id', $this->product->id))
                ->with('items')
                ->latest() // Get the most recent order if they bought it multiple times
                ->first()
                ->items
                ->where('product_id', $this->product->id)
                ->first();

            if (! $orderItem) {
                continue;
            }

            $shortcodes = [
                'user_name' => $user->name,
                'product_name' => $this->product->name,
                'product_version' => $this->product->version,
                'download_link' => route('user.download', $orderItem->id),
            ];
            sendNotification('PRODUCT_UPDATE', $user, $shortcodes);
        }
    }
}
