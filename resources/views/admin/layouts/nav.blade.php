<div class="dashboard-nav bg-white flx-between gap-md-3 gap-2">
    <div class="dashboard-nav__left flx-align gap-md-3 gap-2">
        <button type="button" class="icon-btn bar-icon text-heading bg-gray-seven flx-center">
            <i class="las la-bars"></i>
        </button>
        <button type="button" class="icon-btn arrow-icon text-heading bg-gray-seven flx-center">
            <img src="{{static_asset('images/icons/angle-right.svg')}}" alt="">
        </button>
        <form action="#" class="search-input d-sm-block d-none">
            <span class="icon">
                <img src="{{static_asset('images/icons/search-dark.svg')}}" alt="" class="white-version">
                <img src="{{static_asset('images/icons/search-dark-white.svg')}}" alt="" class="dark-version">
            </span>
            <input type="text" class="common-input common-input--md common-input--bg pill w-100" placeholder="Search here...">
        </form>
    </div>
    <div class="dashboard-nav__right">
        <div class="header-right flx-align">
            <div class="header-right__inner gap-sm-3 gap-2 flx-align d-flex">

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

                <div class="user-profile">
                    <button class="user-profile__button flex-align">
                        <span class="user-profile__thumb">
                            <img src="{{static_asset('images/thumbs/user-profile.png')}}" class="cover-img" alt="">
                        </span>
                    </button>
                    <ul class="user-profile-dropdown">
                        <li class="sidebar-list__item">
                            <a href="{{route('admin.profile')}}" class="sidebar-list__link">
                                <span class="sidebar-list__icon">
                                    <img src="{{static_asset('images/icons/sidebar-icon2.svg')}}" alt="" class="icon">
                                    <img src="{{static_asset('images/icons/sidebar-icon-active2.svg')}}" alt="" class="icon icon-active">
                                </span>
                                <span class="text">Profile</span>
                            </a>
                        </li>

                        <li class="sidebar-list__item">
                            <a href="{{ route('admin.settings') }}" class="sidebar-list__link">
                                <span class="sidebar-list__icon">
                                    <img src="{{static_asset('images/icons/sidebar-icon10.svg')}}" alt="" class="icon">
                                    <img src="{{static_asset('images/icons/sidebar-icon-active10.svg')}}" alt="" class="icon icon-active">
                                </span>
                                <span class="text">Settings</span>
                            </a>
                        </li>
                        <li class="sidebar-list__item">
                            <a href="{{route('admin.logout')}}" class="sidebar-list__link">
                                <span class="sidebar-list__icon">
                                    <img src="{{static_asset('images/icons/sidebar-icon13.svg')}}" alt="" class="icon">
                                    <img src="{{static_asset('images/icons/sidebar-icon-active13.svg')}}" alt="" class="icon icon-active">
                                </span>
                                <span class="text">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
