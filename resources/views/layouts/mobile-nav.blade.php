<div class="mobile-menu d-lg-none d-block">
    <button type="button" class="close-button"> <i class="las la-times"></i> </button>
    <div class="mobile-menu__inner">
        <a href="{{route('home')}}" class="mobile-menu__logo">
            <img src="assets/images/logo/logo.png" alt="Logo">
        </a>
        <div class="mobile-menu__menu">

            <ul class="nav-menu flx-align nav-menu--mobile">
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
            <div class="header-right__inner d-lg-none my-3 gap-1 d-flex flx-align">
                @guest
                <a href="register.html" wire:navigate class="btn btn-main pill">
                    <span class="icon-left icon">
                        <img src="assets/images/icons/user.svg" alt="">
                    </span>Create Account
                </a>
                @else
                <a href="{{route('user.index')}}" wire:navigate class="btn btn-main pill">
                    <span class="icon-left icon">
                        <img src="{{static_asset('images/icons/user.svg')}}" alt="">
                    </span>Dashboard
                </a>
                @endguest
                {{-- <div class="language-select flx-align select-has-icon">
                    <img src="assets/images/icons/globe.svg" alt="" class="globe-icon">
                    <select class="select py-0 ps-2 border-0 fw-500">
                        <option value="1">Eng</option>
                        <option value="2">Bn</option>
                        <option value="3">Eur</option>
                        <option value="4">Urd</option>
                    </select>
                </div> --}}
            </div>
        </div>
    </div>
</div>
