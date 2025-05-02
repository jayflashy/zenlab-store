<div class="d-sm-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Order Details</h1>
    </div>
    <div>
        <a wire:navigate href="{{ route('user.orders') }}" class="btn btn-outline-main">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
        <a wire:navigate href="{{ route('user.orders.invoice', $order->code) }}" class="btn btn-main">
            <i class="fas fa-file-alt me-1"></i> Invoice
        </a>
    </div>
</div>

<div class="common-card card">
    <ul class="common-list list-group list-group-flush">
        <li class="list-group-item  p-4">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <strong>Order ID</strong>
                </div>
                <div class="col-auto">
                    <span>#{{ $order->code }}</span>
                </div>
            </div>
        </li>
        <li class="list-group-item  p-4">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <strong>Order Date</strong>
                </div>
                <div class="col-auto">
                    <span>{{ show_datetime($order->created_at) }}</span>
                </div>
            </div>
        </li>
        <li class="list-group-item py-4">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <strong>Payment Status</strong>
                </div>
                <div class="col-auto">
                    @php
                        $paymentStatusClass =
                            [
                                'pending' => 'bg-warning',
                                'completed' => 'bg-success',
                                'failed' => 'bg-danger',
                            ][$order->payment_status] ?? 'bg-secondary';
                    @endphp
                    <span class="badge {{ $paymentStatusClass }}">{{ ucfirst($order->payment_status) }}</span>
                </div>
            </div>
        </li>
        <li class="list-group-item p-4">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <strong>Order Status</strong>
                </div>
                <div class="col-auto">
                    @php
                        $orderStatusClass =
                            [
                                'pending' => 'bg-warning',
                                'processing' => 'bg-info',
                                'completed' => 'bg-success',
                                'cancelled' => 'bg-secondary',
                                'failed' => 'bg-danger',
                            ][$order->order_status] ?? 'bg-secondary';
                    @endphp
                    <span class="badge {{ $orderStatusClass }}">{{ ucfirst($order->order_status) }}</span>
                </div>
            </div>
        </li>
        <li class="list-group-item  p-4">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <strong>Payment Method</strong>
                </div>
                <div class="col-auto">
                    @php
                        $paymentMethods = [
                            'paystack_payment' => 'Paystack',
                            'flutterwave_payment' => 'Flutterwave',
                            'paypal_payment' => 'PayPal',
                            'cryptomus_payment' => 'Cryptomus',
                            'manual_payment' => 'Bank Transfer',
                        ];
                        $paymentMethodLabel = $paymentMethods[$order->payment_method] ?? $order->payment_method;
                    @endphp
                    {{ $paymentMethodLabel }}
                </div>
            </div>
        </li>
    </ul>

</div>
<div class="common-card card mb-3">
    <ul class="common-list list-group list-group-flush">
        @foreach ($order->items as $item)
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <div class="mb-1">
                            <strong>{{ $item->product->name ?? '' }}</strong>
                            <span>
                                @if ($item->license_type)
                                    ({{ ucfirst($item->license_type) }})
                                @endif
                            </span>
                        </div>
                        <div>({{ format_price($item->price) }} x {{$item->quantity}})</div>
                    </div>
                    <div class="col-auto">
                        <h6 class="fw-light mb-0">{{ format_price($item->total) }}</h6>
                    </div>
                </div>
                <div class="row g-2 align-items-center mt-2">
                    <div class="col">
                        <div>
                            @if ($item->extended_support)
                            12 months of support
                            @else
                            6 months of support
                            @endif
                        </div>
                    </div>
                    <div class="col-auto">
                        <h6 class="fw-light mb-0">
                            {{ format_price($item->support_price) }}
                        </h6>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
<div class="common-card card">
    <ul class="common-list list-group list-group-flush">
        <li class="list-group-item  p-4">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <strong>SubTotal</strong>
                </div>
                <div class="col-auto">
                    <h6 class="mb-0">{{ format_price($order->subtotal) }}</h6>
                </div>
            </div>
        </li>
        <li class="list-group-item p-4">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <strong>Discount</strong>
                </div>
                <div class="col-auto">
                    <h6 class="mb-0">{{ format_price($order->discount) }}</h6>
                </div>
            </div>
        </li>
        <li class="list-group-item p-4">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h4 class="mb-0">Total</h4>
                </div>
                <div class="col-auto">
                    <h6 class="mb-0">{{ format_price($order->subtotal) }}</h6>
                </div>
            </div>
        </li>
    </ul>
</div>
