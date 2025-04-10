<?php

namespace App\Livewire\Product;

use App\Traits\LivewireToast;
use Livewire\Component;

class Index extends Component
{
    use LivewireToast;
    public function render()
    {
        return view('livewire.product.index');
    }
}
