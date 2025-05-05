<div class="dashboard-nav bg-white flx-between gap-md-3 gap-2">
    <div class="dashboard-nav__left flx-align gap-md-3 gap-2">
        <button type="button" class="icon-btn bar-icon text-heading bg-gray-seven flx-center">
            <i class="las la-bars"></i>
        </button>
        <button type="button" class="icon-btn arrow-icon text-heading bg-gray-seven flx-center">
            <img src="{{ static_asset('images/icons/angle-right.svg') }}" alt="">
        </button>

    </div>
    <div class="dashboard-nav__right">
        <div class="header-right flx-align">
            <div class="header-right__inner gap-sm-3 gap-2 flx-align d-flex">

                <!-- Light Dark Mode -->
                <div class="theme-switch-wrapper position-relative">
                    <label class="theme-switch" for="checkbox">
                        <input type="checkbox" class="d-none" id="checkbox">
                        <span class="slider text-black header-right__button white-version">
                            <img src="{{ static_asset('images/icons/sun.svg') }}" alt="">
                        </span>
                        <span class="slider text-black header-right__button dark-version">
                            <img src="{{ static_asset('images/icons/moon.svg') }}" alt="">
                        </span>
                    </label>
                </div>

                <div class="user-profile">
                    <button class="user-profile__button flex-align">
                        <span class="user-profile__thumb">
                            <img src="{{ my_asset(auth()->user()->image ?? 'users/default.jpg') }}" class="cover-img my-auto"
                                alt="">
                        </span>
                    </button>
                    <ul class="user-profile-dropdown">
                        <li class="sidebar-list__item">
                            <a href="{{ route('user.profile') }}" wire:navigate class="sidebar-list__link">
                                <span class="sidebar-list__icon">
                                    <img src="{{ static_asset('images/icons/sidebar-icon2.svg') }}" alt="" class="icon">
                                    <img src="{{ static_asset('images/icons/sidebar-icon-active2.svg') }}" alt=""
                                        class="icon icon-active">
                                </span>
                                <span class="text">Profile</span>
                            </a>
                        </li>
                        <li class="sidebar-list__item">
                            <a href="{{ route('favorites') }}" wire:navigate class="sidebar-list__link">
                                <span class="sidebar-list__icon">
                                    <i class="fa fa-1x fa-heart" class="icon"></i>
                                </span>
                                <span class="text">Favorites</span>
                            </a>
                        </li>
                        <li class="sidebar-list__item">
                            <a href="{{ route('logout') }}" class="sidebar-list__link">
                                <span class="sidebar-list__icon">
                                    <img src="{{ static_asset('images/icons/sidebar-icon13.svg') }}" alt="" class="icon">
                                    <img src="{{ static_asset('images/icons/sidebar-icon-active13.svg') }}" alt=""
                                        class="icon icon-active">
                                </span>
                                <span class="text">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- <div class="language-select flx-align select-has-icon" hidden>
                    <img src="{{static_asset('images/icons/globe.svg')}}" alt="" class="globe-icon white-version">
                    <img src="{{static_asset('images/icons/globe-white.svg')}}" alt="" class="globe-icon dark-version">
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
