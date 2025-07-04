<?php

namespace App\Livewire\Product;

use App\Traits\LivewireToast;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Wishlist extends Component
{
    use LivewireToast;

    // meta
    public string $metaTitle;

    public string $metaDescription = 'Product Wishlist';

    public string $metaKeywords = 'wishlist';

    public string $metaImage;

    public Collection $wishlistItems;

    public function mount()
    {
        // set meta
        $this->loadWishlistItems();
        $this->metaTitle = 'Wishlist';
    }

    /**
     * Load the authenticated user’s wishlist items.
     */
    public function loadWishlistItems(): void
    {
        if (! Auth::check()) {
            $this->wishlistItems = collect();

            return;
        }
        $this->wishlistItems = Auth::user()
            ->wishlists()
            ->with(['product' => function ($query) {
                $query->where('status', 'published');
            }])
            ->whereHas('product', function ($query) {
                $query->where('status', 'published');
            })
            ->get();
    }

    public function render()
    {
        return view('livewire.product.wishlist');
    }
}
