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
                            <span class="breadcrumb-list__text">{{ $stepTitle }}</span>
                        </li>
                    </ul>

                    <ul class="process-list">
                        <li class="process-list__item {{ $step >= 1 ? 'activePage' : '' }}">
                            <a href="{{ route('cart') }}" wire:navigate class="process-list__link">
                                <div class="icons">
                                    <span class="icon white"><img src="{{ static_asset('images/icons/process-white1.svg') }}"
                                            alt=""></span>
                                </div>
                                <span class="text">Your Cart</span>
                            </a>
                        </li>
                        <li class="process-list__item {{ $step >= 2 ? 'activePage' : '' }}">
                            <a href="javascript:void(0)" class="process-list__link">
                                <div class="icons">
                                    <span class="icon white"><img src="{{ static_asset('images/icons/process-white3.svg') }}"
                                            alt=""></span>
                                    <span class="icon colored"><img src="{{ static_asset('images/icons/process3.svg') }}"
                                            alt=""></span>
                                </div>
                                <span class="text">Checkout</span>
                            </a>
                        </li>
                        <li class="process-list__item {{ $step === 3 ? 'activePage' : '' }}">
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
