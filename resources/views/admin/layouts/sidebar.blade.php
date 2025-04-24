<div class="dashboard-sidebar">
    <button type="button" class="dashboard-sidebar__close d-lg-none d-flex"><i class="las la-times"></i></button>
    <div class="dashboard-sidebar__inner">
        <a href="{{ route('admin.index') }}" wire:navigate class="logo mb-48">
            <img src="{{ my_asset($settings->logo) }}" alt="" class="white-version main-logo">
            <img src="{{ my_asset($settings->logo) }}" alt="" class="dark-version main-logo">
        </a>
        <a href="{{ route('admin.index') }}" wire:navigate class="logo favicon mb-48">
            <img src="{{ my_asset($settings->favicon) }}" alt="" class=" main-logo">
        </a>


        <!-- Sidebar List Start -->
        <ul class="sidebar-list">
            <li class="sidebar-list__item">
                <a href="{{ route('admin.index') }}" wire:navigate class="sidebar-list__link">
                    <span class="sidebar-list__icon">
                        <img src="{{ static_asset('images/icons/sidebar-icon1.svg') }}" alt="" class="icon">
                        <img src="{{ static_asset('images/icons/sidebar-icon-active1.svg') }}" alt="" class="icon icon-active">
                    </span>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-list__item">
                <a href="{{ route('admin.categories') }}" wire:navigate class="sidebar-list__link">
                    <span class="sidebar-list__icon">
                        <i class="fa fa-tags icon"></i>
                        <i class="fa fa-tags icon-active"></i>
                    </span>
                    <span class="text">Categories</span>
                </a>
            </li>
            <li class="sidebar-list__item side-hsb">
                <a href="javascript:void(0)" class="sidebar-list__link">
                    <span class="sidebar-list__icon">
                        <i class="fa fa-users icon-active"></i>
                        <i class="fa fa-users icon"></i>
                    </span>
                    <span class="text">Products</span>
                </a>
                <ul class="side-submenu">
                    <li class="nav-submenu__item">
                        <a href="{{ route('admin.products.create') }}" wire:navigate class="nav-submenu__link">Add</a>
                    </li>
                    <li class="nav-submenu__item">
                        <a href="{{ route('admin.products.index') }}" wire:navigate class="nav-submenu__link">Listing</a>
                    </li>
                    <li class="nav-submenu__item">
                        <a href="{{ route('admin.products.comments') }}" wire:navigate class="nav-submenu__link">Comments
                            {{-- <span class="badge bg-warning">2</span> cache pending  comments--}}
                        </a>
                    </li>
                    <li class="nav-submenu__item">
                        <a href="{{ route('admin.products.ratings') }}" wire:navigate class="nav-submenu__link">Ratings
                            {{-- <span class="badge bg-warning">2</span> cache pending  ratings--}}
                        </a>
                    </li>
                    <li class="nav-submenu__item">
                        <a href="#" wire:navigate class="nav-submenu__link">Settings</a>
                    </li>
                </ul>
            </li>

            <!-- Licenses -->
            <li class="sidebar-list__item">
                <a href="#" wire:navigate class="sidebar-list__link">
                    <span class="sidebar-list__icon">
                        <i class="fa fa-key icon"></i>
                        <i class="fa fa-key icon-active"></i>
                    </span>
                    <span class="text">Licenses</span>
                </a>
            </li>

            <!-- Coupons -->
            <li class="sidebar-list__item">
                <a href="#" wire:navigate class="sidebar-list__link">
                    <span class="sidebar-list__icon">
                        <i class="fa fa-percent icon"></i>
                        <i class="fa fa-percent icon-active"></i>
                    </span>
                    <span class="text">Coupons</span>
                </a>
            </li>
            <!-- Users -->
            <li class="sidebar-list__item">
                <a href="#" wire:navigate class="sidebar-list__link">
                    <span class="sidebar-list__icon">
                        <i class="fa fa-user icon"></i>
                        <i class="fa fa-user icon-active"></i>
                    </span>
                    <span class="text">Users</span>
                </a>
            </li>

            <!-- Orders -->
            <li class="sidebar-list__item">
                <a href="#" wire:navigate class="sidebar-list__link">
                    <span class="sidebar-list__icon">
                        <i class="fa fa-shopping-cart icon"></i>
                        <i class="fa fa-shopping-cart icon-active"></i>
                    </span>
                    <span class="text">Orders</span>
                </a>
            </li>
            <!-- Reports -->
            <li class="sidebar-list__item">
                <a href="#" wire:navigate class="sidebar-list__link">
                    <span class="sidebar-list__icon">
                        <i class="fa fa-chart-line icon"></i>
                        <i class="fa fa-chart-line icon-active"></i>
                    </span>
                    <span class="text">Reports</span>
                </a>
            </li>

            <!-- Blog -->
            <li class="sidebar-list__item side-hsb">
                <a href="javascript:void(0)" class="sidebar-list__link">
                    <span class="sidebar-list__icon">
                        <i class="fa fa-blog icon"></i>
                        <i class="fa fa-blog icon-active"></i>
                    </span>
                    <span class="text">Blogs</span>
                </a>
                <ul class="side-submenu">
                    <li class="nav-submenu__item">
                        <a href="{{ route('admin.blogs.create') }}" wire:navigate class="nav-submenu__link">Add Post</a>
                    </li>
                    <li class="nav-submenu__item">
                        <a href="{{ route('admin.blogs') }}" wire:navigate class="nav-submenu__link">All Posts</a>
                    </li>
                </ul>
            </li>
            {{-- Pages --}}
            <li class="sidebar-list__item side-hsb">
                <a href="javascript:void(0)" class="sidebar-list__link">
                    <span class="sidebar-list__icon">
                        <i class="fa fa-folders icon"></i>
                        <i class="fa fa-folders icon-active"></i>
                    </span>
                    <span class="text">Pages</span>
                </a>
                <ul class="side-submenu">
                    <li class="nav-submenu__item">
                        <a href="{{ route('admin.pages.create') }}" wire:navigate class="nav-submenu__link">New Page</a>
                    </li>
                    <li class="nav-submenu__item">
                        <a href="{{ route('admin.pages') }}" wire:navigate class="nav-submenu__link">All Pages</a>
                    </li>
                </ul>
            </li>

            <!-- Email -->
            <li class="sidebar-list__item side-hsb">
                <a href="javascript:void(0)" class="sidebar-list__link">
                    <span class="sidebar-list__icon">
                        <i class="fa fa-envelope icon"></i>
                        <i class="fa fa-envelope icon-active"></i>
                    </span>
                    <span class="text">Email</span>
                </a>
                <ul class="side-submenu">
                    <li class="nav-submenu__item"><a href="{{ route('admin.email.templates') }}" wire:navigate
                            class="nav-submenu__link">Templates</a></li>
                    <li class="nav-submenu__item"><a href="{{ route('admin.email.settings') }}" wire:navigate
                            class="nav-submenu__link">Settings</a></li>
                </ul>
            </li>

            <li class="sidebar-list__item side-hsb">
                <a href="javascript:void(0)" class="sidebar-list__link">
                    <span class="sidebar-list__icon">
                        <img src="{{ static_asset('images/icons/sidebar-icon10.svg') }}" alt="" class="icon">
                        <img src="{{ static_asset('images/icons/sidebar-icon-active10.svg') }}" alt="" class="icon icon-active">
                    </span>
                    <span class="text">Settings</span>
                </a>
                <ul class="side-submenu">
                    <li class="nav-submenu__item">
                        <a href="{{ route('admin.settings') }}" wire:navigate class="nav-submenu__link">General </a>
                    </li>
                    <li class="nav-submenu__item">
                        <a href="{{ route('admin.settings.payments') }}" wire:navigate class="nav-submenu__link">Payments</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-list__item">
                <a href="login.html" wire:navigate class="sidebar-list__link">
                    <span class="sidebar-list__icon">
                        <img src="{{ static_asset('images/icons/sidebar-icon13.svg') }}" alt="" class="icon">
                        <img src="{{ static_asset('images/icons/sidebar-icon-active13.svg') }}" alt="" class="icon icon-active">
                    </span>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
        <!-- Sidebar List End -->

    </div>
</div>
