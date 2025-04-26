<?php

namespace App\Livewire\Cart;

use App\Http\Controllers\PaymentController;
use App\Models\Cart;
use App\Services\OrderService;
use App\Traits\LivewireToast;
use Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Checkout extends Component
{
    use LivewireToast;
    use WithFileUploads;

    public $cart;

    public $cartItems = [];

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

    protected $orderService;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'paymentMethod' => 'required|string',
    ];

    protected $bankTransferRules = [
        'paymentReceipt' => 'required|image|max:2048',
        'bankReference' => 'required|string|max:255',
    ];

    public function boot(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

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
            ['name' => 'Crypto', 'key' => 'cryptomus_payment', 'image' => 'cryptomus.png'],
            ['name' => 'Bank Transfer', 'key' => 'manual_payment', 'image' => 'bank.png'],
        ];
    }

    public function loadCart()
    {
        $this->cart = Cart::getCurrentCart();
        if ($this->cart) {
            // Load cart items with products
            $this->cartItems = $this->cart->items()->with('product.category')->get()->toArray();

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
            $orderData = [
                'name' => $this->name,
                'email' => $this->email,
                'subtotal' => $this->subtotal,
                'discount' => $this->discount,
                'total' => $this->total,
                'payment_method' => $this->paymentMethod,
            ];

            $order = $this->orderService->createOrder($orderData, $this->cart);

            if ($this->paymentMethod === 'manual_payment') {
                $this->currentOrder = $order;
                $this->showBankTransfer = true;
                $this->processingPayment = false;
                $this->totalNgn = $this->totalToNgn();

                return;
            }
            $paymentData = [
                'email' => $this->email,
                'name' => $this->name,
                'amount' => $this->total,
                'ngn_amount' => round($this->totalToNgn()),
                'order_id' => $order->id,
                'currency' => get_setting('currency_code'),
                'reference' => $order->code,
                'description' => 'Order #'.$order->code,
            ];

            // process payment
            $paymentController = app(PaymentController::class);

            return match ($this->paymentMethod) {
                'paystack_payment' => $paymentController->initPaystack($paymentData),
                'flutterwave_payment' => $paymentController->initFlutter($paymentData),
                'paypal_payment' => $paymentController->initPaypal($paymentData),
                'cryptomus_payment' => $paymentController->initCryptomus($paymentData),
                default => throw new \Exception('Invalid payment method selected'),
            };
        } catch (\Exception $e) {
            $this->processingPayment = false;
            \Log::error($e);
            $this->toast('error', 'Unable to process your payment at this time. Please try again later.');
        }
    }

    public function totalToNgn()
    {
        if(get_setting('currency_code') === 'NGN') {
            return $this->total;
        }
        $rate = (float) get_setting('currency_rate', 1);

        return ($this->total * $rate);
    }

    public function uploadBankTransferReceipt()
    {
        $this->validate($this->bankTransferRules);

        try {
            // Upload receipt file
            $receiptPath = $this->paymentReceipt->store('payment_receipts', 'uploads');

            // Process manual payment
            $this->orderService->processManualPayment(
                $this->currentOrder,
                $receiptPath,
                $this->bankReference
            );
            // Empty cart
            $this->cart->delete();

            // Reset form
            $this->showBankTransfer = false;
            $this->paymentReceipt = null;
            $this->bankReference = null;

            $this->successAlert('Payment receipt uploaded successfully. We will verify your payment shortly.');
            $this->redirect(route('payment.success', $this->currentOrder->code), navigate: true);
        } catch (\Exception $e) {
            $this->toast('error', 'Error uploading receipt: ');
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
