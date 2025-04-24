<div>
    <section class="breadcrumb border-bottom p-0 d-block section-bg position-relative z-index-1">
        <div class="breadcrumb-two">
            <img src="{{ static_asset('images/gradients/breadcrumb-gradient-bg.png') }}" alt="" class="bg--gradient">
            <div class="container container-two">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="breadcrumb-two-content text-center">

                            <ul class="breadcrumb-list flx-align gap-2 mb-2 justify-content-center">
                                <li class="breadcrumb-list__item font-14 text-body">
                                    <a href="{{ route('home') }}" wire:navigate
                                        class="breadcrumb-list__link text-body hover-text-main">Home</a>
                                </li>
                                <li class="breadcrumb-list__item font-14 text-body">
                                    <span class="breadcrumb-list__icon font-10"><i class="fas fa-chevron-right"></i></span>
                                </li>
                                <li class="breadcrumb-list__item font-14 text-body">
                                    <span class="breadcrumb-list__text">Blog</span>
                                </li>
                            </ul>

                            <h3 class="breadcrumb-two-content__title mb-0 text-capitalize">Latest Blogs And Articles</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="blog padding-y-120 section-bg position-relative z-index-1 overflow-hidden">
        <img src="{{ static_asset('images/shapes/pattern-five.png') }}" class="position-absolute end-0 top-0 z-index--1" alt="">
        <div class="container container-two">
            <div class="row gy-4">
                @foreach ($blogs as $blog)
                    @include('partials.blog.list')
                @endforeach
            </div>

            @if ($blogs->hasPages())
                {{ $blogs->links('partials.pagination') }}
            @endif


        </div>
    </section>
</div>
