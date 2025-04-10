<?php

namespace App\Livewire\Cart;

use App\Traits\LivewireToast;
use Livewire\Component;

class Items extends Component
{
    use LivewireToast;

    public function render()
    {
        return view('livewire.cart.items')
            ->layout('user.layouts.app');
    }
}
