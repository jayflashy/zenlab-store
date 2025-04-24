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
    public $subtotal = 0;
    public $total = 0;
    public $processingPayment = false;
    public $paymentGateways = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'paymentMethod' => 'required|string',
    ];

    public function mount()
    {
        $this->loadCart();
        $this->fillUserInfo();
        if ($this->cart->items->isEmpty()) {
            $this->redirect(route('cart'), navigate: true);
        }
        $this->paymentGateways = [
            ['name' => 'Paypal', 'key' => 'paypal_payment', 'image' => 'paypal.png'],
            ['name' => 'Paystack', 'key' => 'paystack_payment', 'image' => 'card.png'],
            ['name' => 'Flutterwave', 'key' => 'flutterwave_payment', 'image' => 'card.png'],
            ['name' => 'Cryptomus', 'key' => 'cryptomus_payment', 'image' => 'cryptomus.png'],
            ['name' => 'Bank Transfer', 'key' => 'manual_payment', 'image' => 'bank.png'],
        ];
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

            $this->total = $this->subtotal - $this->discount;
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
            $this->total = $this->subtotal - $this->discount;
            $this->toast('success', 'Coupon applied successfully!');
        } elseif (strtoupper($this->couponCode) === 'FREESHIPPING') {
            $this->total = $this->subtotal - $this->discount;
            $this->toast('success', 'Free shipping coupon applied!');
        } else {
            $this->discount = 0;
            $this->total = $this->subtotal;
            $this->toast('error', 'Invalid coupon code');
        }
    }
    public function processPayment()
    {
        $this->validate();
        $this->processingPayment = true;
        if ($this->cart->items->isEmpty()) {
            $this->processingPayment = false;
            $this->errorAlert('Cart is empty');
            return;
        }
        try {
            DB::beginTransaction();
            // Create order
            $order = Order::create([
                'user_id' => Auth::check() ? Auth::id() : null,
                'email' => $this->email,
                'name' => $this->name,
                'code' => getTrx(8),
                'subtotal' => $this->subtotal,
                'discount' => $this->discount,
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

            // redirect to payment provider.
            // For this simulation, we're just adding a delay
            sleep(1);

            // Update payment status based on selected method
            if ($this->paymentMethod === 'bank_transfer') {
                // Bank transfer stays pending until manually approved
                $order->payment_status = 'pending';
                $order->order_status = 'pending';
                $order->notes = 'Awaiting bank transfer confirmation';
            } else {

                $order->payment_status = 'paid';
                $order->order_status = 'processing';
            }
            $order->save();

            $this->cart->status = 'completed';
            $this->cart->delete();

            DB::commit();

            // Redirect to success page
            $this->redirect(route('payment.success',  $order->code), navigate: true);
            return redirect()->route('payment.success', ['order_id' => $order->id]);
        } catch (\Exception $e) {
            DB::rollback();
            $this->processingPayment = false;
            $this->toast('error', 'Error processing payment: ' . $e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.cart.checkout');
    }
}
