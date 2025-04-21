<?php

namespace App\Livewire\Admin\Products;

use App\Traits\LivewireToast;
use Livewire\Component;

class ProductList extends Component
{
    use LivewireToast;
    public function render()
    {
        return view('livewire.admin.products.product-list')
        ->layout('admin.layouts.app');
    }
}
