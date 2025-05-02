<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Orders</h1>
        <p class="text-muted small">Manage customer orders and payments</p>
    </div>
</div>

<!-- Search and Filters -->
<div class="common-card card mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4 col-lg-3">
                <label for="search" class="form-label">Search</label>
                <input wire:model.live.debounce.300ms="searchTerm" type="search" id="search" class="common-input border"
                    placeholder="Search by order code, customer name or email">
            </div>

            <div class="col-sm-6 col-md-4 col-lg-3">
                <label for="statusFilter" class="form-label">Order Status</label>
                <div class="select-has-icon">
                    <select wire:model.live="statusFilter" id="statusFilter" class="common-input border">
                        <option value="">All Statuses</option>
                        @foreach ($orderStatuses as $key => $orderStatus)
                            <option value="{{ $key }}">{{ $orderStatus }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-3">
                <label for="paymentStatusFilter" class="form-label">Payment Status</label>
                <div class="select-has-icon">
                    <select wire:model.live="paymentStatusFilter" id="paymentStatusFilter" class="common-input border">
                        <option value="">All Statuses</option>
                        @foreach ($paymentStatuses as $key => $paymentStatus)
                            <option value="{{ $key }}">{{ $paymentStatus }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-3">
                <label for="perPage" class="form-label">Show</label>
                <div class="select-has-icon">
                    <select wire:model.live="perPage" id="perPage" class="common-input border">
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card common-card">
    <div class="card-body table-responsive">
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
                            <a wire:navigate href="{{ route('user.orders.view', $order->code) }}" class="fw-bold">#{{ $order->code }}</a>
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
                            <span class="badge {{ getOrderStatusClass($order->order_status) }}">{{ ucfirst($order->order_status) }}</span>
                        </td>
                        <td>{{ show_date($order->created_at, 'M d, Y H:ia') }}</td>
                        <td class="text-end">
                            <div class=" gap-2">
                                @if ($order->payment_status === 'completed')
                                    <a wire:navigate href="{{ route('user.orders.invoice', $order->code) }}" title="Invoice"
                                        class="btn btn-sm btn-outline-primary" target="_blank">
                                        <i class="far fa-file-alt"></i>
                                    </a>
                                @endif
                                <a wire:navigate href="{{ route('user.orders.view', $order->code) }}" class="btn btn-sm btn-main">
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
        @if ($orders->hasPages())
            <div class="mb-3">
                <div>
                    {{ $orders->links('partials.pagination') }}
                </div>
            </div>
        @endif
    </div>
</div>
