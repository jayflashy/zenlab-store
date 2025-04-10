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
                                    <span class="breadcrumb-list__text">SaaS</span>
                                </li>
                            </ul>

                            <h3 class="breadcrumb-two-content__title mb-3 text-capitalize">Quantum: SaaS Landing Page WordPress Theme</h3>

                            <div class="breadcrumb-content flx-align gap-3">
                                <div class="breadcrumb-content__item text-heading fw-500 flx-align gap-2">
                                    <span class="icon">
                                        <img src="{{ static_asset('images/icons/cart-icon.svg') }}" alt="" class="white-version">
                                        <img src="{{ static_asset('images/icons/cart-white.svg') }}" alt=""
                                            class="dark-version w-20">
                                    </span>
                                    <span class="text">158 sales</span>
                                </div>
                                <div class="breadcrumb-content__item text-heading fw-500 flx-align gap-2">
                                    <span class="icon">
                                        <img src="{{ static_asset('images/icons/check-icon.svg') }}" alt="" class="white-version">
                                        <img src="{{ static_asset('images/icons/check-icon-white.svg') }}" alt=""
                                            class="dark-version">
                                    </span>
                                    <span class="text">Recently Updated</span>
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
                            <span class="d-flex align-items-center gap-1">
                                <span class="star-rating">
                                    <span class="star-rating__item font-11"><i class="fas fa-star"></i></span>
                                    <span class="star-rating__item font-11"><i class="fas fa-star"></i></span>
                                    <span class="star-rating__item font-11"><i class="fas fa-star"></i></span>
                                    <span class="star-rating__item font-11"><i class="fas fa-star"></i></span>
                                    <span class="star-rating__item font-11"><i class="fas fa-star"></i></span>
                                </span>
                                <span class="star-rating__text text-body"> 5.0</span>
                                <span class="star-rating__text text-body"> (180)</span>
                            </span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-comments-tab" data-bs-toggle="pill" data-bs-target="#pills-comments"
                            type="button" role="tab" aria-controls="pills-comments" aria-selected="false" tabindex="-1">Comments
                            (50)</button>
                    </li>
                </ul>
                <div class="social-share">
                    <button type="button" class="social-share__button">
                        <img src="{{ static_asset('images/icons/share-icon.svg') }}" alt="">
                    </button>
                    <div class="social-share__icons left">
                        <ul class="social-icon-list colorful-style">
                            <li class="social-icon-list__item">
                                <a href="https://www.facebook.com" class="social-icon-list__link text-body flex-center"><i
                                        class="fab fa-facebook-f"></i></a>
                            </li>
                            <li class="social-icon-list__item">
                                <a href="https://www.twitter.com" class="social-icon-list__link text-body flex-center"> <i
                                        class="fab fa-linkedin-in"></i></a>
                            </li>
                            <li class="social-icon-list__item">
                                <a href="https://www.google.com" class="social-icon-list__link text-body flex-center"> <i
                                        class="fab fa-twitter"></i></a>
                            </li>
                        </ul>
                    </div>
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
                                    <img src="{{ static_asset('images/thumbs/product-details.png') }}" alt="">
                                </div>
                                <div class="product-details__buttons flx-align justify-content-center gap-3">
                                    <a href="#"
                                        class="btn btn-main d-inline-flex align-items-center gap-2 pill px-sm-5 justify-content-center">Live
                                        Preview
                                        <img src="{{ static_asset('images/icons/eye-outline.svg') }}" alt="">
                                    </a>

                                    <a href="#" class="screenshot-btn btn btn-white pill px-sm-5"
                                        data-images='["{{ static_asset('images/thumbs/product-details.png') }}", "{{ static_asset('images/thumbs/product-details.png') }}"]'>Screenshot</a>


                                </div>

                                <p class="product-details__desc">System management saas products, consectetur adipiscing elit, sed do
                                    eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                                    reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat
                                    cupidatat non proident.</p>

                                <div class="product-details__item">
                                    <h5 class="product-details__title mb-3">Template Features</h5>
                                    <ul class="product-list">
                                        <li class="product-list__item">Modern and Professional design</li>
                                        <li class="product-list__item">Built with Elementor Pro</li>
                                        <li class="product-list__item">100% Responsive & mobile-friendly</li>
                                        <li class="product-list__item">12+ pre-built templates</li>
                                        <li class="product-list__item">Easy to customize</li>
                                        <li class="product-list__item">Fully responsive website</li>
                                    </ul>
                                </div>
                                <div class="product-details__item">
                                    <h5 class="product-details__title mb-3">Layout Features</h5>
                                    <ul class="product-list">
                                        <li class="product-list__item">One-Click demo import</li>
                                        <li class="product-list__item">Unlimited color style</li>
                                        <li class="product-list__item">850+ google fonts</li>
                                        <li class="product-list__item">Powered by dpmarket</li>
                                        <li class="product-list__item">Hight resolution images</li>
                                        <li class="product-list__item">Easy to customize</li>
                                    </ul>
                                </div>
                                <div class="product-details__item">
                                    <h5 class="product-details__title mb-3">Font Family</h5>
                                    <ul class="product-list">
                                        <li class="product-list__item text-heading">
                                            <a href="https://fonts.google.com/specimen/Fira+Sans?query=fira"
                                                class="link text-body hover-text-main hover-text-decoration-underline">Fira Sans</a>
                                        </li>
                                        <li class="product-list__item text-heading">
                                            <a href="https://fonts.google.com/specimen/Inter?query=inter"
                                                class="link text-body hover-text-main hover-text-decoration-underline">Inter</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-details__item">
                                    <h5 class="product-details__title mb-3">Support</h5>
                                    <p class="product-details__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                        eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                        exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                                        reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint
                                        occaecat cupidatat non proident.</p>
                                </div>

                                <div class="more-item">
                                    <div class="flx-between mb-4">
                                        <h5 class="more-item__title">Related Products</h5>
                                    </div>

                                    <div class="selling-product-slider more-item__content flx-align">
                                        @for ($i = 0; $i < 10; $i++)
                                            @include('partials.product.related')
                                        @endfor
                                    </div>
                                </div>

                            </div>
                            <!-- Product Details Content End -->
                        </div>
                        <div class="tab-pane fade" id="pills-rating" role="tabpanel" aria-labelledby="pills-rating-tab" tabindex="0">
                            <div class="product-review-wrapper">
                                <div class="product-review">
                                    <div class="product-review__top flx-between">
                                        <div class="product-review__rating flx-align">
                                            <div class="d-flex align-items-center gap-1">
                                                <ul class="star-rating">
                                                    <li class="star-rating__item font-11"><i class="fas fa-star"></i></li>
                                                    <li class="star-rating__item font-11"><i class="fas fa-star"></i></li>
                                                    <li class="star-rating__item font-11"><i class="fas fa-star"></i></li>
                                                    <li class="star-rating__item font-11"><i class="fas fa-star"></i></li>
                                                    <li class="star-rating__item font-11"><i class="fas fa-star"></i></li>
                                                </ul>
                                                <span class="star-rating__text text-body"> 5.0</span>
                                            </div>
                                            <span class="product-review__reason">For <span class="product-review__subject">Customer
                                                    Support</span> </span>
                                        </div>
                                        <div class="product-review__date">
                                            by <a href="#" class="product-review__user text--base">John Doe </a> 2 month ago
                                        </div>
                                    </div>
                                    <div class="product-review__body">
                                        <p class="product-review__desc">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quibusdam
                                            itaque vitae ex possimus delectus? Voluptas expedita accusantium aperiam quo quod dolore
                                            dignissimos rerum praesentium deserunt libero recusandae quisquam est accusamus eos dolorum sit
                                            explicabo, sapiente pariatur voluptates veniam aut veritatis, magnam velit similique! Ex
                                            similique magni labore aperiam, eius quas molestiae accusantium porro eaque esse minus amet
                                            doloribus quo odit illo doloremque.</p>
                                    </div>
                                </div>
                                <div class="product-review">
                                    <div class="product-review__top flx-between">
                                        <div class="product-review__rating flx-align">
                                            <div class="d-flex align-items-center gap-1">
                                                <ul class="star-rating">
                                                    <li class="star-rating__item font-11"><i class="fas fa-star"></i></li>
                                                    <li class="star-rating__item font-11"><i class="fas fa-star"></i></li>
                                                    <li class="star-rating__item font-11"><i class="fas fa-star"></i></li>
                                                    <li class="star-rating__item font-11"><i class="fas fa-star"></i></li>
                                                    <li class="star-rating__item font-11"><i class="fas fa-star"></i></li>
                                                </ul>
                                                <span class="star-rating__text text-body"> 5.0</span>
                                            </div>
                                            <span class="product-review__reason">For <span class="product-review__subject">Customer
                                                    Support</span> </span>
                                        </div>
                                        <div class="product-review__date">
                                            by <a href="#" class="product-review__user text--base">John Doe </a> 2 month ago
                                        </div>
                                    </div>
                                    <div class="product-review__body">
                                        <p class="product-review__desc">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quibusdam
                                            itaque vitae ex possimus delectus? Voluptas expedita accusantium aperiam quo quod dolore
                                            dignissimos rerum praesentium deserunt libero recusandae quisquam est accusamus eos dolorum sit
                                            explicabo, sapiente pariatur voluptates veniam aut veritatis, magnam velit similique! Ex
                                            similique magni labore aperiam, eius quas molestiae accusantium porro eaque esse minus amet
                                            doloribus quo odit illo doloremque.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-comments" role="tabpanel" aria-labelledby="pills-comments-tab"
                            tabindex="0">

                            <!-- Comment Start -->
                            <div class="comment mt-64 mb-64">
                                <h5 class="mb-32">2 Comments</h5>
                                <ul class="comment-list">
                                    <li class="comment-list__item d-flex align-items-start gap-sm-4 gap-3">
                                        <div class="comment-list__thumb flex-shrink-0">
                                            <img src="{{ static_asset('images/thumbs/comment1.png') }}" class="cover-img"
                                                alt="">
                                        </div>
                                        <div class="comment-list__content">
                                            <div class="flx-between gap-2 align-items-start">
                                                <div>
                                                    <h6 class="comment-list__name font-18 mb-sm-2 mb-1">Jenny Wilson</h6>
                                                    <span class="comment-list__date font-14">Jan 21, 2024 at 11:25 pm</span>
                                                </div>
                                                <a class="comment-list__reply fw-500 flx-align gap-2 hover-text-decoration-underline"
                                                    href="#comment-box">
                                                    Reply
                                                    <span class="icon"><img src="{{ static_asset('images/icons/reply-icon.svg') }}"
                                                            alt=""></span>
                                                </a>
                                            </div>
                                            <p class="comment-list__desc mt-3">Lorem ipsum dolor sit amet consectetur. Nec nunc
                                                pellentesque massa pretium. Quam sapien nec venenatis vivamus sed cras faucibus mi viverra.
                                                Quam faucibus morbi cras vitae neque. Necnunc pellentesque massa pretium.</p>
                                        </div>
                                    </li>
                                    <li>
                                        <ul class="comment-list comment-list--two">
                                            <li class="comment-list__item d-flex align-items-start gap-sm-4 gap-3">
                                                <div class="comment-list__thumb flex-shrink-0">
                                                    <img src="{{ static_asset('images/thumbs/comment2.png') }}" class="cover-img"
                                                        alt="">
                                                </div>
                                                <div class="comment-list__content">
                                                    <div class="flx-between gap-2 align-items-start">
                                                        <div>
                                                            <h6 class="comment-list__name font-18 mb-sm-2 mb-1">Courtney Henry</h6>
                                                            <span class="comment-list__date font-14">Jan 21, 2024 at 11:25 pm</span>
                                                        </div>
                                                        <a class="comment-list__reply fw-500 flx-align gap-2 hover-text-decoration-underline"
                                                            href="#comment-box">
                                                            Reply
                                                            <span class="icon"><img
                                                                    src="{{ static_asset('images/icons/reply-icon.svg') }}"
                                                                    alt=""></span>
                                                        </a>
                                                    </div>
                                                    <p class="comment-list__desc mt-3">Lorem ipsum dolor sit amet consectetur. Nec nunc
                                                        pellentesque massa pretium. Quam sapien nec venenatis vivamus sed cras faucibus.</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <!-- Comment End -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- ======================= Product Sidebar Start ========================= -->
                    <div class="product-sidebar section-bg">
                        <div class="product-sidebar__top position-relative flx-between gap-1">
                            <button type="button" class="btn-has-dropdown font-heading font-18">Extended License</button>
                            <div class="license-dropdown">
                                <div class="license-dropdown__item mb-3">
                                    <h6 class="license-dropdown__title font-body mb-1 font-16">Regular License</h6>
                                    <p class="license-dropdown__desc font-13">Use, by you or one client, in a solitary finished result
                                        which end clients are not charged for. The complete cost incorporates the thing cost and a purchaser
                                        expense..</p>
                                </div>
                                <div class="license-dropdown__item">
                                    <h6 class="license-dropdown__title font-body mb-1 font-16">Extended License</h6>
                                    <p class="license-dropdown__desc font-13">Use, by you or one client, in a solitary final result which
                                        end clients can be charged for. The all out cost incorporates the thing cost and a purchaser
                                        expense.</p>
                                </div>
                                <div class="mt-3 pt-2 border-top text-center ">
                                    <a href="#" class="link hover-text-decoration-underline font-14 text-main fw-500">View License
                                        Details</a>
                                </div>
                            </div>
                            <h6 class="product-sidebar__title">$1580.00</h6>
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
                                <span class="text">Non-paying users only</span>
                            </li>
                        </ul>

                        <div class="flx-between mt-3">
                            <div class="common-check mb-0">
                                <input class="form-check-input" type="checkbox" name="checkbox" id="extended">
                                <label class="form-check-label mb-0 fw-300 text-body" for="extended">Extended support 12 month</label>
                            </div>
                            <div class="flx-align gap-2">
                                <span class="product-card__prevPrice text-decoration-line-through">$12</span>
                                <h6 class="product-card__price mb-0 font-14 fw-500">$7.25</h6>
                            </div>
                        </div>
                        <button type="button"
                            class="btn btn-main d-flex w-100 justify-content-center align-items-center gap-2 pill px-sm-5 mt-32">
                            <img src="{{ static_asset('images/icons/add-to-cart.svg') }}" alt="">
                            Add To Cart
                        </button>
                        <hr>
                        <!-- Meta Attribute List Start -->
                        <ul class="meta-attribute">
                            <li class="meta-attribute__item">
                                <span class="name">Last Update</span>
                                <span class="details">Feb 21, 2024</span>
                            </li>
                            <li class="meta-attribute__item">
                                <span class="name">Published</span>
                                <span class="details">Feb 15, 2024</span>
                            </li>
                            <li class="meta-attribute__item">
                                <span class="name">Category</span>
                                <span class="details">Themes</span>
                            </li>
                            <li class="meta-attribute__item">
                                <span class="name">Widget Ready</span>
                                <span class="details">Yes</span>
                            </li>
                            <li class="meta-attribute__item">
                                <span class="name">High Resolution</span>
                                <span class="details">Yes</span>
                            </li>
                            <li class="meta-attribute__item">
                                <span class="name">Copatible with</span>
                                <span class="details">
                                    <a href="#" class="hover-text-decoration-underline">Contact Form 7,</a>
                                    <a href="#" class="hover-text-decoration-underline"> Calendar,</a>
                                    <a href="#" class="hover-text-decoration-underline"> Elementor,</a>
                                    <a href="#" class="hover-text-decoration-underline"> Elementor Pro,</a>
                                    <a href="#" class="hover-text-decoration-underline"> WooCommerce 8.x.x</a>
                                </span>
                            </li>
                            <li class="meta-attribute__item">
                                <span class="name">File size</span>
                                <span class="details">85 MB</span>
                            </li>
                            <li class="meta-attribute__item">
                                <span class="name">Framework</span>
                                <span class="details">Underscores</span>
                            </li>
                            <li class="meta-attribute__item">
                                <span class="name">Software Version</span>
                                <span class="details">
                                    <a href="#" class="hover-text-decoration-underline">WordPress 6.3.x,</a>
                                    <a href="#" class="hover-text-decoration-underline">WordPress 6.2.x,</a>
                                    <a href="#" class="hover-text-decoration-underline">WordPress 6.1.x,</a>
                                    <a href="#" class="hover-text-decoration-underline">WordPress 6.0.x,</a>
                                    <a href="#" class="hover-text-decoration-underline">WordPress 5.9.x,</a>
                                </span>
                            </li>
                            <li class="meta-attribute__item">
                                <span class="name">Marketplace Files
                                    Included</span>
                                <span class="details">
                                    <a href="#" class="hover-text-decoration-underline">PHP Files,</a>
                                    <a href="#" class="hover-text-decoration-underline">CSS Files,</a>
                                    <a href="#" class="hover-text-decoration-underline">SCSS Files,</a>
                                    <a href="#" class="hover-text-decoration-underline">JS Files,</a>
                                </span>
                            </li>
                            <li class="meta-attribute__item">
                                <span class="name">Layout</span>
                                <span class="details">Responsive</span>
                            </li>
                            <li class="meta-attribute__item">
                                <span class="name">Tags</span>
                                <span class="details">
                                    <a href="#" class="hover-text-decoration-underline">theme,</a>
                                    <a href="#" class="hover-text-decoration-underline">web design,</a>
                                    <a href="#" class="hover-text-decoration-underline">minimal design,</a>
                                    <a href="#" class="hover-text-decoration-underline">trendy,</a>
                                    <a href="#" class="hover-text-decoration-underline">responsive,</a>
                                    <a href="#" class="hover-text-decoration-underline">wordpress,</a>
                                    <a href="#" class="hover-text-decoration-underline">saas,</a>
                                    <a href="#" class="hover-text-decoration-underline">dashboard,</a>
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
@section('meta')
@endsection

@section('styles')
    <style>
        .slick-dots {
            display: none !important;
        }
    </style>
@endsection
