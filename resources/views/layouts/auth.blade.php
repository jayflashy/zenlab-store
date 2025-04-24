<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.partials.head')
</head>

<body>
    @include('inc.loaders')

    <div class="overlay"></div>

    <div class="side-overlay"></div>

    {{-- page content --}}
    <section class="account d-flex">
        <div class="account__left d-md-flex d-none flx-align section-bg position-relative z-index-1 overflow-hidden">
            <img src="{{static_asset('images/shapes/pattern-curve-seven.png')}}" alt="" class="position-absolute end-0 top-0 z-index--1 h-100">
            <div class="account-thumb">
                <img src="{{static_asset('images/thumbs/banner-img.png')}}" alt="">
                <div class="statistics animation bg-main text-center">
                    <h5 class="statistics__amount text-white is-visible" style="visibility: visible;">50k</h5>
                    <span class="statistics__text text-white font-14">Customers</span>
                </div>
            </div>
        </div>
        <div class="account__right padding-t-120 flx-align">

            <div class="dark-light-mode">
                <!-- Light Dark Mode -->
                <div class="theme-switch-wrapper position-relative">
                    <label class="theme-switch" for="checkbox">
                        <input type="checkbox" class="d-none" id="checkbox">
                        <span class="slider text-black header-right__button white-version">
                            <img src="{{static_asset('images/icons/sun.svg')}}" alt="">
                        </span>
                        <span class="slider text-black header-right__button dark-version">
                            <img src="{{static_asset('images/icons/moon.svg')}}" alt="">
                        </span>
                    </label>
                </div>
            </div>

            <div class="account-content">
                <a href="{{route('home')}}" class="logo mb-64">
                    <img src="{{my_asset($settings->logo)}}" alt="{{$settings->name}}" class="white-versions" style="max-height: 50px;">
                </a>
                @yield('content')
                {{ $slot ?? '' }}
            </div>

        </div>
    </section>

    {{-- Footer --}}
    @include('layouts.partials.scripts')

</body>

</html>
