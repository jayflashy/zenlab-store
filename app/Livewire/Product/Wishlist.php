<?php

namespace App\Livewire\Product;

use App\Traits\LivewireToast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Wishlist extends Component
{
    use LivewireToast;

    // meta
    public string $metaTitle;

    public string $metaDescription;

    public string $metaKeywords;

    public string $metaImage;

    /** @var Collection<int, Wishlist> */
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
        $this->wishlistItems = Auth::user()
            ->wishlists()
            ->with('product')
            ->get();
    }

    public function render()
    {
        return view('livewire.product.wishlist');
    }
}
