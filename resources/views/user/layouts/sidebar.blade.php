<div class="dashboard-sidebar">
    <button type="button" class="dashboard-sidebar__close d-lg-none d-flex">
        <i class="las la-times"></i>
    </button>
    <div class="dashboard-sidebar__inner">
        <a href="{{ route('user.index') }}" wire:navigate class="logo mb-48">
            <img src="{{ my_asset($settings->logo) }}" alt="" style="height: 50px;" />
        </a>
        <a href="{{ route('user.index') }}" wire:navigate class="logo favicon mb-48">
            <img src="{{ my_asset($settings->favicon) }}" alt="" style="height: 50px;" />
        </a>

        <!-- Sidebar List Start -->
        <ul class="sidebar-list">
            <li class="sidebar-list__item">
                <a href="{{ route('user.dashboard') }}" wire:navigate class="sidebar-list__link">
                    <span class="sidebar-list__icon">
                        <img src="{{ static_asset('images/icons/sidebar-icon1.svg') }}" alt="" class="icon" />
                        <img src="{{ static_asset('images/icons/sidebar-icon-active1.svg') }}" alt="" class="icon icon-active" />
                    </span>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-list__item">
                <a href="{{ route('user.profile') }}" class="sidebar-list__link">
                    <span class="sidebar-list__icon">
                        <img src="{{ static_asset('images/icons/sidebar-icon2.svg') }}" alt="" class="icon" />
                        <img src="{{ static_asset('images/icons/sidebar-icon-active2.svg') }}" alt="" class="icon icon-active" />
                    </span>
                    <span class="text">Profile</span>
                </a>
            </li>
            <li class="sidebar-list__item">
                <a href="{{ route('user.orders') }}" class="sidebar-list__link">
                    <span class="sidebar-list__icon">
                        <img src="{{ static_asset('images/icons/sidebar-icon12.svg') }}" alt="" class="icon" />
                        <img src="{{ static_asset('images/icons/sidebar-icon-active12.svg') }}" alt="" class="icon icon-active" />
                    </span>
                    <span class="text">Orders</span>
                </a>
            </li>
            <li class="sidebar-list__item">
                <a href="{{ route('user.reviews') }}" class="sidebar-list__link">
                    <span class="sidebar-list__icon">
                        <img src="{{ static_asset('images/icons/sidebar-icon7.svg') }}" alt="" class="icon" />
                        <img src="{{ static_asset('images/icons/sidebar-icon-active7.svg') }}" alt="" class="icon icon-active" />
                    </span>
                    <span class="text">Reviews</span>
                </a>
            </li>

            <li class="sidebar-list__item">
                <a href="{{ route('user.downloads') }}" class="sidebar-list__link">
                    <span class="sidebar-list__icon">
                        <img src="{{ static_asset('images/icons/sidebar-icon6.svg') }}" alt="" class="icon" />
                        <img src="{{ static_asset('images/icons/sidebar-icon-active6.svg') }}" alt="" class="icon icon-active" />
                    </span>
                    <span class="text">Downloads</span>
                </a>
            </li>
            <li class="sidebar-list__item">
                <a href="{{ route('logout') }}" class="sidebar-list__link">
                    <span class="sidebar-list__icon">
                        <img src="{{ static_asset('images/icons/sidebar-icon13.svg') }}" alt="" class="icon" />
                        <img src="{{ static_asset('images/icons/sidebar-icon-active13.svg') }}" alt="" class="icon icon-active" />
                    </span>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
        <!-- Sidebar List End -->
    </div>
</div>
