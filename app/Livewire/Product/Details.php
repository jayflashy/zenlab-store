<?php

namespace App\Livewire\Product;

use App\Traits\LivewireToast;
use Livewire\Component;

class Details extends Component
{
    use LivewireToast;

    public function render()
    {
        return view('livewire.product.details');
    }
}
