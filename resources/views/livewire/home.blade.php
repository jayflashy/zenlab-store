@section('title', 'Homepage')
<div>
    <section class="hero section-bg z-index-1">
        <img src="{{ static_asset('images/gradients/banner-gradient.png') }}" alt="" class="bg--gradient white-version">

        <img src="{{ static_asset('images/shapes/element-moon1.png') }}" alt="" class="element one">
        <img src="{{ static_asset('images/shapes/element-moon2.png') }}" alt="" class="element two">

        <div class="container container-two">
            <div class="row align-items-center gy-sm-5 gy-4">
                <div class="col-lg-6">
                    <div class="hero-inner position-relative pe-lg-5">
                        <div>
                            <h1 class="hero-inner__title">2M+ curated digital products</h1>
                            <p class="hero-inner__desc font-18">Explore the best premium themes and plugins available for sale. Our unique
                                collection is hand-curated by experts. Find and buy the perfect premium theme today.</p>

                            <div class="position-relative">
                                <div class="search-box">
                                    <input type="text" class="common-input common-input--lg pill shadow-sm auto-suggestion-input"
                                        placeholder="Search theme, plugins &amp; more...">
                                    <button type="submit" class="btn btn-main btn-icon icon border-0"><img
                                            src="{{ static_asset('images/icons/search.svg') }}" alt=""></button>
                                </div>

                                <ul class="auto-suggestion-list">
                                    <li>
                                        <a href="#" class="auto-suggestion-list__item w-100 text-body">Business in HTML</a>
                                    </li>
                                    <li>
                                        <a href="#" class="auto-suggestion-list__item w-100 text-body">Business in WordPress</a>
                                    </li>
                                    <li>
                                        <a href="#" class="auto-suggestion-list__item w-100 text-body">Business in CMS</a>
                                    </li>
                                    <li>
                                        <a href="#" class="auto-suggestion-list__item w-100 text-body">Ecommerce in HTML</a>
                                    </li>
                                    <li>
                                        <a href="#" class="auto-suggestion-list__item w-100 text-body">Ecommerce in WordPress</a>
                                    </li>
                                    <li>
                                        <a href="#" class="auto-suggestion-list__item w-100 text-body">Ecommerce in CMS</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- Tech List Start -->
                            <div class="product-category-list">
                                <a href="all-product.html" class="product-category-list__item" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-title="WordPress">
                                    <img src="{{ static_asset('images/thumbs/tech-icon1.png') }}" alt="" class="white-version">
                                    <img src="{{ static_asset('images/thumbs/tech-icon-white1.png') }}" alt="" class="dark-version">
                                </a>
                                <a href="all-product.html" class="product-category-list__item" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-title="Laravel">
                                    <img src="{{ static_asset('images/thumbs/tech-icon2.png') }}" alt="">
                                </a>
                                <a href="all-product.html" class="product-category-list__item" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-title="PHP">
                                    <img src="{{ static_asset('images/thumbs/tech-icon3.png') }}" alt="" class="white-version">
                                    <img src="{{ static_asset('images/thumbs/tech-icon-white3.png') }}" alt="" class="dark-version">
                                </a>
                                <a href="all-product.html" class="product-category-list__item" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-title="HTML">
                                    <img src="{{ static_asset('images/thumbs/tech-icon4.png') }}" alt="">
                                </a>
                                <a href="all-product.html" class="product-category-list__item" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-title="Sketch">
                                    <img src="{{ static_asset('images/thumbs/tech-icon5.png') }}" alt="">
                                </a>
                                <a href="all-product.html" class="product-category-list__item" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-title="Figma">
                                    <img src="{{ static_asset('images/thumbs/tech-icon6.png') }}" alt="">
                                </a>
                                <a href="all-product.html" class="product-category-list__item" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-title="Bootstrap">
                                    <img src="{{ static_asset('images/thumbs/tech-icon7.png') }}" alt="">
                                </a>
                                <a href="all-product.html" class="product-category-list__item" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-title="Tailwind">
                                    <img src="{{ static_asset('images/thumbs/tech-icon8.png') }}" alt="">
                                </a>
                                <a href="all-product.html" class="product-category-list__item" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-title="React">
                                    <img src="{{ static_asset('images/thumbs/tech-icon9.png') }}" alt="">
                                </a>
                            </div>
                            <!-- Tech List End -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-thumb">
                        <img src="{{ static_asset('images/thumbs/banner-img.png') }}" alt="">
                        <img src="{{ static_asset('images/shapes/dots.png') }}" alt="" class="dotted-img white-version">
                        <img src="{{ static_asset('images/shapes/dots-white.png') }}" alt="" class="dotted-img dark-version">
                        <img src="{{ static_asset('images/shapes/element2.png') }}" alt="" class="element two end-0">

                        <div class="statistics animation bg-main text-center">
                            <h5 class="statistics__amount text-white is-visible" style="visibility: visible;">50k</h5>
                            <span class="statistics__text text-white font-14">Customers</span>
                        </div>

                        <div class="statistics style-two bg-white text-center">
                            <h5 class="statistics__amount statistics__amount-two text-heading is-visible" style="visibility: visible;">22k
                            </h5>
                            <span class="statistics__text text-heading font-14">Themes &amp; Plugins</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- popular --}}
    <section class="popular padding-y-120 overflow-hidden">
        <div class="container container-two">
            <div class="section-heading style-left mb-64">
                <h5 class="section-heading__title">Popular Categories</h5>
            </div>
            <div class="popular-slider arrow-style-two row gy-4">
                <div class="col-lg-2">
                    <a href="all-product.html" class="popular-item w-100">
                        <span class="popular-item__icon">
                            <img src="{{ static_asset('images/icons/popular-icon1.svg') }}" alt="" />
                        </span>
                        <h6 class="popular-item__title font-18">WordPress</h6>
                        <span class="popular-item__qty text-body">15,296</span>
                    </a>
                </div>
                <div class="col-lg-2">
                    <a href="all-product.html" class="popular-item w-100">
                        <span class="popular-item__icon">
                            <img src="{{ static_asset('images/icons/popular-icon2.svg') }}" alt="" />
                        </span>
                        <h6 class="popular-item__title font-18">Plugin</h6>
                        <span class="popular-item__qty text-body">15,296</span>
                    </a>
                </div>
                <div class="col-lg-2">
                    <a href="all-product.html" class="popular-item w-100">
                        <span class="popular-item__icon">
                            <img src="{{ static_asset('images/icons/popular-icon3.svg') }}" alt="" />
                        </span>
                        <h6 class="popular-item__title font-18">HTML</h6>
                        <span class="popular-item__qty text-body">15,296</span>
                    </a>
                </div>
                <div class="col-lg-2">
                    <a href="all-product.html" class="popular-item w-100">
                        <span class="popular-item__icon">
                            <img src="{{ static_asset('images/icons/popular-icon4.svg') }}" alt="" />
                        </span>
                        <h6 class="popular-item__title font-18">Java Script</h6>
                        <span class="popular-item__qty text-body">15,296</span>
                    </a>
                </div>
                <div class="col-lg-2">
                    <a href="all-product.html" class="popular-item w-100">
                        <span class="popular-item__icon">
                            <img src="{{ static_asset('images/icons/popular-icon5.svg') }}" alt="" />
                        </span>
                        <h6 class="popular-item__title font-18">Mobile App</h6>
                        <span class="popular-item__qty text-body">15,296</span>
                    </a>
                </div>
                <div class="col-lg-2">
                    <a href="all-product.html" class="popular-item w-100">
                        <span class="popular-item__icon">
                            <img src="{{ static_asset('images/icons/popular-icon6.svg') }}" alt="" />
                        </span>
                        <h6 class="popular-item__title font-18">PHP Script</h6>
                        <span class="popular-item__qty text-body">15,296</span>
                    </a>
                </div>
                <div class="col-lg-2">
                    <a href="all-product.html" class="popular-item w-100">
                        <span class="popular-item__icon">
                            <img src="{{ static_asset('images/icons/popular-icon4.svg') }}" alt="" />
                        </span>
                        <h6 class="popular-item__title font-18">Java Script</h6>
                        <span class="popular-item__qty text-body">15,296</span>
                    </a>
                </div>
            </div>
            <div class="popular__button text-center">
                <a href="all-product.html"
                    class="font-18 fw-600 text-heading hover-text-main text-decoration-underline font-heading">Explore More</a>
            </div>
        </div>
    </section>
    {{-- new arrival --}}
    <section class="arrival-product padding-y-120 section-bg position-relative z-index-1">
        <img src="{{ static_asset('images/gradients/product-gradient.png') }}" alt="" class="bg--gradient white-version">

        <img src="{{ static_asset('images/shapes/element2.png') }}" alt="" class="element one">

        <div class="container container-two">
            <div class="section-heading">
                <h3 class="section-heading__title">New Arrival Products</h3>
            </div>

            <ul class="nav common-tab justify-content-center nav-pills mb-48" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all" type="button"
                        role="tab" aria-controls="pills-all" aria-selected="true">All Item</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-wordPress-tab" data-bs-toggle="pill" data-bs-target="#pills-wordPress"
                        type="button" role="tab" aria-controls="pills-wordPress" aria-selected="false"
                        tabindex="-1">wordPress</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-php-tab" data-bs-toggle="pill" data-bs-target="#pills-php" type="button"
                        role="tab" aria-controls="pills-php" aria-selected="false" tabindex="-1">php</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab" tabindex="0">
                    <div class="row gy-4">
                        @foreach ($products as $product)
                            @include('partials.product.list', ['product' => $product])
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-wordPress" role="tabpanel" aria-labelledby="pills-wordPress-tab" tabindex="0">
                    <div class="row gy-4">
                        @foreach ($products as $product)
                            @include('partials.product.list', ['product' => $product])
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-php" role="tabpanel" aria-labelledby="pills-php-tab" tabindex="0">
                    <div class="row gy-4">
                        @foreach ($products as $product)
                            @include('partials.product.list', ['product' => $product])
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="text-center mt-64">
                <a href="all-product.html" class="btn btn-main btn-lg pill fw-300">
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
                        <img src="{{static_asset('images/shapes/seller-bg.png')}}" class="position-absolute
                        start-0 top-0 z-index--1" alt="">
                        <h3 class="seller-item__title">Earn 75% of the ItemD Price</h3>
                        <p class="seller-item__desc fw-500 text-heading">Sellers receive 75% of the Itemp Price for items Dsold exclusively and 50% for items sold non-exclusively. See detailed informationabout the fee structure on Market.</p>
                        <a href="{{route('register')}}" class="btn btn-static-outline-black btn-xl pill fw-600">Become a Seller</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="seller-item bg-two position-relative z-index-1">
                        <img src="{{static_asset('images/shapes/seller-bg-two.png')}}" class="position-absolute
                        start-0 top-0 z-index--1" alt="">
                        <h3 class="seller-item__title">Earn until 40% commission</h3>
                        <p class="seller-item__desc fw-500 text-heading">Our Market is the world’s largest creative market place, selling millions of digital assets every year. With 30% affiliate commission, earning money has never been easier!</p>
                        <a href="{{route('register')}}" class="btn btn-static-outline-black btn-xl pill fw-600">Become an Affiliate</a>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="support position-relative z-index-1">
                        <img src="{{static_asset('images/shapes/spider-net-sm.png')}}" alt="" class="spider-net position-absolute top-0 end-0 z-index--1">
                        <img src="{{static_asset('images/shapes/arrow-shape.png')}}" alt="" class="arrow-shape">
                        <div class="row align-items-center">
                            <div class="col-lg-1 d-lg-block d-none"></div>
                            <div class="col-lg-3 col-md-4 d-md-block d-none">
                                <div class="support-thumb text-center">
                                    <img src="{{static_asset('images/thumbs/support-img.png')}}" alt="">
                                </div>
                            </div>
                            <div class="col-lg-3 d-lg-block d-none"></div>
                            <div class="col-lg-5 col-md-8">
                                <div class="support-content">
                                    <h3 class="support-content__title mb-3">Support 24/7</h3>
                                    <p class="support-content__desc">Wanna talk? Send us a message</p>
                                    <a href="mailto:infomail@office.com" class="btn btn-static-black btn-lg fw-300 pill">infomail@office.com</a>
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
        <img src="{{static_asset('images/shapes/pattern-five.png')}}" class="position-absolute end-0 top-0 z-index--1" alt="">
        <div class="container container-two">
            <div class="section-heading style-left style-flex flx-between align-items-end gap-3">
                <div class="section-heading__inner">
                    <h3 class="section-heading__title">blogs and articles</h3>
                </div>
                <a href="{{route('blogs')}}" wire:navigate class="btn btn-main btn-lg pill">Read All </a>
            </div>
            <div class="row gy-4">
                @foreach ($blogs as $blog)
                @include('partials.blog.list')
                @endforeach
            </div>
        </div>
    </section>


</div>
