@section('title', 'Checkout')
<div>

    <section class="breadcrumb breadcrumb-four padding-static-y-60 section-bg position-relative z-index-1 overflow-hidden">

        <img src="{{ static_asset('images/gradients/breadcrumb-gradient-bg.png') }}" alt="" class="bg--gradient">

        <img src="{{ static_asset('images/shapes/element-moon3.png') }}" alt="" class="element one">
        <img src="{{ static_asset('images/shapes/element-moon1.png') }}" alt="" class="element three">

        <div class="container container-two">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="breadcrumb-four-content">
                        <h3 class="breadcrumb-four-content__title text-center mb-3 text-capitalize">Shopping Cart</h3>
                        <ul class="breadcrumb-list flx-align justify-content-center gap-2 mb-2">
                            <li class="breadcrumb-list__item font-14 text-body">
                                <a href="{{ route('home') }}" wire:navigate class="breadcrumb-list__link text-body hover-text-main">Home</a>
                            </li>
                            <li class="breadcrumb-list__item font-14 text-body">
                                <span class="breadcrumb-list__icon font-10"><i class="fas fa-chevron-right"></i></span>
                            </li>
                            <li class="breadcrumb-list__item font-14 text-body">
                                <span class="breadcrumb-list__text">Cart</span>
                            </li>
                        </ul>

                        <ul class="process-list">
                            <li class="process-list__item activePage">
                                <a href="{{ route('cart') }}" wire:navigate class="process-list__link">
                                    <div class="icons">
                                        <span class="icon white"><img src="{{ static_asset('images/icons/process-white1.svg') }}"
                                                alt=""></span>
                                    </div>
                                    <span class="text">Your Cart</span>
                                </a>
                            </li>
                            <li class="process-list__item activePage">
                                <a href="{{ route('checkout') }}" wire:navigate class="process-list__link">
                                    <div class="icons">
                                        <span class="icon white"><img src="{{ static_asset('images/icons/process-white3.svg') }}"
                                                alt=""></span>
                                        <span class="icon colored"><img src="{{ static_asset('images/icons/process3.svg') }}"
                                                alt=""></span>
                                    </div>
                                    <span class="text">Checkout</span>
                                </a>
                            </li>
                            <li class="process-list__item">
                                <a href="cart-thank-you.html" wire:navigate class="process-list__link">
                                    <div class="icons">
                                        <span class="icon white"><img src="{{ static_asset('images/icons/process-white4.svg') }}"
                                                alt=""></span>
                                        <span class="icon colored"><img src="{{ static_asset('images/icons/process4.svg') }}"
                                                alt=""></span>
                                    </div>
                                    <span class="text">Complete</span>
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cart-personal padding-y-120">
        <div class="container container-two">
            <div class="row gy-5">
                <div class="col-lg-8 pe-sm-5">
                    <div class="cart-personal__content">
                        <h5 class="cart-personal__title mb-32">Personal information</h5>
                        <form action="#">
                            <div class="mb-4">
                                <label for="email" class="form-label font-18 mb-2 fw-500 font-heading">Email Address <span
                                        class="text-danger">*</span> </label>
                                <input type="email" class="common-input" id="email" name="email" placeholder="Email address">
                            </div>
                            <div class="mb-4">
                                <label for="name" class="form-label font-18 mb-2 fw-500 font-heading">Full Name <span
                                        class="text-danger">*</span> </label>
                                <input type="text" class="common-input" id="name" name="name" placeholder="Full name">
                            </div>
                        </form>
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
                                                    <input class="form-check-input" type="radio" name="radio" id="paypal">
                                                    <label class="form-check-label" for="paypal"> </label>
                                                </div>
                                                <div class="">
                                                    <h6 class="font-16 mb-0">Paypal </h6>
                                                </div>
                                            </div>
                                            <div class="payment-select-card__logo">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/PayPal.svg/800px-PayPal.svg.png"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="payment-select-card mb-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="common-check common-radio mb-0">
                                                    <input class="form-check-input" type="radio" name="radio" id="paypal">
                                                    <label class="form-check-label" for="paypal"> </label>
                                                </div>
                                                <div class="">
                                                    <h6 class="font-16 mb-0">Paypal </h6>

                                                </div>
                                            </div>
                                            <div class="payment-select-card__logo">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/PayPal.svg/800px-PayPal.svg.png"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="payment-select-card mb-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="common-check common-radio mb-0">
                                                    <input class="form-check-input" type="radio" name="radio" id="paypal">
                                                    <label class="form-check-label" for="paypal"> </label>
                                                </div>
                                                <div class="">
                                                    <h6 class="font-16 mb-0">Paypal </h6>

                                                </div>
                                            </div>
                                            <div class="payment-select-card__logo">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/PayPal.svg/800px-PayPal.svg.png"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="payment-select-card mb-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="common-check common-radio mb-0">
                                                    <input class="form-check-input" type="radio" name="radio" id="paypal">
                                                    <label class="form-check-label" for="paypal"> </label>
                                                </div>
                                                <div class="">
                                                    <h6 class="font-16 mb-0">Paypal </h6>

                                                </div>
                                            </div>
                                            <div class="payment-select-card__logo">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/PayPal.svg/800px-PayPal.svg.png"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="cart-content__bottom flx-between gap-2">
                        <a href="{{ route('cart') }}" wire:navigate class="btn btn-outline-light flx-align gap-2 pill btn-lg">
                            <span class="icon line-height-1 font-20"><i class="las la-arrow-left"></i></span>
                            Back
                        </a>
                        <a href="{{route('payment.success')}}" wire:navigate class="btn btn-main flx-align gap-2 pill btn-lg">
                            Proceed To Payment
                        </a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="order-summary">
                        <h5 class="order-summary__title mb-32">Order Summary</h5>
                        <ul class="billing-list">
                            <li class="billing-list__item flx-between">
                                <span class="text text-heading fw-500">You have 3 items</span>
                                <span class="amount text-heading fw-500">$259.00</span>
                            </li>
                            <li class="billing-list__item flx-between">
                                <span class="text text-heading fw-500">Discount</span>
                                <span class="amount text-body">$00.00</span>
                            </li>
                            <li class="billing-list__item flx-between">
                                <span class="text text-heading fw-500">Handling Fee</span>
                                <span class="amount text-body">$15.00</span>
                            </li>
                            <li class="billing-list__item flx-between">
                                <span class="text text-heading fw-500">Subtotal</span>
                                <span class="amount text-body">$15.00</span>
                            </li>
                            <li class="billing-list__item flx-between">
                                <span class="text text-heading font-20 fw-500 font-heading">Total</span>
                                <span class="amount text-heading font-20 fw-500 font-heading">$274.00</span>
                            </li>
                        </ul>

                    </div>
                    <div class="order-summary mt-3">
                        <h5 class="order-summary_title mb-32">Apply Coupon</h5>
                        <form action="#" class="apply-coupon flx-align gap-3">
                            <input type="text" class="common-input common-input--md w-auto pill" placeholder="Coupon code">
                            <button type="submit" class="btn btn-main btn-md w-auto py-3 px-4 flx-align gap-2 pill fw-300">
                                Apply</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@section('meta')

@endsection
