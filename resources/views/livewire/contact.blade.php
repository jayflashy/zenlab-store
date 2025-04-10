@section('title', 'Contact Us')
<div>
    {{-- breadcrumb --}}
    <x-breadcrumb title="Contact Us" page="Contact" />

    {{-- content --}}
    <section class="contact padding-t-120 padding-b-60 section-bg position-relative z-index-1 overflow-hidden">
        <img src="{{static_asset('images/gradients/banner-two-gradient.png')}}" alt="" class="bg--gradient">
        <img src="{{static_asset('images/shapes/pattern-five.png')}}" class="position-absolute end-0 top-0 z-index--1" alt="">

        <div class="container container-two">
            <div class="row gy-4">
                <div class="col-lg-5">
                    <div class="contact-info">
                        <h3 class="contact-info__title">Get in touch with us today</h3>
                        <p class="contact-info__desc">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptatum rem facere labore
                            cupiditate sint? Animi quis illo suscipit autem cum.</p>

                        <div class="contact-info__item-wrapper flx-between gap-4">
                            <div class="contact-info__item">
                                <span class="contact-info__text text-capitalize d-block mb-1">Give Us A Call</span>
                                <a href="tel:01812345678"
                                    class="contact-info__link font-24 fw-500 text-heading hover-text-main">01812345678</a>
                            </div>
                            <div class="contact-info__item">
                                <span class="contact-info__text text-capitalize d-block mb-1">Give Us An Email</span>
                                <a href="tel:dpmarket@gmail.com"
                                    class="contact-info__link font-24 fw-500 text-heading hover-text-main">dpmarket@gmail.com</a>
                            </div>
                        </div>

                        <div class="mt-24">
                            <ul class="social-icon-list">
                                <li class="social-icon-list__item">
                                    <a href="https://www.facebook.com" class="social-icon-list__link text-heading flx-center"><i
                                            class="fab fa-facebook-f"></i></a>
                                </li>
                                <li class="social-icon-list__item">
                                    <a href="https://www.twitter.com" class="social-icon-list__link text-heading flx-center"> <i
                                            class="fab fa-twitter"></i></a>
                                </li>
                                <li class="social-icon-list__item">
                                    <a href="https://www.linkedin.com" class="social-icon-list__link text-heading flx-center"> <i
                                            class="fab fa-linkedin-in"></i></a>
                                </li>
                                <li class="social-icon-list__item">
                                    <a href="https://www.pinterest.com" class="social-icon-list__link text-heading flx-center"> <i
                                            class="fab fa-pinterest-p"></i></a>
                                </li>
                                <li class="social-icon-list__item">
                                    <a href="https://www.pinterest.com" class="social-icon-list__link text-heading flx-center"> <i
                                            class="fab fa-youtube"></i></a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="col-lg-7 ps-lg-5">
                    <div class="card common-card p-sm-4">
                        <div class="card-body">
                            <form action="#" autocomplete="off">
                                <div class="row gy-4">
                                    <div class="col-sm-6 col-xs-6">
                                        <label for="name" class="form-label mb-2 font-18 font-heading fw-600">Full Name</label>
                                        <input type="text" class="common-input common-input--grayBg border" id="name"
                                            placeholder="Your name here">
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <label for="email" class="form-label mb-2 font-18 font-heading fw-600">Your Mail</label>
                                        <input type="email" class="common-input common-input--grayBg border" id="email"
                                            placeholder="Your email here ">
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="message" class="form-label mb-2 font-18 font-heading fw-600">Your Message</label>
                                        <textarea class="common-input common-input--grayBg border" id="message" placeholder="Write Your Message Here"></textarea>
                                    </div>
                                    <div class="col-sm-12">
                                        <button class="btn btn-main btn-lg pill w-100"> Submit Now </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@section('meta')

@endsection
