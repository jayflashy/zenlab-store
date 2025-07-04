<div>
    {{-- breadcrumb --}}
    <section class="breadcrumb breadcrumb-one padding-y-60 section-bg position-relative z-index-1 overflow-hidden">
        <img src="{{ static_asset('images/gradients/breadcrumb-gradient-bg.png') }}" alt="" class="bg--gradient">
        <img src="{{ static_asset('images/shapes/element-moon3.png') }}" alt="" class="element one">
        <img src="{{ static_asset('images/shapes/element-moon1.png') }}" alt="" class="element three">

        <div class="container container-two">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="breadcrumb-one-content">
                        <h3 class="breadcrumb-one-content__title text-center mb-3 text-capitalize">58,000+ products available for purchase
                        </h3>
                        <p class="breadcrumb-one-content__desc text-center text-black-three">Explore the best premium themes and plugins
                            available for sale. Our unique collection is hand-curated by experts. Find and buy the perfect premium theme.
                        </p>

                        <form wire:submit.prevent="updatedSearch" class="search-box">
                            <input type="search" wire:model.live.debounce.500ms="search"
                                class="common-input common-input--lg pill shadow-sm" placeholder="Search theme, plugins &amp; more...">
                            <button type="submit" class="btn btn-main btn-icon icon border-0">
                                <img src="{{ static_asset('images/icons/search.svg') }}" alt="">
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Products section --}}
    <section class="all-product padding-y-120">
        <div class="container container-two">
            <div class="row">
                <div class="col-lg-12">
                    <div class="filter-tab gap-3 flx-between">
                        <button type="button" wire:click="openFilter"
                            class="filter-tab__button btn btn-outline-light pill d-flex align-items-center">
                            <span class="icon icon-left"><img src="{{ static_asset('images/icons/filter.svg') }}" alt=""></span>
                            <span class="font-18 fw-500">Filters</span>
                        </button>

                        <div class="list-grid d-flex align-items-center gap-2">
                            <button wire:click="toggleView('list')"
                                class="list-grid__button list-button d-sm-flex d-none {{ $view === 'list' ? 'active' : '' }} text-body">
                                <i class="las la-list"></i>
                            </button>
                            <button wire:click="toggleView('grid')"
                                class="list-grid__button grid-button d-sm-flex d-none {{ $view === 'grid' ? 'active' : '' }} text-body">
                                <i class="las la-border-all"></i>
                            </button>
                            <button class="list-grid__button sidebar-btn text-body d-lg-none d-flex"><i class="las la-bars"></i></button>
                        </div>
                    </div>
                    <form wire:submit.prevent class="filter-form pb-4" style="{{ $isFilterOpen ? 'display: block' : 'display:none' }}">
                        <div class="row gy-3">
                            <div class="col-sm-4 col-xs-6">
                                <div class="flx-between gap-1">
                                    <label for="tag" class="form-label font-16">Tag</label>
                                    <button type="button" wire:click="$set('search', '')" class="text-body font-14">Clear</button>
                                </div>
                                <div class="position-relative">
                                    <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search By Tag..."
                                        class="common-input border-gray-five common-input--withLeftIcon" id="tag">
                                    <span class="input-icon input-icon--left">
                                        <img src="{{ static_asset('images/icons/search-two.svg') }}"alt="">
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6">
                                <div class="flx-between gap-1">
                                    <label for="Price" class="form-label font-16">Price</label>
                                    <button type="button" wire:click="$set('minPrice', ''); $set('maxPrice', '');"
                                        class="text-body font-14">Clear
                                    </button>
                                </div>
                                <div class="position-relative d-flex gap-2">
                                    <input type="number" wire:model.live.debounce.500ms="minPrice" class="common-input border-gray-five"
                                        id="minPrice" placeholder="Min">
                                    <span class="mt-2">-</span>
                                    <input type="number" wire:model.live.debounce.500ms="maxPrice" class="common-input border-gray-five"
                                        id="maxPrice" placeholder="Max">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="flx-between gap-1">
                                    <label for="time" class="form-label font-16">Time Frame</label>
                                    <button type="button" wire:click="$set('dateFilter', '')" class="text-body font-14">Clear</button>
                                </div>
                                <div class="position-relative select-has-icon">
                                    <select id="time" wire:model.live="dateFilter" class="common-input border-gray-five">
                                        <option value="">Any Date</option>
                                        <option value="day">Last 24 Hours</option>
                                        <option value="week">Last Week</option>
                                        <option value="month">Last Month</option>
                                        <option value="year">Last Year</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                {{-- Filter Sidebar  --}}
                <div class="col-xl-3 col-lg-4">
                    <div class="filter-sidebar">
                        <button type="button"
                            class="filter-sidebar__close p-2 position-absolute end-0 top-0 z-index-1 text-body hover-text-main font-20 d-lg-none d-block">
                            <i class="las la-times"></i>
                        </button>
                        <div class="filter-sidebar__item">
                            <button type="button" class="filter-sidebar__button font-16 text-capitalize fw-500">Category</button>
                            <div class="filter-sidebar__content">
                                <ul class="filter-sidebar-list">
                                    <li class="filter-sidebar-list__item">
                                        <a href="javascript:void(0);" wire:click="$set('categoryId', '')"
                                            class="filter-sidebar-list__text {{ $categoryId === '' ? 'active' : '' }}">
                                            All Categories <span class="qty">{{ $this->getTotalProductsCount() }}</span>  
                                        </a>
                                    </li>
                                    @foreach ($categories as $category)
                                        <li class="filter-sidebar-list__item">
                                            <a href="javascript:void(0);" wire:click="$set('categoryId', '{{ $category->id }}')"
                                                class="filter-sidebar-list__text {{ $categoryId === $category->id ? 'active' : '' }}">
                                                {{ $category->name }} <span class="qty">{{ $category->products_count }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="filter-sidebar__item">
                            <button type="button" class="filter-sidebar__button font-16 text-capitalize fw-500">Rating</button>
                            <div class="filter-sidebar__content">
                                <ul class="filter-sidebar-list">
                                    <li class="filter-sidebar-list__item">
                                        <div class="filter-sidebar-list__text">
                                            <div class="common-check common-radio">
                                                <input class="form-check-input" type="radio" wire:model.live="ratingFilter"
                                                    value="" id="viewAll">
                                                <label class="form-check-label" for="viewAll"> View All</label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <div class="filter-sidebar-list__text">
                                            <div class="common-check common-radio sdb-cc">
                                                <input class="form-check-input" type="radio" wire:model.live="ratingFilter"
                                                    value="1" id="oneStar">
                                                <label class="form-check-label" for="oneStar"> 1 Star and above</label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <div class="filter-sidebar-list__text">
                                            <div class="common-check common-radio">
                                                <input class="form-check-input" type="radio" wire:model.live="ratingFilter"
                                                    value="2" id="twoStar">
                                                <label class="form-check-label" for="twoStar"> 2 Star and above</label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <div class="filter-sidebar-list__text">
                                            <div class="common-check common-radio">
                                                <input class="form-check-input" type="radio" wire:model.live="ratingFilter"
                                                    value="3" id="threeStar">
                                                <label class="form-check-label" for="threeStar"> 3 Star and above</label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <div class="filter-sidebar-list__text">
                                            <div class="common-check common-radio">
                                                <input class="form-check-input" type="radio" wire:model.live="ratingFilter"
                                                    value="4" id="fourStar">
                                                <label class="form-check-label" for="fourStar"> 4 Star and above</label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <div class="filter-sidebar-list__text">
                                            <div class="common-check common-radio">
                                                <input class="form-check-input" type="radio" wire:model.live="ratingFilter"
                                                    value="5" id="fiveStar">
                                                <label class="form-check-label" for="fiveStar"> 5 Star Rating</label>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="filter-sidebar__item">
                            <button type="button" class="filter-sidebar__button font-16 text-capitalize fw-500">Sort By</button>
                            <div class="filter-sidebar__content">
                                <ul class="filter-sidebar-list">
                                    <li class="filter-sidebar-list__item">
                                        <div class="filter-sidebar-list__text">
                                            <div class="common-check common-radio">
                                                <input class="form-check-input" type="radio" wire:model.live="sortBy" value="latest"
                                                    id="sortLatest">
                                                <label class="form-check-label" for="sortLatest">Newest First</label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <div class="filter-sidebar-list__text">
                                            <div class="common-check common-radio">
                                                <input class="form-check-input" type="radio" wire:model.live="sortBy" value="oldest"
                                                    id="sortOldest">
                                                <label class="form-check-label" for="sortOldest">Oldest First</label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <div class="filter-sidebar-list__text">
                                            <div class="common-check common-radio">
                                                <input class="form-check-input" type="radio" wire:model.live="sortBy"
                                                    value="price_low" id="sortPriceLow">
                                                <label class="form-check-label" for="sortPriceLow">Price: Low to High</label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <div class="filter-sidebar-list__text">
                                            <div class="common-check common-radio">
                                                <input class="form-check-input" type="radio" wire:model.live="sortBy"
                                                    value="price_high" id="sortPriceHigh">
                                                <label class="form-check-label" for="sortPriceHigh">Price: High to Low</label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <div class="filter-sidebar-list__text">
                                            <div class="common-check common-radio">
                                                <input class="form-check-input" type="radio" wire:model.live="sortBy" value="popular"
                                                    id="sortPopular">
                                                <label class="form-check-label" for="sortPopular">Most Popular</label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <div class="filter-sidebar-list__text">
                                            <div class="common-check common-radio">
                                                <input class="form-check-input" type="radio" wire:model.live="sortBy" value="rating"
                                                    id="sortRating">
                                                <label class="form-check-label" for="sortRating">Highest Rated</label>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="row gy-4 list-grid-wrapper {{ $view === 'list' ? 'list-view' : 'grid-view' }}">
                        @forelse($products as $product)
                            @include('partials.product.list')
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info text-center">
                                    No products found matching your criteria. Please try different filters.
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $products->links('partials.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@section('scripts')
    <script>
        window.addEventListener('closeSidebar', function() {
            document.querySelector('.filter-sidebar')?.classList.remove('show');
            document.querySelector('.side-overlay')?.classList.remove('show');
            document.body.classList.remove('scroll-hide-sm');
        });
    </script>
@endsection
@include('layouts.meta')
@section('title', 'All Products')
