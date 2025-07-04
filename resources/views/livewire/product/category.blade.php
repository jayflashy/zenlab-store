@section('title', 'Title')
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
                        <h3 class="breadcrumb-one-content__title text-center mb-3 text-capitalize">{{ $category->name }}
                        </h3>
                        <p class="breadcrumb-one-content__desc text-center text-black-three">
                            {{ $category->description }}.
                        </p>

                        <form wire:submit.prevent="updatedSearch" class="search-box">
                            <input type="search" wire:model.live.debounce.500ms="search"
                                class="common-input common-input--lg pill shadow-sm"
                                placeholder="Search {{ $category->name }} theme, plugins &amp; more...">
                            <button type="submit" class="btn btn-main btn-icon icon border-0">
                                <img src="{{ static_asset('images/icons/search.svg') }}" alt="">
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container container-two">
        <div class="row py-5">
            <div class="col-xl-3 col-lg-4">
                <div class="filter-sidebar">
                    <button type="button"
                        class="filter-sidebar__close p-2 position-absolute end-0 top-0 z-index-1 text-body hover-text-main font-20 d-lg-none d-block">
                        <i class="las la-times"></i>
                    </button>
                    <div class="filter-sidebar__item">
                        <button type="button"
                            class="filter-sidebar__buttons mb-3 pt-0 font-16 text-capitalize fw-500">Category</button>
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
                                        <a href="{{ route('category', $category->slug) }}" wire:navigate
                                            class="filter-sidebar-list__text {{ $categoryId === $category->id ? 'active' : '' }}">
                                            {{ $category->name }} <span
                                                class="qty">{{ $category->products_count }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">
                <div class="row gy-4 list-grid-wrapper grid-view">
                    @forelse($products as $product)
                        @include('partials.product.list')
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <i class="las la-search-minus fa-3x text-muted mb-3"></i>
                                <h4 class="font-20 text-black">No products found</h4>
                                <a href="{{ route('products') }}" class="btn btn-primary">Browse Products</a>
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- <!-- Pagination -->
            <div class="mt-4">
                {{ $products->links('partials.pagination') }}
            </div> --}}
            </div>
        </div>
        @if ($products->count() > 0)
            <div class="row py-5 gy-4 list-grid-wrapper grid-view">
                @foreach ($products as $product)
                    @include('partials.product.list', ['product' => $product])
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
            </div>
        @endif
    </div>
</div>

@include('layouts.meta')
