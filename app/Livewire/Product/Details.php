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

    // meta
    public string $metaTitle;
    public string $metaDescription;
    public string $metaKeywords;
    public string $metaImage;

    public function mount($slug)
    {
        $product = Product::where('slug', $slug)->with('ratings.user')->firstorFail();
        $this->product = $product;
        $this->pageTitle = $product->name;
        // set meta
        $this->metaTitle = $this->product->name;
        $this->metaDescription = str()->limit(strip_tags($this->product->short_description), 150);
        $this->metaKeywords = implode(',', $product->tags);
        $this->metaImage = $this->product->image ? my_asset($this->product->image) : my_asset(get_setting('logo'));
    }

    public function getRelatedProducts()
    {
        $cacheKey = 'related_products_' . $this->product->id;

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
