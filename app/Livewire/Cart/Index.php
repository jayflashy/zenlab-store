<?php

namespace App\Livewire\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Traits\LivewireToast;
use Livewire\Component;

class Index extends Component
{
    use LivewireToast;

    public $cart;

    public $cartItems = [];

    public $cartTotal = 0;

    protected $listeners = ['cartUpdated' => 'loadCart'];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cart = Cart::getCurrentCart();

        if ($this->cart) {
            // Load cart items with products
            $this->cartItems = $this->cart->items()
                ->with('product.category')
                ->get()
                ->toArray();

            // Calculate total
            $this->cart->load('items.product.category');
            $this->cartItems = $this->cart->items->toArray();
            $this->cartTotal = $this->cart->items->sum(fn ($item): int|float => $item->price * $item->quantity);
        }
    }

    public function updateQuantity($itemId, $change)
    {
        $cartItem = CartItem::find($itemId);

        if (! $cartItem) {
            return;
        }

        $newQuantity = (int) $cartItem->quantity + $change;

        if ($newQuantity > 0) {
            $cartItem->update([
                'quantity' => $newQuantity,
                'total' => $cartItem->price * $newQuantity,
            ]);
            $this->toast('success', 'Cart updated successfully');
        } else {
            $this->removeItem($itemId);
        }

        $this->loadCart();
        $this->dispatch('cartUpdated');
    }

    public function removeItem($itemId)
    {
        $cartItem = CartItem::find($itemId);

        if ($cartItem) {
            $cartItem->delete();
            $this->toast('success', 'Item removed from cart');
            $this->loadCart();
            $this->dispatch('cartUpdated');
        }
    }

    public function addToWishlist($productId)
    {
        // Implement wishlist functionality if needed
        $this->toast('success', 'Added to wishlist');
    }

    public function render()
    {
        return view('livewire.cart.index');
    }
}
