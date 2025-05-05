<?php

namespace App\Livewire\Product;

use App\Traits\LivewireToast;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

class WishlistButton extends Component
{
    use LivewireToast;
    public $product;
    public $isInWishlist = false;

    public function mount($product)
    {
        $this->product = $product;
        $this->isInWishlist = Auth::check()
            && Auth::user()->wishlists()->where('product_id', $this->product->id)->exists();
    }

    public function toggleWishlist()
    {
        if (!Auth::check()) {
            $this->warningAlert('Please login to add products to wishlist', 'warning');
            return;
        }

        $user = Auth::user();
        $existingWishlist = $user->wishlists()->where('product_id', $this->product->id)->first();

        if ($existingWishlist) {
            $existingWishlist->delete();
            $message = 'Product removed from wishlist!';
        } else {
            $user->wishlists()->create([
                'product_id' => $this->product->id,
            ]);
            $message = 'Product added to wishlist!';
        }
        $this->isInWishlist = !$this->isInWishlist;

        $this->successAlert($message);
        $this->dispatch('wishlistUpdated');
    }


    public function render()
    {
        return view('livewire.product.wishlist-button');
    }
}
