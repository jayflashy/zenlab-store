<?php

namespace App\Livewire\Cart;

use App\Traits\LivewireToast;
use Livewire\Component;

class Checkout extends Component
{
    use LivewireToast;
    public function render()
    {
        return view('livewire.cart.checkout');
    }
}
