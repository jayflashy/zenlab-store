@section('title', $order->order_status == 'completed' ? 'Transaction Successful' : 'Order Status: ' . ucfirst($order->order_status))

<section class="cart-thank section-bg padding-y-120 position-relative z-index-1 overflow-hidden">
    <img src="{{ static_asset('images/gradients/thank-you-gradient.png') }}" alt="" class="bg--gradient">

    <div class="container container-two">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="cart-thank__content text-center">
                    <h3 class="cart-thank__title mb-10">
                        @if ($order->order_status == 'completed')
                            Transaction Successful
                        @elseif ($order->order_status == 'pending')
                            Transaction in Process
                        @else
                            Order {{ ucfirst($order->order_status) }}
                        @endif
                    </h3>
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
                                    <span class="text text-heading fw-500">#{{ $order->code }}</span>
                                </li>
                                <li class="list-text__item flx-align flex-nowrap">
                                    <span class="text text-heading fw-500">Order Status</span>
                                    <span class="text">
                                        @if ($order->order_status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($order->order_status == 'processing')
                                            <span class="badge bg-info">Processing</span>
                                        @elseif($order->order_status == 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($order->order_status == 'failed' || $order->order_status == 'cancelled')
                                            <span class="badge bg-danger">{{ ucfirst($order->order_status) }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($order->order_status) }}</span>
                                        @endif
                                    </span>
                                </li>
                                <li class="list-text__item flx-align flex-nowrap">
                                    <span class="text text-heading fw-500">Payment Method:</span>
                                    <span class="text">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                                </li>
                                <li class="list-text__item flx-align flex-nowrap">
                                    <span class="text text-heading fw-500">Date:</span>
                                    <span class="text">{{ show_datetime($order->created_at) }}</span>
                                </li>
                                <li class="list-text__item flx-align flex-nowrap">
                                    <span class="text text-heading fw-500">Total</span>
                                    <span class="text">{{ format_price($order->total) }}</span>
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
                                @foreach ($orderItems as $item)
                                    <li class="list-text__item flx-align flex-nowrap">
                                        <span class="text text-heading fw-500">
                                            {{ $item->product->name }}
                                            @if ($item->license_type)
                                                <small>({{ ucfirst($item->license_type) }})</small>
                                            @endif
                                            @if ($item->extended_support)
                                            <small> + Support</small>
                                        @endif
                                        </span>
                                        <span class="text">{{ format_price($item->price) }}</span>
                                    </li>
                                @endforeach
                                @if ($order->discount > 0)
                                    <li class="list-text__item flx-align flex-nowrap">
                                        <span class="text text-heading fw-500">Discount</span>
                                        <span class="text">-{{ format_price($order->discount) }}</span>
                                    </li>
                                @endif
                                <li class="list-text__item flx-align flex-nowrap">
                                    <span class="text text-heading fw-500">Total</span>
                                    <span class="text">{{ format_price($order->total) }}</span>
                                </li>
                            </ul>
                            <div class="flx-between gap-2 mt-3">
                                <p class="text">Please don't forget to rate</p>
                                <a href="{{ route('home') }}" class="btn btn-main flx-align gap-2 pill">
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
