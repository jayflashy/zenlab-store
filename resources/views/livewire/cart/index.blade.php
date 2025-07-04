@section('title', 'Shopping Cart')
<div>
    <x-cart-breadcrumb :step="1" step-title="Cart" />

    <div class="cart padding-y-120">
        <div class="container">
            <div class="cart-content">
                @if (count($cartItems) > 0)
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
                                @foreach ($cartItems as $item)
                                    <tr>
                                        <td>
                                            <div class="cart-item">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="cart-item__thumb">
                                                        <a href="{{ route('products.view', $item['product']['slug']) }}" wire:navigate
                                                            class="link">
                                                            <img src="{{ my_asset($item['product']['thumbnail']) }}"
                                                                alt="{{ $item['product']['name'] }}" class="cover-img">
                                                        </a>
                                                    </div>
                                                    <div class="cart-item__content">
                                                        <h6 class="cart-item__title font-heading fw-700 text-capitalize font-18 mb-2">
                                                            <a href="{{ route('products.view', $item['product']['slug']) }}" wire:navigate
                                                                class="link">{{ $item['product']['name'] }}</a>
                                                        </h6>
                                                        <div class="mb-2">
                                                            <span class="badge bg-light text-dark">
                                                                {{ ucfirst($item['license_type']) }} License
                                                                @if ($item['extended_support'])
                                                                    + Extended Support
                                                                @endif
                                                            </span>
                                                        </div>
                                                        <span class="cart-item__price font-18 text-heading fw-500">Category:
                                                            <span
                                                                class="text-body font-14">{{ $item['product']['category']['name'] ?? 'N/A' }}</span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="flx-align gap-4 mt-3 mt-lg-4">
                                                    <div class="flx-align gap-2">
                                                        @auth
                                                            <button type="button" class="product-card__wishlist style-two"
                                                                wire:click="addToWishlist('{{ $item['product_id'] }}')">
                                                                <i class="fas fa-heart text-danger"></i>
                                                            </button>
                                                            <span class="text-body">Add to wishlist</span>
                                                        @endauth
                                                    </div>
                                                    <button type="button" wire:click="removeItem('{{ $item['id'] }}')"
                                                        class="rounded-btn delete-btn px-1 text-danger hover-text-decoration-underline">
                                                        <i class="las la-times"></i> Remove
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cart-item__count">
                                                <button wire:click="updateQuantity('{{ $item['id'] }}', -1)">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" value="{{ $item['quantity'] }}" readonly>
                                                <button wire:click="updateQuantity('{{ $item['id'] }}', 1)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="cart-item__totalPrice text-body font-18 fw-400 mb-0">
                                                {{ format_price($item['price']) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="cart-item__totalPrice text-body font-18 fw-400 mb-0">
                                                {{ format_price($item['price'] * $item['quantity']) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-6 offset-lg-6">
                            <div class="cart-summary border p-4 rounded">
                                <h5 class="mb-3">Order Summary</h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal</span>
                                    <span>{{ format_price($cartTotal) }}</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-0">
                                    <strong>Total</strong>
                                    <strong>{{ format_price($cartTotal) }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="cart-content__bottom flx-between gap-2 mt-4">
                        <a href="{{ route('products') }}" wire:navigate class="btn btn-outline-light flx-align gap-2 pill btn-lg">
                            <span class="icon line-height-1 font-20"><i class="las la-arrow-left"></i></span>
                            Buy More
                        </a>
                        <a href="{{ route('checkout') }}" wire:navigate class="btn btn-main flx-align gap-2 pill btn-lg">
                            Checkout
                            <span class="icon line-height-1 font-20"><i class="las la-arrow-right"></i></span>
                        </a>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <img src="{{ static_asset('images/icons/cart.svg') }}" alt="Empty Cart" style="width: 100px;">
                        </div>
                        <h3 class="mb-3">Your cart is empty</h3>
                        <p class="mb-4">Looks like you haven't added anything to your cart yet.</p>
                        <a href="{{ route('products') }}" wire:navigate class="btn btn-main pill">
                            Browse Products
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@include('layouts.meta')
