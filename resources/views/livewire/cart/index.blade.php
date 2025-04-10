@section('title', 'Shopping Cart')
<div>
    <section class="breadcrumb breadcrumb-four padding-static-y-60 section-bg position-relative z-index-1 overflow-hidden">

        <img src="{{static_asset('images/gradients/breadcrumb-gradient-bg.png')}}" alt="" class="bg--gradient">

        <img src="{{static_asset('images/shapes/element-moon3.png')}}" alt="" class="element one">
        <img src="{{static_asset('images/shapes/element-moon1.png')}}" alt="" class="element three">

        <div class="container container-two">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="breadcrumb-four-content">
                        <h3 class="breadcrumb-four-content__title text-center mb-3 text-capitalize">Shopping Cart</h3>
                        <ul class="breadcrumb-list flx-align justify-content-center gap-2 mb-2">
                            <li class="breadcrumb-list__item font-14 text-body">
                                <a href="{{route('home')}}" wire:navigate class="breadcrumb-list__link text-body hover-text-main">Home</a>
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
                                <a href="{{route('cart')}}" wire:navigate class="process-list__link">
                                    <div class="icons">
                                        <span class="icon white"><img src="{{static_asset('images/icons/process-white1.svg')}}" alt=""></span>
                                    </div>
                                    <span class="text">Your Cart</span>
                                </a>
                            </li>
                            <li class="process-list__item ">
                                <a href="{{route('checkout')}}" wire:navigate class="process-list__link">
                                    <div class="icons">
                                        <span class="icon white"><img src="{{static_asset('images/icons/process-white3.svg')}}" alt=""></span>
                                        <span class="icon colored"><img src="{{static_asset('images/icons/process3.svg')}}" alt=""></span>
                                    </div>
                                    <span class="text">Checkout</span>
                                </a>
                            </li>
                            <li class="process-list__item">
                                <a href="cart-thank-you.html" wire:navigate class="process-list__link">
                                    <div class="icons">
                                        <span class="icon white"><img src="{{static_asset('images/icons/process-white4.svg')}}" alt=""></span>
                                        <span class="icon colored"><img src="{{static_asset('images/icons/process4.svg')}}" alt=""></span>
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


    <div class="cart padding-y-120">
        <div class="container">
            <div class="cart-content">
                <div class="table-responsive">
                    <table class="table style-two">
                        <thead>
                            <tr>
                                <th>Product Details</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="cart-item">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="cart-item__thumb">
                                                <a href="product-details.html" class="link">
                                                    <img src="{{static_asset('images/thumbs/product-img2.png')}}" alt="" class="cover-img">
                                                </a>
                                            </div>
                                            <div class="cart-item__content">
                                                <h6 class="cart-item__title font-heading fw-700 text-capitalize font-18 mb-4"> <a
                                                        href="product-details.html" class="link">Digital product name here</a></h6>
                                                <span class="cart-item__price font-18 text-heading fw-500">Category: <span
                                                        class="text-body font-14">WordPress</span></span>
                                            </div>
                                        </div>
                                        <div class="flx-align gap-4 mt-3 mt-lg-4">
                                            <div class="flx-align gap-2">
                                                <button type="button" class="product-card__wishlist style-two"><i class="fas fa-heart"></i></button>
                                                <span class="text-body">Add to wishlist</span>
                                            </div>
                                            <button type="button"
                                                class="rounded-btn delete-btn text-danger hover-text-decoration-underline">Remove</button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="cart-item__count">
                                        <button data-decrease="data-decrease"> <i class="fas fa-minus"></i></button>
                                        <input data-value="data-value" type="number" value="2">
                                        <button data-increase="data-increase"><i class="fas fa-plus"></i></button>
                                    </div>
                                </td>
                                <td>
                                    <span class="cart-item__totalPrice text-body font-18 fw-400 mb-0">$28.00</span>
                                </td>
                                <td>
                                    <span class="cart-item__totalPrice text-body font-18 fw-400 mb-0">$56.00</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="cart-item">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="cart-item__thumb">
                                                <a href="product-details.html" class="link">
                                                    <img src="{{static_asset('images/thumbs/product-img3.png')}}" alt="" class="cover-img">
                                                </a>
                                            </div>
                                            <div class="cart-item__content">
                                                <h6 class="cart-item__title font-heading fw-700 text-capitalize font-18 mb-4"> <a
                                                        href="product-details.html" class="link">Digital product name here</a></h6>
                                                <span class="cart-item__price font-18 text-heading fw-500">Category: <span
                                                        class="text-body font-14">WordPress</span></span>
                                            </div>
                                        </div>
                                        <div class="flx-align gap-4 mt-3 mt-lg-4">
                                            <div class="flx-align gap-2">
                                                <button type="button" class="product-card__wishlist style-two"><i class="fas fa-heart"></i></button>
                                                <span class="text-body">Add to wishlist</span>
                                            </div>
                                            <button type="button"
                                                class="rounded-btn delete-btn text-danger hover-text-decoration-underline">Remove</button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="cart-item__count">
                                        <button data-decrease="data-decrease"> <i class="fas fa-minus"></i></button>
                                        <input data-value="data-value" type="number" value="2">
                                        <button data-increase="data-increase"><i class="fas fa-plus"></i></button>
                                    </div>
                                </td>
                                <td>
                                    <span class="cart-item__totalPrice text-body font-18 fw-400 mb-0">$28.00</span>
                                </td>
                                <td>
                                    <span class="cart-item__totalPrice text-body font-18 fw-400 mb-0">$56.00</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="cart-item">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="cart-item__thumb">
                                                <a href="product-details.html" class="link">
                                                    <img src="{{static_asset('images/thumbs/product-img1.png')}}" alt="" class="cover-img">
                                                </a>
                                            </div>
                                            <div class="cart-item__content">
                                                <h6 class="cart-item__title font-heading fw-700 text-capitalize font-18 mb-4"> <a
                                                        href="product-details.html" class="link">Digital product name here</a></h6>
                                                <span class="cart-item__price font-18 text-heading fw-500">Category: <span
                                                        class="text-body font-14">WordPress</span></span>
                                            </div>
                                        </div>
                                        <div class="flx-align gap-4 mt-3 mt-lg-4">
                                            <div class="flx-align gap-2">
                                                <button type="button" class="product-card__wishlist style-two"><i class="fas fa-heart"></i></button>
                                                <span class="text-body">Add to wishlist</span>
                                            </div>
                                            <button type="button"
                                                class="rounded-btn delete-btn text-danger hover-text-decoration-underline">Remove</button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="cart-item__count">
                                        <button data-decrease="data-decrease"> <i class="fas fa-minus"></i></button>
                                        <input data-value="data-value" type="number" value="3">
                                        <button data-increase="data-increase"><i class="fas fa-plus"></i></button>
                                    </div>
                                </td>
                                <td>
                                    <span class="cart-item__totalPrice text-body font-18 fw-400 mb-0">$28.00</span>
                                </td>
                                <td>
                                    <span class="cart-item__totalPrice text-body font-18 fw-400 mb-0">$96.00</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="cart-content__bottom flx-between gap-2">
                    <a href="{{route('products')}}" wire:navigate class="btn btn-outline-light flx-align gap-2 pill btn-lg">
                        <span class="icon line-height-1 font-20"><i class="las la-arrow-left"></i></span>
                        Continue Shopping
                    </a>
                    <a href="{{route('checkout')}}" wire:navigate class="btn btn-main flx-align gap-2 pill btn-lg">
                        Next
                        <span class="icon line-height-1 font-20"><i class="las la-arrow-right"></i></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@section('meta')

@endsection
