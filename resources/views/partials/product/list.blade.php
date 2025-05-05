<div class="col-xl-4 col-sm-6">
    <div class="product-item section-bg">
        <div class="product-item__thumb d-flex">
            <a href="{{ route('products.view', $product->slug) }}" wire:navigate class="link w-100">
                <img src="{{ $product->thumbnail ? my_asset($product->thumbnail) : my_asset('products/default.jpg') }}"
                    alt="{{ $product->name }}" class="cover-img">
            </a>
            @livewire('product.wishlist-button', ['product' => $product], key('wishlist-' . $product->id))
        </div>
        <div class="product-item__content">
            <h6 class="product-item__title">
                <a href="{{ route('products.view', $product->slug) }}" wire:navigate class="link">{{ $product->name }}</a>
            </h6>
            <div class="product-item__info flx-between gap-2">
                <span class="product-item__author">
                    by
                    <a href="#" class="link hover-text-decoration-underline">
                        {{ $product->author ?? 'Jadesdev' }}
                    </a>
                </span>
                <div class="flx-align gap-2">
                    <h6 class="product-item__price mb-0">{{ format_price($product->final_price) }}</h6>
                    @if ($product->discount > 0)
                        <span class="product-item__prevPrice text-decoration-line-through">
                            {{ format_price($product->regular_price) }}
                        </span>
                    @endif
                </div>
            </div>
            <div class="product-item__bottom flx-between gap-2">
                <div>
                    <span class="product-item__sales font-14 mb-2">{{ $product->total_sales }} Sales</span>
                    <div class="d-flex align-items-center gap-1">
                        <ul class="star-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <li class="star-rating__item font-11">
                                    <i class="fas fa-star {{ $i <= $product->averageRating() ? 'text-warning' : 'text-muted' }}">
                                    </i>
                                </li>
                            @endfor
                        </ul>
                        <span class="star-rating__text text-heading fw-500 font-14">
                            ({{ $product->ratingCount() }})
                        </span>
                    </div>
                </div>
                <a href="{{ $product->demo_url ?? '#' }}" class="btn btn-outline-light btn-sm pill">
                    Live Demo
                </a>
            </div>
        </div>
    </div>
</div>
