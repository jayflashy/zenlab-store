<?php

namespace App\Livewire\Cart;

use App\Http\Controllers\PaymentController;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Traits\LivewireToast;
use Auth;
use DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Checkout extends Component
{
    use LivewireToast;
    use WithFileUploads;

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

    public $totalNgn = 0;

    public $processingPayment = false;

    public $showBankTransfer = false;

    public $paymentReceipt;

    public $bankReference;

    public $currentOrder;

    public $paymentGateways = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'paymentMethod' => 'required|string',
    ];

    protected $bankTransferRules = [
        'paymentReceipt' => 'required|image|max:2048',
        'bankReference' => 'required|string|max:255',
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
                return $item->price * $item->quantity;
            });

            $this->total = $this->subtotal - $this->discount;
            $this->totalNgn = $this->totalToNgn();
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
            // create a new account if a guest user based on their email.
            if (! Auth::check()) {
                $user = User::firstOrCreate([
                    'email' => $this->email,
                ], [
                    'name' => $this->name,
                    'password' => bcrypt(getTrx(18)),
                    'status' => 'active',
                    'username' => text_trimer($this->name, 12),
                ]);
                // Merge carts
                Cart::mergeGuestCart($user->id, session()->getId());

                Auth::login($user);
                // TODO: send welcome email?
            }

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

            DB::commit();
            $paymentData = [
                'email' => $this->email,
                'name' => $this->name,
                // 'order' => $order,
                'amount' => $this->total,
                'ngn_amount' => $this->total * get_setting('currency_rate'),
                'order_id' => $order->id,
                'currency' => get_setting('currency_code'),
                'reference' => $order->code,
                'description' => 'Order #' . $order->code,
            ];

            if ($this->paymentMethod === 'manual_payment') {
                $this->currentOrder = $order;
                $this->showBankTransfer = true;
                $this->processingPayment = false;
                $this->totalNgn = $this->totalToNgn();
                return;
            }

            $paymentController = app(PaymentController::class);

            return match ($this->paymentMethod) {
                'paystack_payment' => $paymentController->initPaystack($paymentData),
                'flutterwave_payment' => $paymentController->initFlutter($paymentData),
                'paypal_payment' => $paymentController->initPaypal($paymentData),
                'cryptomus_payment' => $paymentController->initCryptomus($paymentData),
                default => throw new \Exception('Invalid payment method selected'),
            };

            // Redirect to success page
            $this->redirect(route('payment.success', $order->code), navigate: true);
        } catch (\Exception $e) {
            DB::rollback();
            $this->processingPayment = false;
            $this->toast('error', 'Error processing payment: ' . $e->getMessage());
        }
    }
    function totalToNgn()
    {
        if (get_setting('currency_code') === 'NGN') {
            return $this->total;
        }
        return $this->total * get_setting('currency_rate');
    }

    public function uploadBankTransferReceipt()
    {
        $this->validate($this->bankTransferRules);

        try {
            // Upload receipt file
            $receiptPath = $this->paymentReceipt->store('payment_receipts', 'uploads');

            // Update order with receipt information
            $this->currentOrder->payment_receipt = $receiptPath;
            $this->currentOrder->bank_reference = $this->bankReference;
            $this->currentOrder->notes = 'Manual payment receipt uploaded. Reference: ' . $this->bankReference;
            $this->currentOrder->save();

            // Empty cart
            $this->cart->delete();

            // Reset form
            $this->showBankTransfer = false;
            $this->paymentReceipt = null;
            $this->bankReference = null;

            $this->successAlert('Payment receipt uploaded successfully. We will verify your payment shortly.');
            $this->redirect(route('payment.success', $this->currentOrder->code), navigate: true);
        } catch (\Exception $e) {
            $this->toast('error', 'Error uploading receipt: ' . $e->getMessage());
        }
    }

    public function closeBankTransferModal()
    {
        $this->showBankTransfer = false;
        $this->paymentReceipt = null;
        $this->bankReference = null;
    }
    public function render()
    {
        return view('livewire.cart.checkout');
    }
}
