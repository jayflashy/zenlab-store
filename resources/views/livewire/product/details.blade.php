<div>
    <section class="breadcrumb border-bottom p-0 d-block section-bg position-relative z-index-1">
        <div class="breadcrumb-two">
            <img src="{{ static_asset('images/gradients/breadcrumb-gradient-bg.png') }}" alt="" class="bg--gradient">
            <div class="container container-two">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="breadcrumb-two-content">

                            <ul class="breadcrumb-list flx-align gap-2 mb-2">
                                <li class="breadcrumb-list__item font-14 text-body">
                                    <a href="{{ route('home') }}" wire:navigate
                                        class="breadcrumb-list__link text-body hover-text-main">Home</a>
                                </li>
                                <li class="breadcrumb-list__item font-14 text-body">
                                    <span class="breadcrumb-list__icon font-10"><i class="fas fa-chevron-right"></i></span>
                                </li>
                                <li class="breadcrumb-list__item font-14 text-body">
                                    <a href="{{ route('products') }}" wire:navigate
                                        class="breadcrumb-list__link text-body hover-text-main">Products</a>
                                </li>
                                <li class="breadcrumb-list__item font-14 text-body">
                                    <span class="breadcrumb-list__icon font-10"><i class="fas fa-chevron-right"></i></span>
                                </li>
                                <li class="breadcrumb-list__item font-14 text-body">
                                    <span class="breadcrumb-list__text">{{ $product->category->name ?? 'Scripts' }}</span>
                                </li>
                            </ul>

                            <h3 class="breadcrumb-two-content__title mb-3 text-capitalize">{{ $product->name }}</h3>

                            <div class="breadcrumb-content flx-align gap-3">
                                <div class="breadcrumb-content__item text-heading fw-500 flx-align gap-2">
                                    <span class="icon">
                                        <img src="{{ static_asset('images/icons/cart-icon.svg') }}" alt="" class="white-version">
                                        <img src="{{ static_asset('images/icons/cart-white.svg') }}" alt=""
                                            class="dark-version w-20">
                                    </span>
                                    <span class="text">{{ $product->total_sales }} sales</span>
                                </div>
                                <div class="breadcrumb-content__item text-heading fw-500 flx-align gap-2">
                                    <span class="icon">
                                        <img src="{{ static_asset('images/icons/check-icon.svg') }}" alt="" class="white-version">
                                        <img src="{{ static_asset('images/icons/check-icon-white.svg') }}" alt=""
                                            class="dark-version">
                                    </span>
                                    @if ($product->publish_date >= now()->subMonths(2))
                                        <span class="text">Recently Updated</span>
                                    @endif
                                </div>
                                <div class="breadcrumb-content__item text-heading fw-500 flx-align gap-2">
                                    <span class="icon">
                                        <img src="{{ static_asset('images/icons/check-icon.svg') }}" alt="" class="white-version">
                                        <img src="{{ static_asset('images/icons/check-icon-white.svg') }}" alt=""
                                            class="dark-version">
                                    </span>
                                    <span class="text">Well Documented</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container container-two">
            <div class="breadcrumb-tab flx-wrap align-items-start gap-lg-4 gap-2">
                <ul class="nav tab-bordered nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-product-details-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-product-details" type="button" role="tab" aria-controls="pills-product-details"
                            aria-selected="true">Product Details</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-rating-tab" data-bs-toggle="pill" data-bs-target="#pills-rating" type="button"
                            role="tab" aria-controls="pills-rating" aria-selected="false" tabindex="-1">
                            <x-star-rating :rating="$product->averageRating()" :count="$product->ratingCount()" />

                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-comments-tab" data-bs-toggle="pill" data-bs-target="#pills-comments"
                            type="button" role="tab" aria-controls="pills-comments" aria-selected="false" tabindex="-1">Comments
                            ({{ $product->commentCount() }})</button>
                    </li>
                </ul>
                <div class="social-share pb-3">
                    <x-share-buttons url="{{ url()->current() }}" title="{{ $product->name }}" />
                </div>
            </div>
        </div>

    </section>
    {{-- pruduct details --}}
    <div class="product-details mt-32 padding-b-120">
        <div class="container container-two">
            <div class="row gy-4">
                <div class="col-lg-8">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-product-details" role="tabpanel"
                            aria-labelledby="pills-product-details-tab" tabindex="0">
                            <!-- Product Details Content Start -->
                            <div class="product-details">
                                <div class="product-details__thumb">
                                    <img src="{{ my_asset($product->image) }}" alt="{{ $product->name }}">
                                </div>
                                <div class="product-details__buttons flx-align justify-content-center gap-3">
                                    <a href="{{ $product->demo_url }}" target="_blank"
                                        class="btn btn-main d-inline-flex align-items-center gap-2 pill px-sm-5 justify-content-center">
                                        Live Preview
                                        <img src="{{ static_asset('images/icons/eye-outline.svg') }}" alt="Preview">
                                    </a>

                                    <a href="javascript:void(0)" class="screenshot-btn btn btn-white pill px-sm-5"
                                        data-images='[
                                        @foreach ($product->screenshot_images as $screenshot)
                                            "{{ my_asset($screenshot) }}"@if (!$loop->last), @endif @endforeach
                                        ]'>
                                        Screenshots
                                    </a>


                                </div>


                                <div class="product-details__item">
                                    <p class="product-details__desc">
                                        {!! $product->description !!}
                                    </p>
                                </div>

                                <div class="more-item">
                                    <div class="flx-between mb-4">
                                        <h5 class="more-item__title">Related Products</h5>
                                    </div>

                                    <div class="related-product-slider more-item__content flx-align">
                                        @foreach ($relatedProducts as $relatedProduct)
                                            @include('partials.product.related')
                                        @endforeach

                                        @if (count($relatedProducts) < 5)
                                            {{-- Add the same products again if we have fewer than 5 --}}
                                            @foreach ($relatedProducts as $relatedProduct)
                                                @include('partials.product.related')
                                            @endforeach
                                        @endif

                                        @if (count($relatedProducts) < 3)
                                            {{-- Add them a third time if we have fewer than 3 --}}
                                            @foreach ($relatedProducts as $relatedProduct)
                                                @include('partials.product.related')
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <!-- Product Details Content End -->
                        </div>
                        {{-- Rating --}}
                        <div class="tab-pane fade" id="pills-rating" role="tabpanel" aria-labelledby="pills-rating-tab" tabindex="0">
                            <div class="product-review-wrapper">
                                <h5 class="mb-32">Product Ratings</h5>
                                @forelse ($product->ratings as $rating)
                                    <div class="product-review">
                                        <div class="product-review__top flx-between">
                                            <div class="product-review__rating flx-align">
                                                <x-star-rating :rating="$rating->stars" />
                                                <span class="product-review__reason">For <span
                                                        class="product-review__subject">{{ $rating->type }}</span> </span>
                                            </div>
                                            <div class="product-review__date">
                                                by <a href="#"
                                                    class="product-review__user text--base">{{ $rating->user->name ?? 'User' }} </a>
                                                {{ $rating->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                        <div class="product-review__body">
                                            <p class="product-review__desc">{!! nl2br($rating->review) !!}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="product-review text-center">
                                        <p class="">No ratings found</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        {{-- Comments --}}
                        <div class="tab-pane fade" id="pills-comments" role="tabpanel" aria-labelledby="pills-comments-tab"
                            tabindex="0">
                            @livewire('product.comments', ['product' => $product])
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- ======================= Product Sidebar Start ========================= -->
                    <div class="product-sidebar section-bg">
                        <div class="product-sidebar__top position-relative flx-between gap-1">
                            <button type="button" class="btn-has-dropdown font-heading font-18">
                                {{ $selectedLicenseType === 'extended' ? 'Extended License' : 'Regular License' }}
                            </button>
                            <div class="license-dropdown">
                                <div class="license-dropdown__item mb-3" wire:click="toggleLicenseType">
                                    <h6 class="license-dropdown__title font-body mb-1 font-16">Regular License</h6>
                                    <p class="license-dropdown__desc font-13">Use, by you or one client, in a solitary finished result
                                        which end clients are not charged for. The complete cost incorporates the thing cost and a purchaser
                                        fee..</p>
                                </div>
                                <div class="license-dropdown__item" wire:click="toggleLicenseType">
                                    <h6 class="license-dropdown__title font-body mb-1 font-16">Extended License</h6>
                                    <p class="license-dropdown__desc font-13">Use, by you or one client, in a solitary final result which
                                        end clients can be charged for. The all out cost incorporates the thing cost and a purchaser
                                        fee.</p>
                                </div>
                                <div class="mt-3 pt-2 border-top text-center ">
                                    <a href="#" class="link hover-text-decoration-underline font-14 text-main fw-500">View License
                                        Details</a>
                                </div>
                            </div>
                            <h6 class="product-sidebar__title">{{ format_price($currentPrice) }}</h6>
                        </div>

                        <ul class="sidebar-list">
                            <li class="sidebar-list__item flx-align gap-2 font-14 fw-300 mb-2">
                                <span class="icon"><img src="{{ static_asset('images/icons/check-cirlce.svg') }}"
                                        alt=""></span>
                                <span class="text">Quality verified</span>
                            </li>
                            <li class="sidebar-list__item flx-align gap-2 font-14 fw-300 mb-2">
                                <span class="icon"><img src="{{ static_asset('images/icons/check-cirlce.svg') }}"alt=""></span>
                                <span class="text">Use for a single project</span>
                            </li>
                            <li class="sidebar-list__item flx-align gap-2 font-14 fw-300">
                                <span class="icon"><img src="{{ static_asset('images/icons/check-cirlce.svg') }}"alt=""></span>
                                <span
                                    class="text">{{ $selectedLicenseType === 'extended' ? 'Can be used for other clients' : 'Non-paying users only' }}</span>
                            </li>
                        </ul>

                        <div class="flx-between mt-3">
                            <div class="common-check mb-0">
                                <input class="form-check-input" type="checkbox" wire:model.live="extendedSupport" name="checkbox" id="extended">
                                <label class="form-check-label mb-0 fw-300 text-body" for="extended">Extended support
                                    {{ $selectedLicenseType === 'extended' ? '12' : '6' }} months</label>
                            </div>
                            <div class="flx-align gap-2">
                                <span
                                    class="product-card__prevPrice text-decoration-line-through">{{ format_price($supportOriginalPrice) }}</span>
                                <h6 class="product-card__price mb-0 font-14 fw-500">{{ format_price($supportPrice) }}</h6>
                            </div>
                        </div>
                        <button type="button" wire:click="addToCart"
                            class="btn btn-main d-flex w-100 justify-content-center align-items-center gap-2 pill px-sm-5 mt-32"
                            wire:loading.attr="disabled">
                            <img src="{{ static_asset('images/icons/add-to-cart.svg') }}" alt="">
                            <span wire:loading.remove wire:target="addToCart">Add To Cart</span>
                            <span wire:loading wire:target="addToCart">Adding...</span>
                        </button>
                        <hr>
                        <!-- Meta Attribute List Start -->
                        <ul class="meta-attribute">
                            <li class="meta-attribute__item">
                                <span class="name">Last Update</span>
                                <span class="details">{{ show_date($product->publish_date, 'M d, Y') }}</span>
                            </li>
                            <li class="meta-attribute__item">
                                <span class="name">Published</span>
                                <span class="details">{{ show_date($product->created_at, 'M d, Y') }}</span>
                            </li>
                            <li class="meta-attribute__item">
                                <span class="name">Category</span>
                                <span class="details">{{ $product->category->name ?? '' }}</span>
                            </li>
                            {{-- attributes --}}
                            @foreach ($product->attributes as $key => $attribute)
                                <li class="meta-attribute__item">
                                    <span class="name">{{ custom_text($key) }}</span>
                                    <span class="details">
                                        @if (is_array($attribute))
                                            @foreach ((array) $attribute as $idx => $item)
                                                {{ is_array($item) ? json_encode($item) : $item }}{{ !$loop->last ? ', ' : '' }}
                                            @endforeach
                                        @elseif(is_bool($attribute))
                                            {{ $attribute ? 'Yes' : 'No' }}
                                        @else
                                            {{ $attribute }}
                                        @endif
                                    </span>
                                </li>
                            @endforeach
                            <li class="meta-attribute__item">
                                <span class="name">High Resolution</span>
                                <span class="details">Yes</span>
                            </li>
                            <li class="meta-attribute__item">
                                <span class="name">Tags</span>
                                <span class="details">
                                    @foreach ($product->tags as $tag)
                                        <a href="#" class="hover-text-decoration-underline">
                                            {{ $tag }}{{ !$loop->last ? ',' : '' }}
                                        </a>
                                    @endforeach
                                </span>
                            </li>
                        </ul>
                        <!-- Meta Attribute List End -->
                    </div>
                    <!-- ======================= Product Sidebar End ========================= -->
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.meta')
@section('title', $pageTitle)

@section('styles')
    <style>
        .slick-dots {
            display: none !important;
        }
    </style>
@endsection
