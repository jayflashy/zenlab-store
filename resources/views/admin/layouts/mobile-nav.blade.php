<div class="mobile-menu d-lg-none d-block">
    <button type="button" class="close-button">
        <i class="las la-times"></i>
    </button>
    <div class="mobile-menu__inner">
        <a href="{{route('home')}}" class="mobile-menu__logo">
            <img src="assets/images/logo/logo.png" alt="Logo" />
        </a>
        <div class="mobile-menu__menu">
            <ul class="nav-menu flx-align nav-menu--mobile">
                <li class="nav-menu__item has-submenu">
                    <a href="javascript:void(0)" class="nav-menu__link">Home</a>
                    <ul class="nav-submenu">
                        <li class="nav-submenu__item">
                            <a href="{{route('home')}}" class="nav-submenu__link"> Home One</a>
                        </li>
                        <li class="nav-submenu__item">
                            <a href="index-two.html" class="nav-submenu__link">
                                Home Two</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-menu__item has-submenu">
                    <a href="javascript:void(0)" class="nav-menu__link">Products</a>
                    <ul class="nav-submenu">
                        <li class="nav-submenu__item">
                            <a href="all-product.html" class="nav-submenu__link">
                                All Products</a>
                        </li>
                        <li class="nav-submenu__item">
                            <a href="product-details.html" class="nav-submenu__link">
                                Product Details</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-menu__item has-submenu">
                    <a href="javascript:void(0)" class="nav-menu__link">Pages</a>
                    <ul class="nav-submenu">
                        <li class="nav-submenu__item">
                            <a href="profile.html" class="nav-submenu__link"> Profile</a>
                        </li>
                        <li class="nav-submenu__item">
                            <a href="cart.html" class="nav-submenu__link">
                                Shopping Cart</a>
                        </li>
                        <li class="nav-submenu__item">
                            <a href="cart-personal.html" class="nav-submenu__link">
                                Mailing Address</a>
                        </li>
                        <li class="nav-submenu__item">
                            <a href="cart-payment.html" class="nav-submenu__link">
                                Payment Method</a>
                        </li>
                        <li class="nav-submenu__item">
                            <a href="cart-thank-you.html" class="nav-submenu__link">
                                Preview Order</a>
                        </li>
                        <li class="nav-submenu__item">
                            <a href="dashboard.html" class="nav-submenu__link">
                                Dashboard</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-menu__item has-submenu">
                    <a href="javascript:void(0)" class="nav-menu__link">Blog</a>
                    <ul class="nav-submenu">
                        <li class="nav-submenu__item">
                            <a href="blog.html" class="nav-submenu__link"> Blog</a>
                        </li>
                        <li class="nav-submenu__item">
                            <a href="blog-details.html" class="nav-submenu__link">
                                Blog Details</a>
                        </li>
                        <li class="nav-submenu__item">
                            <a href="blog-details-sidebar.html" class="nav-submenu__link">
                                Blog Details Sidebar</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-menu__item">
                    <a href="contact.html" class="nav-menu__link">Contact</a>
                </li>
            </ul>
            <div class="header-right__inner d-lg-none my-3 gap-1 d-flex flx-align">
                <a href="{{route('register')}}" class="btn btn-main pill">
                    <span class="icon-left icon">
                        <img src="assets/images/icons/user.svg" alt="" /> </span>Create Account
                </a>
                <div class="language-select flx-align select-has-icon">
                    <img src="assets/images/icons/globe.svg" alt="" class="globe-icon" />
                    <select class="select py-0 ps-2 border-0 fw-500">
                        <option value="1">Eng</option>
                        <option value="2">Bn</option>
                        <option value="3">Eur</option>
                        <option value="4">Urd</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
