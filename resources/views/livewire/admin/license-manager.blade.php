@section('title', $metaTitle)
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">License</h1>
            <p class="text-muted small">Manage customer license</p>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="card common-card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-sm-6 col-md-4 col-lg-6">
                    <label for="search" class="form-label">Search</label>
                    <input wire:model.live.debounce.300ms="searchTerm" type="search" id="search"
                        class="common-input border" placeholder="Search by order code, customer name or email">
                </div>

                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="licenseTypeFilter" class="form-label">License Type</label>
                    <div class="select-has-icon">
                        <select wire:model.live="licenseTypeFilter" id="licenseTypeFilter" class="common-input border">
                            <option value="">All License Types</option>
                            <option value="regular">Regular</option>
                            <option value="extended">Extended</option>
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

    {{-- Order Items Table --}}
    <div class="card common-card">
        <div class="card-body table-responsive">
            <table class="table style-two">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Details</th>
                        <th>License</th>
                        <th>Support End</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orderItems as $orderItem)
                        <tr>
                            <td>
                                <a href="{{ route('admin.orders.show', $orderItem->order?->id) }}"
                                    class="fw-bold">{{ $orderItem->order?->code }}</a>
                            </td>
                            <td>
                                <a href="{{ route('admin.users.show', $orderItem->order?->user_id) }}"
                                    class="fw-bold">{{ $orderItem->order?->user?->name }}</a>
                                <p class="text-muted mb-0">{{ $orderItem->order?->user?->email }}</p>
                            </td>
                            <td>{{ $orderItem->order->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <p class="mb-0">Quant: {{ $orderItem->quantity }}</p>
                                <p class="mb-0"> {{ format_price($orderItem->total) }}</p>
                            </td>
                            <td>
                                <p class="mb-0">{{ $orderItem->license_type }}</p>
                                <small>{{ $orderItem->license_code }}</small>
                            </td>
                            <td>
                                @if ($orderItem->support_end_date)
                                    {{ show_date($orderItem->support_end_date) }}
                                @else
                                    Not specified
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-2">
                                    <button wire:click="viewOrderItem('{{ $orderItem->id }}')"
                                        class="btn btn-sm btn-outline-main">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <button wire:click="confirmDelete('{{ $orderItem->id }}')"
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
        @if ($orderItems->hasPages())
            <div class="card-footer">
                <div>
                    {{ $orderItems->links('livewire::bootstrap') }}
                </div>
            </div>
        @endif
    </div>


    <!-- Order View Modal -->
    @if ($viewingOrderItem)
        <div class="common-modal modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);"
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header pt-0">
                        <h5 class="modal-title">Edit License</h5>
                        <button type="button" wire:click="closeViewOrderItem" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card common-card mb-3">
                                    <div class="card-header">
                                        <h6 class="mb-0">Customer Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Name:</strong> {{ $viewingOrderItem->order->name }}</p>
                                        <p><strong>Email:</strong> {{ $viewingOrderItem->order->email }}</p>
                                        <p><strong>Customer ID:</strong>
                                            {{ $viewingOrderItem->order->user_id ?? 'Guest' }}</p>
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
                                            {{ show_date($viewingOrderItem->order->created_at, 'M d, Y H:i') }}</p>
                                        <p><strong>Payment Method:</strong>
                                            {{ $paymentMethods[$viewingOrderItem->order->payment_method] ?? $viewingOrderItem->order->payment_method }}
                                        </p>
                                        <p><strong>Payment Status:</strong> <span
                                                class="badge {{ $viewingOrderItem->order->payment_status === 'completed' ? 'bg-success' : ($viewingOrderItem->order->payment_status === 'failed' ? 'bg-danger' : 'bg-warning') }}">{{ ucfirst($viewingOrderItem->order->payment_status) }}</span>
                                        </p>
                                        <p><strong>Order Status:</strong> <span
                                                class="badge {{ $viewingOrderItem->order->order_status === 'completed' ? 'bg-success' : ($viewingOrderItem->order->order_status === 'failed' ? 'bg-danger' : 'bg-warning') }}">{{ ucfirst($viewingOrderItem->order->order_status) }}</span>
                                        </p>

                                        @if ($viewingOrderItem->order->payment_date)
                                            <p><strong>Payment Date:</strong>
                                                {{ show_date($viewingOrderItem->order->payment_date, 'M d, Y H:i') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card common-card">
                            <div class="card-header d-flex justify-content-between">
                                <h6 class="mb-0">Edit License</h6>
                                @if (!$editingLicense)
                                    <button wire:click="enableEditLicense" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-pencil"></i> Edit License
                                    </button>
                                @endif
                            </div>
                            <div class="card-body">
                                @if ($editingLicense)
                                    <div class="form-group">
                                        <input wire:model="licenseCode" class="common-input border w-100"
                                            type="text">
                                    </div>
                                    <div class="form-group">
                                        <input wire:model="supportEndDate" class="common-input border w-100"
                                            type="text">
                                    </div>
                                    <div class="mt-2 text-end">
                                        <button wire:click="$set('editingLicense', false)"
                                            class="btn btn-sm btn-outline-secondary">
                                            Cancel
                                        </button>
                                        <button wire:click="saveLicense" class="btn btn-sm btn-main ms-2">
                                            Save License
                                        </button>
                                    </div>
                                @else
                                    <p class="mb-0">{{ $licenseCode ?: 'No license code' }}</p>
                                    <p class="mb-0">
                                        {{ $supportEndDate ?: 'No support end date' }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="closeViewOrderItem"
                            class="btn btn-secondary">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
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
                        <p>Are you sure you want to delete this order Item?</p>
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
