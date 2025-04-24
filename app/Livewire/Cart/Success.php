<?php

namespace App\Livewire\Cart;

use App\Models\Order;
use App\Traits\LivewireToast;
use Livewire\Component;

class Success extends Component
{
    use LivewireToast;

    public $order;
    public $orderItems = [];
    public $orderTotal = 0;

    public function mount($order_id = null)
    {
        // If order_id is provided, load the specific order
        if ($order_id) {
            $this->order = Order::with('items.product')->whereCode($order_id)->firstOrFail();
            $this->orderItems = $this->order->items;
            $this->orderTotal = $this->order->total;
        } else {
            // Fallback to most recent order (optional)
            $this->order = Order::with('items.product')->latest()->first();
            if ($this->order) {
                $this->orderItems = $this->order->items;
                $this->orderTotal = $this->order->total;
            }
        }
    }
    public function render()
    {
        return view('livewire.cart.success');
    }
}
