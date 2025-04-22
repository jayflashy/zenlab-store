<?php

namespace App\Livewire\Product;

use App\Models\Product;
use App\Traits\LivewireToast;
use Cache;
use Livewire\Component;

class Details extends Component
{
    use LivewireToast;

    public $product;

    public $pageTitle;

    public function mount($slug)
    {
        $product = Product::where('slug', $slug)->firstorFail();
        $this->product = $product;
        $this->pageTitle = $product->name;
    }

    public function getRelatedProducts()
    {
        $cacheKey = 'related_products_'.$this->product->id;

        return Cache::remember($cacheKey, now()->addMinutes(30), function () {
            return Product::where('category_id', $this->product->category_id)
                ->where('id', '!=', $this->product->id)
                ->inRandomOrder()
                ->limit(4)
                ->get();
        });
    }

    public function render()
    {
        return view('livewire.product.details', [
            'relatedProducts' => $this->getRelatedProducts(),
        ]);
    }
}
