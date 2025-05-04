<?php

namespace App\Livewire\User;

use App\Models\OrderItem;
use App\Traits\LivewireToast;
use Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('user.layouts.app')]
class Downloads extends Component
{
    use LivewireToast;
    use WithPagination;

    public $search = '';

    public $metaTitle = 'Downloads';

    public $notify = [];

    public function mount()
    {
        // Load existing notification preferences
        $notificationPreferences = Auth::user()->notificationPreferences()->where('type', 'product_update')->pluck('product_id')->toArray();

        foreach ($notificationPreferences as $productId) {
            $this->notify[$productId] = true;
        }
    }

    public function updatedNotify($value, $key)
    {
        $user = Auth::user();
        $productId = $key;

        if ($value) {
            // Add notification preference
            $user->notificationPreferences()->updateOrCreate(
                ['product_id' => $productId, 'type' => 'product_update'],
                ['active' => true]
            );
            $this->successAlert('You will be notified when this product is updated');
        } else {
            // Remove notification preference
            $user->notificationPreferences()->where('product_id', $productId)->where('type', 'product_update')->delete();
            $this->successAlert('Notification preference removed');
        }
    }

    public function render()
    {
        $query = OrderItem::whereHas('order', function ($query): void {
            $query->where('user_id', Auth::id())->where('order_status', 'completed');
        })
            ->with(['order', 'product', 'userReview' => function ($query): void {
                $query->where('user_id', Auth::id());
            }])
            ->latest();

        if ($this->search) {
            $query->whereHas('product', function ($query): void {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        }

        $items = $query->paginate(30);

        return view('livewire.user.downloads', compact('items'));
    }
}
