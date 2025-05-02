<?php

namespace App\Livewire\User;

use App\Models\Order;
use App\Traits\LivewireToast;
use Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.invoice')]
class Invoice extends Component
{
    use LivewireToast;

    public $order;

    public string $pageTitle;

    // meta
    public string $metaTitle;


    public function mount($code = null)
    {
        $order = Order::whereUserId(Auth::id())->whereCode($code)->with(['user', 'items.product'])->firstOrFail();
        $this->order = $order;
        $this->pageTitle = 'Order Invoice - ' . $order->code;
        // set meta
        $this->metaTitle = 'Order Invoice - ' . $order->code;
    }

    public function render()
    {
        return view('livewire.user.invoice');
    }
}
