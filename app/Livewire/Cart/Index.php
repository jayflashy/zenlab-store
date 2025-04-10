<?php

namespace App\Livewire\Cart;

use App\Traits\LivewireToast;
use Livewire\Component;

class Index extends Component
{
    use LivewireToast;

    public function render()
    {
        return view('livewire.cart.index');
    }
}
