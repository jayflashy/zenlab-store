@section('title', 'Contact Us')
<div>
    {{-- breadcrumb --}}
    <x-breadcrumb title="Contact Us" page="Contact" />

    {{-- content --}}
    <section class="contact padding-t-120 padding-b-60 section-bg position-relative z-index-1 overflow-hidden">
        <img src="{{ static_asset('images/gradients/banner-two-gradient.png') }}" alt="" class="bg--gradient">
        <img src="{{ static_asset('images/shapes/pattern-five.png') }}" class="position-absolute end-0 top-0 z-index--1" alt="">

        <div class="container container-two">
            <div class="row gy-4">
                <div class="col-lg-5">
                    <div class="contact-info">
                        <h3 class="contact-info__title">Get in touch with us today</h3>
                        <p class="contact-info__desc">Jadesdev is a cutting-edge software development company specializing in web and mobile
                            application solutions. With a focus on innovative technology and user-centric design, we create robust digital
                            experiences that help businesses thrive in today's competitive landscape.</p>

                        <div class="contact-info__item-wrapper flx-between gap-4">
                            <div class="contact-info__item">
                                <span class="contact-info__text text-capitalize d-block mb-1">Give Us A Call</span>
                                <a href="tel:{{ $settings->phone }}"
                                    class="contact-info__link font-24 fw-500 text-heading hover-text-main">{{ $settings->phone }}</a>
                            </div>
                            <div class="contact-info__item">
                                <span class="contact-info__text text-capitalize d-block mb-1">Give Us An Email</span>
                                <a href="tel:dpmarket@gmail.com"
                                    class="contact-info__link font-24 fw-500 text-heading hover-text-main">{{ $settings->email }}</a>
                            </div>
                        </div>

                        <div class="mt-24">
                            <ul class="social-icon-list">
                                <li class="social-icon-list__item">
                                    <a href="https://www.facebook.com/zenovatetech"
                                        class="social-icon-list__link text-heading flx-center"><i class="fab fa-facebook-f"></i></a>
                                </li>
                                <li class="social-icon-list__item">
                                    <a href="https://www.twitter.com/zenovatetech" class="social-icon-list__link text-heading flx-center">
                                        <i class="fab fa-twitter"></i></a>
                                </li>
                                <li class="social-icon-list__item">
                                    <a href="https://www.linkedin.com/company/jadesdev-technologies"
                                        class="social-icon-list__link text-heading flx-center"> <i class="fab fa-linkedin-in"></i></a>
                                </li>
                                <li class="social-icon-list__item">
                                    <a href="https://t.me/jadesdev" class="social-icon-list__link text-heading flx-center"> <i
                                            class="fab fa-telegram"></i></a>
                                </li>
                                <li class="social-icon-list__item">
                                    <a href="https://wa.me/2348035852702" class="social-icon-list__link text-heading flx-center"> <i
                                            class="fab fa-whatsapp"></i></a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="col-lg-7 ps-lg-5">
                    <div class="card common-card p-sm-4">
                        <div class="card-body">
                            <form action="#" autocomplete="off" wire:submit.prevent="submit">
                                <div class="row gy-4">
                                    <div class="col-sm-6 col-xs-6">
                                        <label for="name" class="form-label mb-2 font-18 font-heading fw-600">Full Name</label>
                                        <input type="text" class="common-input common-input--grayBg border" id="name"
                                            placeholder="Your name here" wire:model="name">
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <label for="email" class="form-label mb-2 font-18 font-heading fw-600">Your Mail</label>
                                        <input type="email" class="common-input common-input--grayBg border" id="email"
                                            placeholder="Your email here " wire:model="email">
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="message" class="form-label mb-2 font-18 font-heading fw-600">Your Message</label>
                                        <textarea class="common-input common-input--grayBg border" id="message" placeholder="Write Your Message Here" wire:model="message"></textarea>
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
    {{-- Primary Meta Tags --}}
    <meta name="title" content="{{ $metaTitle ?? get_setting('title', 'ZenLab stores') }}">
    <meta name="description" content="{{ $metaDescription ?? get_setting('meta_description', 'Zenlab scripts store for quality scripts') }}">
    <meta name="keywords" content="{{ $metaKeywords ?? get_setting('meta_keywords', 'web, design, scripts, templates') }}">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $metaTitle ?? get_setting('title', 'ZenLab stores') }}">
    <meta property="og:description"
        content="{{ $metaDescription ?? get_setting('meta_description', 'Zenlab scripts store for quality scripts') }}">
    <meta property="og:image" content="{{ $metaImage ?? my_asset(get_setting('logo')) }}">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ $metaTitle ?? get_setting('title', 'ZenLab stores') }}">
    <meta name="twitter:description"
        content="{{ $metaDescription ?? get_setting('meta_description', 'Zenlab scripts store for quality scripts') }}">
    <meta name="twitter:image" content="{{ $metaImage ?? my_asset(get_setting('logo')) }}">
@endsection
