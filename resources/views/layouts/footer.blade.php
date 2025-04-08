<footer class="footer-section ">
    <img src="{{ static_asset('images/shapes/pattern.png') }}" alt="" class="bg-pattern">
    <img src="{{ static_asset('images/shapes/element1.png') }}" alt="" class="element one">
    <img src="{{ static_asset('images/shapes/element2.png') }}" alt="" class="element two">
    <img src="{{ static_asset('images/gradients/footer-gradient.png') }}" alt="" class="bg--gradient">

    <div class="container container-two">
        <div class="row gy-5">
            <div class="col-xl-3 col-sm-6">
                <div class="footer-widget">
                    <div class="footer-widget__logo">
                        <a href="index.html"> <img src="{{ static_asset('images/logo/white-logo.png') }}" alt=""></a>
                    </div>
                    <p class="footer-widget__desc">Lorem consultancy elitsed do eiusmod tempor inci didunt ut labore dolore magna aliqua sed
                        do eiusmod.</p>
                    <div class="footer-widget__social">
                        <ul class="social-icon-list">
                            <li class="social-icon-list__item">
                                <a href="https://www.facebook.com" class="social-icon-list__link flx-center"><i
                                        class="fab fa-facebook-f"></i></a>
                            </li>
                            <li class="social-icon-list__item">
                                <a href="https://www.twitter.com" class="social-icon-list__link flx-center"> <i
                                        class="fab fa-twitter"></i></a>
                            </li>
                            <li class="social-icon-list__item">
                                <a href="https://www.linkedin.com" class="social-icon-list__link flx-center"> <i
                                        class="fab fa-linkedin-in"></i></a>
                            </li>
                            <li class="social-icon-list__item">
                                <a href="https://www.pinterest.com" class="social-icon-list__link flx-center"> <i
                                        class="fab fa-pinterest-p"></i></a>
                            </li>
                            <li class="social-icon-list__item">
                                <a href="https://www.pinterest.com" class="social-icon-list__link flx-center"> <i
                                        class="fab fa-youtube"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-6">
                <div class="footer-widget">
                    <h5 class="footer-widget__title text-white">Useful Link</h5>
                    <ul class="footer-lists">
                        <li class="footer-lists__item"><a href="{{ route('products') }}" wire:navigate class="footer-lists__link">Product </a></li>
                        <li class="footer-lists__item"><a href="{{ route('cart') }}" wire:navigate class="footer-lists__link">Shopping Cart</a></li>
                        @auth
                            <li class="footer-lists__item"><a href="{{ route('user.dashboard') }}" wire:navigate class="footer-lists__link">Dashboard</a></li>
                        @else
                            <li class="footer-lists__item"><a href="login.html" wire:navigate class="footer-lists__link">Login </a></li>
                            <li class="footer-lists__item"><a href="register.html" wire:navigate class="footer-lists__link">Register</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-6 ps-xl-5">
                <div class="footer-widget">
                    <h5 class="footer-widget__title text-white">Quick Links</h5>
                    <ul class="footer-lists">
                        <li class="footer-lists__item"><a href="about.html" wire:navigate class="footer-lists__link">About Us</a></li>
                        <li class="footer-lists__item"><a href="{{route('blogs')}}" wire:navigate class="footer-lists__link">Blog </a></li>
                        <li class="footer-lists__item"><a href="terms.html" wire:navigate class="footer-lists__link">Terms and Conditions</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="footer-widget">
                    <h5 class="footer-widget__title text-white">Categories</h5>
                    <ul class="footer-lists">
                        <li class="footer-lists__item"><a href="dashboard.html" class="footer-lists__link">Dashboard </a></li>
                        <li class="footer-lists__item"><a href="login.html" class="footer-lists__link">Login </a></li>
                        <li class="footer-lists__item"><a href="register.html" class="footer-lists__link">Register</a></li>
                        <li class="footer-lists__item"><a href="blog.html" class="footer-lists__link">Blog </a></li>
                        <li class="footer-lists__item"><a href="blog-details.html" class="footer-lists__link">Blog Details</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- bottom Footer -->
<div class="bottom-footer">
    <div class="container container-two">
        <div class="bottom-footer__inner flx-between gap-3">
            <p class="bottom-footer__text font-14"> Copyright &copy; {{ Date('Y') . get_setting('name') }}, All rights reserved.</p>
            <div class="footer-links">
                <a href="#" class="footer-link font-14">Terms of service</a>
                <a href="#" class="footer-link font-14">Privacy Policy</a>
                <a href="contact.html" class="footer-link font-14">cookies</a>
            </div>
        </div>
    </div>
</div>
