@section('title', 'Transaction Successful')
<div>
    <section class="cart-thank section-bg padding-y-120 position-relative z-index-1 overflow-hidden">

        <img src="{{ static_asset('images/gradients/thank-you-gradient.png') }}" alt="" class="bg--gradient">

        <div class="container container-two">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-sm-10">
                    <div class="cart-thank__content text-center">
                        <h2 class="cart-thank__title mb-18">Transaction in process</h2>
                    </div>
                </div>
            </div>

            <div class="padding-t-120">
                <div class="cart-thank__box">
                    <div class="row gy-4">
                        <div class="col-lg-6">
                            <div class="thank-card">
                                <h5 class="thank-card__title mb-3">Order Details</h5>
                                <ul class="list-text lef">
                                    <li class="list-text__item flx-align flex-nowrap">
                                        <span class="text text-heading fw-500 font-heading fw-700 font-18">Order No.</span>
                                        <span class="text text-heading fw-500">#658907</span>
                                    </li>
                                    <li class="list-text__item flx-align flex-nowrap">
                                        <span class="text text-heading fw-500">Order Status</span>
                                        <span class="text"><span class="badge bg-warning">pending</span></span>
                                    </li>
                                    <li class="list-text__item flx-align flex-nowrap">
                                        <span class="text text-heading fw-500">Payment Method:</span>
                                        <span class="text">Manual</span>
                                    </li>
                                    <li class="list-text__item flx-align flex-nowrap">
                                        <span class="text text-heading fw-500">Date:</span>
                                        <span class="text">{{ show_datetime(now()) }}</span>
                                    </li>
                                    <li class="list-text__item flx-align flex-nowrap">
                                        <span class="text text-heading fw-500">Total</span>
                                        <span class="text">$28.00</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="thank-card">
                                <h5 class="thank-card__title mb-3">Products you have purchased</h5>
                                <ul class="list-text">
                                    <li class="list-text__item flx-align flex-nowrap">
                                        <span class="text text-heading fw-500 font-heading fw-700 font-18">Name</span>
                                        <span class="text text-heading fw-500">Price</span>
                                    </li>
                                    <li class="list-text__item flx-align flex-nowrap">
                                        <span class="text text-heading fw-500">SaaS Landing Page</span>
                                        <span class="text">$28.00</span>
                                    </li>
                                    <li class="list-text__item flx-align flex-nowrap">
                                        <span class="text text-heading fw-500">Project Management Dashboard </span>
                                        <span class="text">$28.00</span>
                                    </li>
                                    <li class="list-text__item flx-align flex-nowrap">
                                        <span class="text text-heading fw-500">Consulting Agency Template</span>
                                        <span class="text">$28.00</span>
                                    </li>
                                    <li class="list-text__item flx-align flex-nowrap">
                                        <span class="text text-heading fw-500">Total</span>
                                        <span class="text">$208.00</span>
                                    </li>
                                </ul>
                                <div class="flx-between gap-2 mt-3">
                                    <p class="text">Please don't forget to rate </p>
                                    <a href="index.html" class="btn btn-main flx-align gap-2 pill">
                                        Back To Home
                                        <span class="icon line-height-1 font-20"><i class="las la-arrow-right"></i></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@section('meta')

@endsection

@section('styles')
    <style>
        .lef .list-text__item .text:first-child {
            width: 40%;
        }

        .list-text__item .text:first-child {
            width: 70%;
        }
    </style>
@endsection
