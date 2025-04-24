<header class="header">
    <div class="container container-full">
        <nav class="header-inner flx-between">
            <!-- Logo Start -->
            <div class="logo">
                <a href="{{route('home')}}" class="link white-version">
                    <img src="{{my_asset($settings->logo)}}" alt="Logo" style="height: 50px;">
                </a>
                <a href="{{route('home')}}" class="link dark-version">
                    <img src="{{my_asset($settings->logo)}}" alt="Logo" style="height: 50px;">
                </a>
            </div>
            <!-- Logo End  -->

            <!-- Menu Start  -->
            <div class="header-menu d-lg-block d-none">

                <ul class="nav-menu flx-align ">
                    <li class="nav-menu__item ">
                        <a href="{{route('home')}}" wire:navigate class="nav-menu__link">Home</a>
                    </li>
                    <li class="nav-menu__item">
                        <a href="{{route('products')}}" wire:navigate class="nav-menu__link">Products</a>
                    </li>
                    <li class="nav-menu__item has-submenu" hidden>
                        <a href="javascript:void(0)" class="nav-menu__link">Pages</a>
                        <ul class="nav-submenu">
                            <li class="nav-submenu__item">
                                <a href="profile.html" class="nav-submenu__link"> Profile</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-menu__item">
                        <a href="{{route('blogs')}}" wire:navigate class="nav-menu__link">Blog</a>
                    </li>
                    <li class="nav-menu__item">
                        <a href="{{route('contact')}}" wire:navigate class="nav-menu__link">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- Menu End  -->

            <!-- Header Right start -->
            <div class="header-right flx-align">
                <a href="{{route('cart')}}" wire:navigate class="header-right__button cart-btn position-relative">
                    <img src="{{static_asset('images/icons/cart.svg')}}" alt="" class="white-version">
                    <img src="{{static_asset('images/icons/cart-white.svg')}}" alt="" class="dark-version">
                    @livewire('cart.cart-count')
                </a>

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

                <div class="header-right__inner gap-3 flx-align d-lg-flex d-none">
                    @guest
                    <a href="{{route('register')}}" wire:navigate class="btn btn-main pill">
                        <span class="icon-left icon">
                            <img src="{{static_asset('images/icons/user.svg')}}" alt="">
                        </span>Create Account
                    </a>
                    @else
                    <a href="{{route('user.index')}}" wire:navigate class="btn btn-main pill">
                        <span class="icon-left icon">
                            <img src="{{static_asset('images/icons/user.svg')}}" alt="">
                        </span>Dashboard
                    </a>
                    @endguest
                    <div class="language-select flx-align select-has-icon" hidden>
                        <img src="{{static_asset('images/icons/globe.svg')}}" alt="" class="globe-icon white-version">
                        <img src="{{static_asset('images/icons/globe-white.svg')}}" alt="" class="globe-icon dark-version">
                        <select class="select py-0 ps-2 border-0 fw-500">
                            <option value="1">Eng</option>
                            <option value="2">Bn</option>
                            <option value="3">Eur</option>
                            <option value="4">Urd</option>
                        </select>
                    </div>
                </div>
                <button type="button" class="toggle-mobileMenu d-lg-none"> <i class="las la-bars"></i> </button>
            </div>
            <!-- Header Right End  -->
        </nav>
    </div>
</header>
