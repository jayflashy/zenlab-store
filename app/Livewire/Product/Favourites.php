<?php

namespace App\Livewire\Product;

use App\Traits\LivewireToast;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Favourites extends Component
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
        $this->metaTitle = "Favourites";
    }

    public function render()
    {
        return view('livewire.product.favourites');
    }
}
