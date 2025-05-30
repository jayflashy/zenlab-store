<?php

namespace App\Livewire\Cart;

use App\Models\Cart;
use Livewire\Component;

class CartCount extends Component
{
    public $cartCount = 0;

    protected $listeners = ['cartUpdated' => 'updateCartCount'];

    public function mount()
    {
        $this->updateCartCount();
    }

    public function updateCartCount()
    {
        $cart = Cart::getCurrentCart();

        $this->cartCount = $cart ? $cart->items()->sum('quantity') : 0;
    }

    public function render()
    {
        return view('livewire.cart.cart-count');
    }
}
