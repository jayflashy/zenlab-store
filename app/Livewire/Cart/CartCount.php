<?php

namespace App\Livewire\Cart;

use App\Models\Cart;
use App\Traits\LivewireToast;
use Auth;
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
        if (Auth::check()) {
            // For logged-in users
            $cart = Cart::where('user_id', Auth::id())
                ->where('status', 'active')
                ->first();
        } else {
            // For guest users
            $sessionId = session()->getId();
            $cart = Cart::where('session_id', $sessionId)
                ->where('status', 'active')
                ->first();
        }

        if ($cart) {
            $this->cartCount = $cart->items()->sum('quantity');
        } else {
            $this->cartCount = 0;
        }
    }
    public function render()
    {
        return view('livewire.cart.cart-count');
    }
}
