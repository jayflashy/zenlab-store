@section('title', 'Checkout')
<div>
    <x-cart-breadcrumb :step="2" step-title="Checkout" />

    <div class="cart-personal padding-y-120">
        <div class="container container-two">
            <div class="row gy-5">
                <div class="col-lg-8 pe-sm-5">
                    <div class="cart-personal__content">
                        <h5 class="cart-personal__title mb-32">Personal information</h5>
                        <form wire:submit.prevent="processPayment">
                            <div class="mb-4">
                                <label for="email" class="form-label font-18 mb-2 fw-500 font-heading">Email Address <span
                                        class="text-danger">*</span> </label>
                                <input type="email" class="common-input" id="email" wire:model="email" placeholder="Email address"
                                    required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="name" class="form-label font-18 mb-2 fw-500 font-heading">Full Name <span
                                        class="text-danger">*</span> </label>
                                <input type="text" class="common-input" id="name" wire:model="name" placeholder="Full name"
                                    required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="card common-card shadow mt-4">
                                <div class="card-header p-4 bg-white">
                                    <h6 class="mb-0">Payment Method</h6>
                                </div>
                                <div class="card-body p-4">
                                    <div class="payment-select-card-wrapper row">
                                        <div class="col-sm-6">
                                            <div class="payment-select-card mb-4">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="common-check common-radio mb-0">
                                                            <input class="form-check-input" type="radio" wire:model="paymentMethod"
                                                                value="paypal" id="paypal" required>
                                                            <label class="form-check-label" for="paypal"> </label>
                                                        </div>
                                                        <div class="">
                                                            <h6 class="font-16 mb-0">PayPal</h6>
                                                        </div>
                                                    </div>
                                                    <div class="payment-select-card__logo">
                                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/PayPal.svg/800px-PayPal.svg.png"
                                                            alt="PayPal">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="payment-select-card mb-4">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="common-check common-radio mb-0">
                                                            <input class="form-check-input" type="radio" wire:model="paymentMethod"
                                                                value="credit_card" id="credit_card">
                                                            <label class="form-check-label" for="credit_card"> </label>
                                                        </div>
                                                        <div class="">
                                                            <h6 class="font-16 mb-0">Credit Card</h6>
                                                        </div>
                                                    </div>
                                                    <div class="payment-select-card__logo">
                                                        <img src="/images/credit-card.png" alt="Credit Card">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="payment-select-card mb-4">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="common-check common-radio mb-0">
                                                            <input class="form-check-input" type="radio" wire:model="paymentMethod"
                                                                value="stripe" id="stripe">
                                                            <label class="form-check-label" for="stripe"> </label>
                                                        </div>
                                                        <div class="">
                                                            <h6 class="font-16 mb-0">Stripe</h6>
                                                        </div>
                                                    </div>
                                                    <div class="payment-select-card__logo">
                                                        <img src="/images/stripe.png" alt="Stripe">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="payment-select-card mb-4">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="common-check common-radio mb-0">
                                                            <input class="form-check-input" type="radio" wire:model="paymentMethod"
                                                                value="bank_transfer" id="bank_transfer">
                                                            <label class="form-check-label" for="bank_transfer"> </label>
                                                        </div>
                                                        <div class="">
                                                            <h6 class="font-16 mb-0">Bank Transfer</h6>
                                                        </div>
                                                    </div>
                                                    <div class="payment-select-card__logo">
                                                        <img src="/images/bank.png" alt="Bank Transfer">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @error('paymentMethod')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="cart-content__bottom flx-between gap-2 mt-4">
                                <a href="{{ route('cart') }}" wire:navigate class="btn btn-outline-light flx-align gap-2 pill btn-lg">
                                    <span class="icon line-height-1 font-20"><i class="las la-arrow-left"></i></span>
                                    Back to Cart
                                </a>
                                <button type="submit" class="btn btn-main flx-align gap-2 pill btn-lg" wire:loading.attr="disabled"
                                    wire:loading.class="disabled">
                                    <span wire:loading wire:target="processPayment">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Processing...
                                    </span>
                                    <span wire:loading.remove wire:target="processPayment">
                                        Complete Payment
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="order-summary">
                        <h5 class="order-summary__title mb-32">Order Summary</h5>
                        <ul class="billing-list">
                            <li class="billing-list__item flx-between">
                                <span class="text text-heading fw-500">You have {{ count($cartItems) }} item(s)</span>
                                <span class="amount text-heading fw-500">{{ format_price($subtotal) }}</span>
                            </li>
                            <li class="billing-list__item flx-between">
                                <span class="text text-heading fw-500">Discount</span>
                                <span class="amount text-body">{{ format_price($discount) }}</span>
                            </li>
                            <li class="billing-list__item flx-between">
                                <span class="text text-heading fw-500">Handling Fee</span>
                                <span class="amount text-body">{{ format_price($handlingFee) }}</span>
                            </li>
                            <li class="billing-list__item flx-between">
                                <span class="text text-heading fw-500">Subtotal</span>
                                <span class="amount text-body">{{ format_price($subtotal) }}</span>
                            </li>
                            <li class="billing-list__item flx-between">
                                <span class="text text-heading font-20 fw-500 font-heading">Total</span>
                                <span class="amount text-heading font-20 fw-500 font-heading">{{ format_price($total) }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="order-summary mt-3">
                        <h5 class="order-summary_title mb-32">Apply Coupon</h5>
                        <div class="apply-coupon flx-align gap-3">
                            <input type="text" wire:model="couponCode" class="common-input common-input--md w-auto pill"
                                placeholder="Coupon code">
                            <button type="button" wire:click="applyCoupon" wire:loading.attr="disabled"
                                class="btn btn-main btn-md w-auto py-3 px-4 flx-align gap-2 pill fw-300">
                                <span wire:loading wire:target="applyCoupon">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                </span>
                                <span wire:loading.remove wire:target="applyCoupon">Apply</span>
                            </button>
                        </div>
                    </div>

                    @if (count($cartItems) > 0)
                        <div class="order-summary mt-3">
                            <h5 class="order-summary_title mb-3">Your Items</h5>
                            <div class="cart-items-summary">
                                @foreach ($cartItems as $item)
                                    <div class="cart-item-mini mb-2 p-2 border-bottom">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h6 class="mb-0">{{ $item['product']['name'] }}</h6>
                                                <small>{{ ucfirst($item['license_type']) }} License</small>
                                                @if ($item['extended_support'])
                                                    <br><small>Extended Support</small>
                                                @endif
                                            </div>
                                            <div class="text-end">
                                                <div>{{ format_price($item['price']) }}</div>
                                                <small>Qty: {{ $item['quantity'] }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.meta')
