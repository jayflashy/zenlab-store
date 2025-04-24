<?php

namespace App\Livewire\Cart;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Traits\LivewireToast;
use Auth;
use DB;
use Livewire\Component;

class Checkout extends Component
{
    use LivewireToast;

    public $cart;
    public $cartItems = [];
    public $cartTotal = 0;
    public $name;
    public $email;
    public $paymentMethod = '';
    public $couponCode = '';
    public $discount = 0;
    public $handlingFee = 00;
    public $subtotal = 0;
    public $total = 0;
    public $processingPayment = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'paymentMethod' => 'required|string',
    ];

    public function mount()
    {
        $this->loadCart();
        $this->fillUserInfo();
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

            // Calculate totals
            $this->subtotal = $this->cart->items->sum(function ($item) {
                return ($item->price * $item->quantity);
            });

            $this->total = $this->subtotal + $this->handlingFee - $this->discount;
        }
    }

    public function fillUserInfo()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $this->name = $user->name;
            $this->email = $user->email;
        }
    }

    public function applyCoupon()
    {
        if ($this->couponCode === '') {
            $this->toast('error', 'Please enter a coupon code');
            return;
        }

        if (strtoupper($this->couponCode) === 'DISCOUNT10') {
            $this->discount = round($this->subtotal * 0.1, 2); // 10% discount
            $this->total = $this->subtotal + $this->handlingFee - $this->discount;
            $this->toast('success', 'Coupon applied successfully!');
        } elseif (strtoupper($this->couponCode) === 'FREESHIPPING') {
            $this->handlingFee = 0;
            $this->total = $this->subtotal + $this->handlingFee - $this->discount;
            $this->toast('success', 'Free shipping coupon applied!');
        } else {
            $this->discount = 0;
            $this->handlingFee = 15.00;
            $this->total = $this->subtotal + $this->handlingFee;
            $this->toast('error', 'Invalid coupon code');
        }
    }
    public function processPayment()
    {
        $this->validate();
        $this->processingPayment = true;
        try {
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'user_id' => Auth::check() ? Auth::id() : null,
                'email' => $this->email,
                'name' => $this->name,
                'code' => getTrx(8), // Generate a unique order ode,
                'subtotal' => $this->subtotal,
                'discount' => $this->discount,
                'handling_fee' => $this->handlingFee,
                'total' => $this->total,
                'payment_method' => $this->paymentMethod,
                'payment_status' => 'pending',
                'order_status' => 'pending',
            ]);

            // Create order items
            foreach ($this->cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'license_type' => $item->license_type,
                    'extended_support' => $item->extended_support,
                    'support_price' => $item->support_price,
                    'total' => $item->price * $item->quantity,
                ]);
            }

            // For this simulation, we're just adding a delay
            sleep(1);

            // Update payment status based on selected method
            if ($this->paymentMethod === 'bank_transfer') {
                // Bank transfer stays pending until manually approved
                $order->payment_status = 'pending';
                $order->order_status = 'pending';
                $order->notes = 'Awaiting bank transfer confirmation';
            } else {
                // Other payment methods (credit_card, paypal, stripe) are auto-approved in this simulation
                $order->payment_status = 'paid';
                $order->order_status = 'processing';
            }
            $order->save();

            // Clear the cart
            $this->cart->status = 'completed';
            $this->cart->save();

            DB::commit();

            // Redirect to success page
            return redirect()->route('payment.success', ['order_id' => $order->id]);
        } catch (\Exception $e) {
            DB::rollback();
            $this->processingPayment = false;
            $this->toast('error', 'Error processing payment: ' . $e->getMessage());
        }

        // Redirect to success page
        $this->redirect(route('payment.success', ['order_id' => $order->code]), navigate: true);
    }
    public function render()
    {
        return view('livewire.cart.checkout');
    }
}
