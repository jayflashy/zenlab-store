@section('title', 'Homepage')
<div>
    <section class="hero section-bg z-index-1">
        <img src="{{ static_asset('images/gradients/banner-gradient.png') }}" alt=""
            class="bg--gradient white-version">

        <img src="{{ static_asset('images/shapes/element-moon1.png') }}" alt="" class="element one">
        <img src="{{ static_asset('images/shapes/element-moon2.png') }}" alt="" class="element two">

        <div class="container container-two">
            <div class="row align-items-center gy-sm-5 gy-4">
                <div class="col-lg-6">
                    <div class="hero-inner position-relative pe-lg-5">
                        <div>
                            <h1 class="hero-inner__title">2M+ curated digital products</h1>
                            <p class="hero-inner__desc font-18">Explore the best premium themes and plugins available
                                for sale. Our unique
                                collection is hand-curated by experts. Find and buy the perfect premium theme today.</p>

                            <div class="position-relative">
                                <form class="search-box" method="get" action="{{ route('products') }}">
                                    <input type="text" name="search" id="search"
                                        class="common-input common-input--lg pill shadow-sm auto-suggestion-input"
                                        placeholder="Search theme, plugins &amp; more...">
                                    <button type="submit" class="btn btn-main btn-icon icon border-0">
                                        <img src="{{ static_asset('images/icons/search.svg') }}" alt="">
                                    </button>
                                </form>
                            </div>
                            <div class="product-category-list">
                                @foreach ($topCategories as $category)
                                    <a href="{{ route('products') }}?categoryId={{ $category->id }}"
                                        class="product-category-list__item" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-title="{{ $category->name }}">
                                        <img src="{{ my_asset($category->image) }}"
                                            style="max-height: 25px; max-width: 25px;" alt=""
                                            class="rounded white-version">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-thumb">
                        <img src="{{ static_asset('images/thumbs/banner-img.png') }}" alt="">
                        <img src="{{ static_asset('images/shapes/dots.png') }}" alt=""
                            class="dotted-img white-version">
                        <img src="{{ static_asset('images/shapes/dots-white.png') }}" alt=""
                            class="dotted-img dark-version">
                        <img src="{{ static_asset('images/shapes/element2.png') }}" alt=""
                            class="element two end-0">

                        <div class="statistics animation bg-main text-center">
                            <h5 class="statistics__amount text-white is-visible" style="visibility: visible;">50k</h5>
                            <span class="statistics__text text-white font-14">Customers</span>
                        </div>

                        <div class="statistics style-two bg-white text-center">
                            <h5 class="statistics__amount statistics__amount-two text-heading is-visible"
                                style="visibility: visible;">22k
                            </h5>
                            <span class="statistics__text text-heading font-14">Themes &amp; Plugins</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- popular  categoris --}}
    <section class="popular padding-y-120 overflow-hidden">
        <div class="container container-two">
            <div class="section-heading style-left mb-64">
                <h5 class="section-heading__title">Popular Categories</h5>
            </div>
            <div class="popular-slider arrow-style-two row gy-4">
                @foreach ($categories as $category)
                    <div class="col-lg-2">
                        <a href="{{ route('products') }}?categoryId={{ $category->id }}" class="popular-item w-100">
                            <span class="popular-item__icon">
                                <img src="{{ my_asset($category->image) }}" style="max-height: 50px; max-width: 50px;"
                                    alt="" />
                            </span>
                            <h6 class="popular-item__title font-18">{{ $category->name }}</h6>
                            <span class="popular-item__qty text-body">{{ $category->products_count }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="popular__button text-center">
                <a href="{{ route('products') }}"
                    class="font-18 fw-600 text-heading hover-text-main text-decoration-underline font-heading">
                    Explore More
                </a>
            </div>
        </div>
    </section>

    {{-- new arrival --}}
    <section class="arrival-product padding-y-120 section-bg position-relative z-index-1">
        <img src="{{ static_asset('images/gradients/product-gradient.png') }}" alt=""
            class="bg--gradient white-version">
        <img src="{{ static_asset('images/shapes/element2.png') }}" alt="" class="element one">

        <div class="container container-two">
            <div class="section-heading">
                <h3 class="section-heading__title">New Arrival Products</h3>
            </div>
            <ul class="nav common-tab justify-content-center nav-pills mb-48" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button wire:click="selectCategory('all')"
                        class="nav-link @if ($activeCategory === 'all') active @endif" type="button" role="tab"
                        aria-selected="true">All Items</button>
                </li>
                @foreach ($featuredCategories as $category)
                    <li class="nav-item" role="presentation">
                        <button wire:click="selectCategory('{{ $category->id }}')"
                            class="nav-link @if ($activeCategory == $category->id) active @endif" type="button"
                            role="tab" aria-selected="false">
                            {{ $category->name }}
                        </button>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane @if ($activeCategory === 'all') show active @endif" role="tabpanel">
                    <div class="row gy-4">
                        @foreach ($allProducts as $product)
                            @include('partials.product.list', ['product' => $product])
                        @endforeach
                    </div>
                </div>
                @foreach ($featuredCategories as $category)
                    <div class="tab-pane @if ($activeCategory == $category->id) show active @endif" role="tabpanel">
                        <div class="row gy-4">
                            @foreach ($categoryProducts[$category->id] as $product)
                                @include('partials.product.list', ['product' => $product])
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-64">
                <a href="{{ route('products') }}" class="btn btn-main btn-lg pill fw-300">
                    View All Products
                </a>
            </div>
        </div>
    </section>
    {{-- Action tabs --}}
    <section class="seller padding-y-120">
        <div class="container container-two">
            <div class="row gy-4">
                <div class="col-lg-6">
                    <div class="seller-item position-relative z-index-1">
                        <img src="{{ static_asset('images/shapes/seller-bg.png') }}"
                            class="position-absolute
                        start-0 top-0 z-index--1" alt="">
                        <h3 class="seller-item__title">Trusted by Clients and Developers Worldwide</h3>
                        <p class="seller-item__desc fw-500 text-heading"> Our hand-crafted digital products are built
                            with clean, scalable code and professional design. From solo developers to startups,
                            thousands trust our solutions to power their projects.</p>
                        <a href="{{ route('about') }}" class="btn btn-static-outline-black btn-xl pill fw-600">
                            Learn More
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="seller-item bg-two position-relative z-index-1">
                        <img src="{{ static_asset('images/shapes/seller-bg-two.png') }}"
                            class="position-absolute
                        start-0 top-0 z-index--1" alt="">
                        <h3 class="seller-item__title">New Customer Offer</h3>
                        <p class="seller-item__desc fw-500 text-heading">Get 20% off your first purchase. Limited time
                            offer for new accounts. Create an account today and explore over 55,000+ digital products,
                            including WordPress themes, plugins, PHP scripts, and much more.</p>
                        <a href="{{ route('register') }}"
                            class="btn btn-static-outline-black btn-xl pill fw-600">Register Now</a>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="support position-relative z-index-1">
                        <img src="{{ static_asset('images/shapes/spider-net-sm.png') }}" alt=""
                            class="spider-net position-absolute top-0 end-0 z-index--1">
                        <img src="{{ static_asset('images/shapes/arrow-shape.png') }}" alt=""
                            class="arrow-shape">
                        <div class="row align-items-center">
                            <div class="col-lg-1 d-lg-block d-none"></div>
                            <div class="col-lg-3 col-md-4 d-md-block d-none">
                                <div class="support-thumb text-center">
                                    <img src="{{ static_asset('images/thumbs/support-img.png') }}" alt="">
                                </div>
                            </div>
                            <div class="col-lg-3 d-lg-block d-none"></div>
                            <div class="col-lg-5 col-md-8">
                                <div class="support-content">
                                    <h3 class="support-content__title mb-3">Support 24/7</h3>
                                    <p class="support-content__desc">Wanna talk? Send us a message</p>
                                    <a href="mailto:{{ $settings->email }}"
                                        class="btn btn-static-black btn-lg fw-300 pill">{{ $settings->email }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- blogs --}}
    <section class="blog padding-y-120 section-bg position-relative z-index-1 overflow-hidden">
        <img src="{{ static_asset('images/shapes/pattern-five.png') }}"
            class="position-absolute end-0 top-0 z-index--1" alt="">
        <div class="container container-two">
            <div class="section-heading style-left style-flex flx-between align-items-end gap-3">
                <div class="section-heading__inner">
                    <h3 class="section-heading__title">blogs and articles</h3>
                </div>
                <a href="{{ route('blogs') }}" wire:navigate class="btn btn-main btn-lg pill">Read All </a>
            </div>
            <div class="row gy-4">
                @foreach ($blogs as $blog)
                    @include('partials.blog.list')
                @endforeach
            </div>
        </div>
    </section>


</div>
