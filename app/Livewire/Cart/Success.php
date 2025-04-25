<?php

namespace App\Livewire\Cart;

use App\Models\Order;
use App\Traits\LivewireToast;
use Livewire\Component;

class Success extends Component
{
    use LivewireToast;

    public ?Order $order = null;

    public array $orderItems = [];

    public float $orderTotal = 0;

    public function mount($order_id = null)
    {
        // If order_id is provided, load the specific order
        if ($order_id) {
            $this->order = Order::with('items.product')->whereCode($order_id)->firstOrFail();
        } else {
            // Fallback to most recent order (optional)
            $this->order = Order::with('items.product')->latest()->first();
            if (! $this->order) {
                session()->flash('error', 'No orders found');

                return redirect()->route('home');
            }
        }

        // Set order items and total
        $this->orderItems = $this->order->items;
        $this->orderTotal = $this->order->total;
    }

    public function render()
    {
        return view('livewire.cart.success');
    }
}
