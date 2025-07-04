<?php

namespace App\Livewire\Product;

use App\Traits\LivewireToast;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('user.layouts.app')]
class Category extends Component
{
    use LivewireToast;


    // meta
    public string $metaTitle;

    public string $metaDescription;

    public string $metaKeywords;

    public string $metaImage;

    public function mount()
    {
        // set meta
        $this->metaTitle = "Category";
    }

    public function render()
    {
        return view('livewire.product.category');
    }
}
