@section('title', 'Manage Orders')

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Orders</h1>
            <p class="text-muted small">Manage customer orders and payments</p>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="card common-card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4 col-lg-3">
                    <label for="search" class="form-label">Search</label>
                    <input wire:model.live.debounce.300ms="searchTerm" type="search" id="search"
                        class="common-input border" placeholder="Search by order code, customer name or email">
                </div>

                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="statusFilter" class="form-label">Order Status</label>
                    <div class="select-has-icon">
                        <select wire:model.live="statusFilter" id="statusFilter" class="common-input border">
                            <option value="">All Statuses</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="paymentStatusFilter" class="form-label">Payment Status</label>
                    <div class="select-has-icon">
                        <select wire:model.live="paymentStatusFilter" id="paymentStatusFilter"
                            class="common-input border">
                            <option value="">All Statuses</option>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="paymentGatewayFilter" class="form-label">Payment Gateway</label>
                    <div class="select-has-icon">
                        <select wire:model.live="paymentGatewayFilter" id="paymentGatewayFilter"
                            class="common-input border">
                            <option value="">All Gateways</option>
                            <option value="paypal_payment">Paypal</option>
                            <option value="paystack_payment">Paystack</option>
                            <option value="flutterwave_payment">Flutterwave</option>
                            <option value="cryptomus_payment">Cryptomus</option>
                            <option value="manual_payment">Bank Transfer</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="dateFrom" class="form-label">Date From</label>
                    <input wire:model.live="dateFrom" type="date" id="dateFrom" class="common-input border">
                </div>

                <div class="col-sm-6 col-md-4 col-lg-3" hidden>
                    <label for="dateTo" class="form-label">Date To</label>
                    <input wire:model.live="dateTo" type="date" id="dateTo" class="common-input border">
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

    <!-- Orders Table -->
    <div class="card common-card">
        <div class="card-body table-responsive">
            <table class="table style-two">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Payment Status</th>
                        <th>Order Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>
                                <span class="fw-bold">{{ $order->code }}</span>
                            </td>
                            <td>
                                @if ($order->user_id)
                                    <a href="{{ route('admin.users.show', $order->user_id) }}"
                                        class="fw-bold">{{ $order->name }}</a>
                                @else
                                    <div>{{ $order->name }}</div>
                                @endif
                                <p class="text-muted mb-0">{{ $order->email }}</p>
                            </td>
                            <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <div class="fw-bold">{{ format_price($order->total) }}</div>
                                @if ($order->discount > 0)
                                    <small class="text-warning">-{{ format_price($order->discount) }}</small>
                                @endif
                            </td>
                            <td>
                                @php
                                    $paymentMethodLabels = [
                                        'paystack_payment' => 'Paystack',
                                        'flutterwave_payment' => 'Flutterwave',
                                        'paypal_payment' => 'PayPal',
                                        'cryptomus_payment' => 'Cryptomus',
                                        'manual_payment' => 'Bank Transfer',
                                    ];
                                    $paymentMethodLabel =
                                        $paymentMethods[$order->payment_method] ?? $order->payment_method;
                                @endphp
                                {{ $paymentMethodLabel }}
                            </td>
                            <td>
                                @php
                                    $paymentStatusClass =
                                        [
                                            'pending' => 'bg-warning',
                                            'completed' => 'bg-success',
                                            'failed' => 'bg-danger',
                                        ][$order->payment_status] ?? 'bg-secondary';
                                @endphp
                                <span
                                    class="badge {{ $paymentStatusClass }}">{{ ucfirst($order->payment_status) }}</span>

                                @if ($order->payment_method == 'manual_payment' && $order->payment_status == 'pending' && $order->payment_receipt)
                                    <a href="#" wire:click.prevent="verifyManualPayment('{{ $order->id }}')"
                                        class="ms-1 badge bg-info">Verify</a>
                                @endif
                            </td>
                            <td>
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
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-2">
                                    <button wire:click="viewOrder('{{ $order->id }}')"
                                        class="btn btn-sm btn-outline-main">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <button wire:click="prepareStatusUpdate('{{ $order->id }}')"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button wire:click="confirmDelete('{{ $order->id }}')"
                                        class="btn btn-sm btn-outline-danger">
                                        <i class="la la-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                No orders found matching your criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($orders->hasPages())
            <div class="card-footer">
                <div>
                    {{ $orders->links('livewire::bootstrap') }}
                </div>
            </div>
        @endif
    </div>

    <!-- Order View Modal -->
    @if ($viewingOrder)
        <div class="common-modal modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);"
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header pt-0">
                        <h5 class="modal-title">Order #{{ $viewingOrder->code }}</h5>
                        <button type="button" wire:click="closeViewOrder" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card common-card mb-3">
                                    <div class="card-header">
                                        <h6 class="mb-0">Customer Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Name:</strong> {{ $viewingOrder->name }}</p>
                                        <p><strong>Email:</strong> {{ $viewingOrder->email }}</p>
                                        <p><strong>Customer ID:</strong> {{ $viewingOrder->user_id ?? 'Guest' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card common-card mb-3">
                                    <div class="card-header">
                                        <h6 class="mb-0">Order Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Date:</strong>
                                            {{ show_date($viewingOrder->created_at, 'M d, Y H:i') }}</p>
                                        <p><strong>Payment Method:</strong>
                                            {{ $paymentMethods[$viewingOrder->payment_method] ?? $viewingOrder->payment_method }}
                                        </p>
                                        <p><strong>Payment Status:</strong> <span
                                                class="badge {{ $viewingOrder->payment_status === 'completed' ? 'bg-success' : ($viewingOrder->payment_status === 'failed' ? 'bg-danger' : 'bg-warning') }}">{{ ucfirst($viewingOrder->payment_status) }}</span>
                                        </p>
                                        <p><strong>Order Status:</strong> <span
                                                class="badge {{ $viewingOrder->order_status === 'completed' ? 'bg-success' : ($viewingOrder->order_status === 'failed' ? 'bg-danger' : 'bg-warning') }}">{{ ucfirst($viewingOrder->order_status) }}</span>
                                        </p>

                                        @if ($viewingOrder->payment_date)
                                            <p><strong>Payment Date:</strong>
                                                {{ show_date($viewingOrder->payment_date, 'M d, Y H:i') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card common-card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Order Items</h6>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table style-two">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>License</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Support</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($viewingOrder->items as $item)
                                            <tr>
                                                <td>
                                                    <div>
                                                        {{ $item->product->name ?? 'Product ID: ' . $item->product_id }}
                                                    </div>
                                                </td>
                                                <td>{{ ucfirst($item->license_type) }}</td>
                                                <td>{{ format_price($item->price) }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>
                                                    @if ($item->extended_support)
                                                        Extended (+{{ format_price($item->support_price) }})
                                                    @else
                                                        Standard
                                                    @endif
                                                </td>
                                                <td class="text-end">{{ format_price($item->total) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5" class="text-end py-1">Subtotal:</th>
                                            <th class="text-end py-1">{{ format_price($viewingOrder->subtotal) }}</th>
                                        </tr>
                                        @if ($viewingOrder->discount > 0)
                                            <tr>
                                                <th colspan="5" class="text-end text-success py-1">Discount:</th>
                                                <th class="text-end text-success py-1">
                                                    -{{ format_price($viewingOrder->discount) }}
                                                </th>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th colspan="5" class="text-end py-1">Total:</th>
                                            <th class="text-end fw-bold py-1">{{ format_price($viewingOrder->total) }}
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        @if ($viewingOrder->payment_method == 'manual_payment' && $viewingOrder->payment_receipt)
                            <div class="card common-card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Payment Receipt</h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>Bank Reference:</strong> {{ $viewingOrder->bank_reference }}</p>
                                    <div class="mt-2">
                                        <img src="{{ my_asset($viewingOrder->payment_receipt) }}" alt="Receipt"
                                            class="img-fluid mb-2" style="max-width: 300px;">
                                        <br>
                                        <a href="{{ my_asset($viewingOrder->payment_receipt) }}" target="_blank"
                                            class="btn btn-sm btn-outline-success">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <area shape="" coords="" href="" alt="">
                                        @if ($viewingOrder->payment_status !== 'completed')
                                            <button wire:click="verifyManualPayment('{{ $viewingOrder->id }}')"
                                                class="btn btn-sm btn-success ms-2">
                                                Verify Payment
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="card common-card">
                            <div class="card-header d-flex justify-content-between">
                                <h6 class="mb-0">Order Notes</h6>
                                @if (!$editingNotes)
                                    <button wire:click="enableEditNotes" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-pencil"></i> Edit Notes
                                    </button>
                                @endif
                            </div>
                            <div class="card-body">
                                @if ($editingNotes)
                                    <div class="form-group">
                                        <textarea wire:model="orderNotes" class="common-input border w-100" rows="3"></textarea>
                                    </div>
                                    <div class="mt-2 text-end">
                                        <button wire:click="$set('editingNotes', false)"
                                            class="btn btn-sm btn-outline-secondary">
                                            Cancel
                                        </button>
                                        <button wire:click="saveNotes" class="btn btn-sm btn-main ms-2">
                                            Save Notes
                                        </button>
                                    </div>
                                @else
                                    <p class="mb-0">{{ $viewingOrder->notes ?: 'No notes' }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="closeViewOrder" class="btn btn-secondary">Close</button>
                        <button type="button" wire:click="prepareStatusUpdate('{{ $viewingOrder->id }}')"
                            class="btn btn-main">Update
                            Status</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Status Update Modal -->
    @if ($updatingOrderId)
        <div class="common-modal modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);"
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Order Status</h5>
                        <button type="button" wire:click="cancelStatusUpdate" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="newOrderStatus" class="form-label">Order Status</label>
                            <div class="select-has-icon">
                                <select wire:model="newOrderStatus" id="newOrderStatus" class="common-input border">
                                    <option value="pending">Pending</option>
                                    <option value="processing">Processing</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="failed">Failed</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="newPaymentStatus" class="form-label">Payment Status</label>
                            <div class="select-has-icon">
                                <select wire:model="newPaymentStatus" id="newPaymentStatus"
                                    class="common-input border">
                                    <option value="pending">Pending</option>
                                    <option value="completed">Completed</option>
                                    <option value="failed">Failed</option>
                                </select>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <div class="fw-semibold">Important:</div>
                            <ul class="mb-0 ms-3">
                                <li>Setting payment status to "Completed" will process the order completely.</li>
                                <li>Setting payment status to "Failed" will mark the order as failed.</li>
                                <li>These actions cannot be easily undone.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="cancelStatusUpdate"
                            class="btn btn-outline-secondary">Cancel</button>
                        <button type="button" wire:click="updateStatus" class="btn btn-primary">Update
                            Status</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- delete modal --}}
    @if ($showDeleteModal)
        <div class="common-modal modal fade show" tabindex="-1" id="deleteModal" aria-hidden="true"
            style="display:block;background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Delete</h5>
                        <button type="button" class="btn-close"
                            wire:click="$set('showDeleteModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this order?</p>
                        <p class="text-danger">This action cannot be undone and will permanently remove the order from
                            your store.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            wire:click="$set('showDeleteModal', false)">Cancel</button>
                        <button type="button" class="btn btn-danger"
                            wire:click="deleteOrder('{{ $deleteId }}')">
                            <i class="fas fa-trash me-1"></i> Delete Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@include('layouts.meta')
