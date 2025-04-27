<?php

namespace App\Livewire\Product;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Traits\LivewireToast;
use Cache;
use Livewire\Component;

class Details extends Component
{
    use LivewireToast;

    public $product;

    public $pageTitle;

    // license
    public $selectedLicenseType = 'regular';

    public $extendedSupport = false;

    public $supportPrice = 7.25;

    public $supportOriginalPrice = 12.00;

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

    public function toggleLicenseType()
    {
        $this->selectedLicenseType = $this->selectedLicenseType === 'regular' ? 'extended' : 'regular';
    }

    public function getCurrentPriceProperty()
    {
        $basePrice = $this->selectedLicenseType === 'regular'
            ? $this->product->final_price
            : $this->product->final_extended_price;

        if ($this->extendedSupport) {
            $basePrice += $this->supportPrice;
        }

        return $basePrice;
    }

    public function addToCart()
    {
        // Get or create cart
        $cart = Cart::getCurrentCart();

        // Check if product with same license is already in cart
        $existingItem = CartItem::firstOrCreate([
            'cart_id' => $cart->id,
            'product_id' => $this->product->id,
            'license_type' => $this->selectedLicenseType,
            'extended_support' => $this->extendedSupport,
        ], [
            'price' => $this->currentPrice,
            'quantity' => 1,
            'support_price' => $this->extendedSupport ? $this->supportPrice : 0,
            'total' => $this->currentPrice,
        ]);

        if ($existingItem->wasRecentlyCreated === false) {
            // Product already in cart
            $this->infoAlert('This product is already in your cart');
        } else {
            // Emit event to update header cart count
            $this->dispatch('cartUpdated');

            $this->successAlert('Product added to cart successfully');
        }
    }

    public function render()
    {
        return view('livewire.product.details', [
            'relatedProducts' => $this->getRelatedProducts(),
            'currentPrice' => $this->currentPrice,
        ]);
    }
}
