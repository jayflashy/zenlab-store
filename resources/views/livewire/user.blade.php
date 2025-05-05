<div class="dashboard-body__content">

    <!-- welcome balance Content Start -->
    <div class="welcome-balance mt-2 mb-40 flx-between gap-2">
        <div class="welcome-balance__left">
            <h4 class="welcome-balance__title mb-0">Welcome back! {{ ucfirst($user->username) }}</h4>
        </div>
        {{-- <div class="welcome-balance__right flx-align gap-2">
            <span class="welcome-balance__text fw-500 text-heading">Available Balance:</span>
            <h4 class="welcome-balance__balance mb-0">{{format_price($user->balance)}}</h4>
        </div> --}}
    </div>
    <!-- welcome balance Content End -->

    <div class="dashboard-body__item-wrapper">

        <!-- dashboard body Item Start -->
        <div class="dashboard-body__item">
            <div class="row gy-4">
                <div class="col-xl-3 col-sm-6">
                    <div class="dashboard-widget">
                        <img src="{{ static_asset('images/shapes/widget-shape1.png') }}" alt="" class="dashboard-widget__shape one">
                        <img src="{{ static_asset('images/shapes/widget-shape2.png') }}" alt="" class="dashboard-widget__shape two">
                        <span class="dashboard-widget__icon">
                            <img src="{{ static_asset('images/icons/dashboard-widget-icon1.svg') }}" alt="">
                        </span>
                        <div class="dashboard-widget__content flx-between gap-1 align-items-end">
                            <div>
                                <h4 class="dashboard-widget__number mb-1 mt-3">{{ $totalOrders }}</h4>
                                <span class="dashboard-widget__text font-14">Total Orders</span>
                            </div>
                            <img src="{{ static_asset('images/icons/chart-icon.svg') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="dashboard-widget">
                        <img src="{{ static_asset('images/shapes/widget-shape1.png') }}" alt="" class="dashboard-widget__shape one">
                        <img src="{{ static_asset('images/shapes/widget-shape2.png') }}" alt="" class="dashboard-widget__shape two">
                        <span class="dashboard-widget__icon">
                            <img src="{{ static_asset('images/icons/dashboard-widget-icon2.svg') }}" alt="">
                        </span>
                        <div class="dashboard-widget__content flx-between gap-1 align-items-end">
                            <div>
                                <h4 class="dashboard-widget__number mb-1 mt-3">{{ $completedOrders }}</h4>
                                <span class="dashboard-widget__text font-14">Completed Orders</span>
                            </div>
                            <img src="{{ static_asset('images/icons/chart-icon.svg') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="dashboard-widget">
                        <img src="{{ static_asset('images/shapes/widget-shape1.png') }}" alt=""
                            class="dashboard-widget__shape one">
                        <img src="{{ static_asset('images/shapes/widget-shape2.png') }}" alt=""
                            class="dashboard-widget__shape two">
                        <span class="dashboard-widget__icon">
                            <img src="{{ static_asset('images/icons/dashboard-widget-icon3.svg') }}" alt="">
                        </span>
                        <div class="dashboard-widget__content flx-between gap-1 align-items-end">
                            <div>
                                <h4 class="dashboard-widget__number mb-1 mt-3">{{ $totalItems }}</h4>
                                <span class="dashboard-widget__text font-14">Total Items</span>
                            </div>
                            <img src="{{ static_asset('images/icons/chart-icon.svg') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="dashboard-widget">
                        <img src="{{ static_asset('images/shapes/widget-shape1.png') }}" alt=""
                            class="dashboard-widget__shape one">
                        <img src="{{ static_asset('images/shapes/widget-shape2.png') }}" alt=""
                            class="dashboard-widget__shape two">
                        <span class="dashboard-widget__icon">
                            <img src="{{ static_asset('images/icons/dashboard-widget-icon4.svg') }}" alt="">
                        </span>
                        <div class="dashboard-widget__content flx-between gap-1 align-items-end">
                            <div>
                                <h4 class="dashboard-widget__number mb-1 mt-3">{{ format_price($totalSpent) }}</h4>
                                <span class="dashboard-widget__text font-14">Total Spent</span>
                            </div>
                            <img src="{{ static_asset('images/icons/chart-icon.svg') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- dashboard body Item End -->

        {{-- recent orders --}}
        <div class="dashboard-body_item mb-4">
            <div class="dashboard-card">
                <div class="dashboard-card__header flx-between gap-2">
                    <h6 class="dashboard-card__title mb-0">Recent Orders</h6>
                    <a wire:navigate href="{{ route('user.orders') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="dashboard-card__chart">
                    <div class="table-responsive">
                        <table class="table style-two">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Amount</th>
                                    <th>Payment Status</th>
                                    <th>Order Status</th>
                                    <th>Date</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td>
                                            <a wire:navigate href="{{ route('user.orders.view', $order->code) }}"
                                                class="fw-bold">#{{ $order->code }}</a>
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ format_price($order->total) }}</div>
                                            @if ($order->discount > 0)
                                                <small class="text-warning">-{{ format_price($order->discount) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span
                                                class="badge {{ getPaymentStatusClass($order->payment_status) }}">{{ ucfirst($order->payment_status) }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge {{ getOrderStatusClass($order->order_status) }}">{{ ucfirst($order->order_status) }}</span>
                                        </td>
                                        <td>{{ show_date($order->created_at, 'M d, Y H:ia') }}</td>
                                        <td class="text-end">
                                            <div class=" gap-2">
                                                @if ($order->payment_status === 'completed')
                                                    <a wire:navigate href="{{ route('user.orders.invoice', $order->code) }}"
                                                        title="Invoice" class="btn btn-sm btn-outline-primary" target="_blank">
                                                        <i class="far fa-file-alt"></i>
                                                    </a>
                                                @endif
                                                <a wire:navigate href="{{ route('user.orders.view', $order->code) }}"
                                                    class="btn btn-sm btn-main">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            No orders found matching your criteria.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@section('title', 'Dashboard')
@include('layouts.meta')
