@section('title', 'Manage Coupons')

<div class="container-fluid py-4">
    @if ($view === 'list')
        {{-- List View Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Coupons</h1>
                <p class="text-muted small">Manage your discount coupons</p>
            </div>
            <div>
                <button wire:click="create" class="btn btn-main">
                    <i class="fa fa-plus-circle me-1"></i> Add New Coupon
                </button>
            </div>
        </div>

        {{-- Search and Filters --}}
        <div class="card common-card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input wire:model.live.debounce.300ms="searchTerm" type="search" class="common-input border"
                                placeholder="Search coupons by code">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch">
                            <input wire:model.live="showExpired" class="form-check-input" type="checkbox" id="show-expired">
                            <label class="form-check-label" for="show-expired">Show Expired</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <label for="per-page" class="me-2 form-label mb-0">Show</label>
                            <div class="select-has-icon">
                                <select wire:model.live="perPage" id="per-page" class="common-input border">
                                    @foreach ([10, 25, 50, 100] as $value)
                                        <option value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Coupons Table --}}
        <div class="card common-card">
            <div class="card-body table-responsive">
                <table class="table style-two">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Discount</th>
                            <th>Type</th>
                            <th>Usage</th>
                            <th>Expiry</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($coupons as $coupon)
                            <tr>
                                <td>
                                    <span class="fw-bold">{{ $coupon->code }}</span>
                                </td>
                                <td>
                                    @if ($coupon->discount_type->value === 'percent')
                                        {{ $coupon->discount }}%
                                    @else
                                        {{ number_format($coupon->discount, 2) }}
                                    @endif
                                </td>
                                <td>
                                    @switch($coupon->type->value)
                                        @case('general')
                                            <span class="badge bg-info">General</span>
                                        @break

                                        @case('product')
                                            <span class="badge bg-primary">Product: {{ $coupon->product?->name ?? 'N/A' }}</span>
                                        @break

                                        @case('category')
                                            <span class="badge bg-warning">Category: {{ $coupon->category?->name ?? 'N/A' }}</span>
                                        @break
                                    @endswitch
                                </td>
                                <td>
                                    {{ $coupon->limit ? "{$coupon->limit} " : 'Unlimited' }}
                                </td>
                                <td>
                                    @if ($coupon->expires_at)
                                        <span class="{{ $coupon->expires_at->isPast() ? 'text-danger' : '' }}">
                                            {{ $coupon->expires_at->format('M d, Y') }}
                                        </span>
                                    @else
                                        No expiry
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $coupon->active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $coupon->active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <button wire:click="edit('{{ $coupon->id }}')" class="btn btn-sm btn-outline-main">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button wire:click="confirmDelete('{{ $coupon->id }}')" class="btn btn-sm btn-outline-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        No coupons found. Create your first coupon!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($coupons->hasPages())
                    <div class="card-footer">
                        {{ $coupons->links('livewire::bootstrap') }}
                    </div>
                @endif
            </div>
        @else
            {{-- Form View Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">{{ $view === 'create' ? 'Create Coupon' : 'Edit Coupon' }}</h1>
                    <p class="text-muted mb-0">
                        {{ $view === 'create' ? 'Create a new discount coupon' : 'Update coupon details' }}
                    </p>
                </div>
                <div>
                    <button wire:click="backToList" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </button>
                </div>
            </div>

            {{-- Coupon Form --}}
            @include('partials.coupon.form', [
                'view' => $view,
                'discountTypes' => $discountTypes,
                'couponTypes' => $couponTypes,
                'products' => $products,
                'categories' => $categories,
            ])
        @endif

        {{-- delete modal --}}
        @if ($showDeleteModal)
            <div class="common-modal modal fade show" tabindex="-1" id="deleteModal" role="dialog" aria-labelledby="deleteModalTitle"
                aria-modal="true" style="display:block;background-color: rgba(0, 0, 0, 0.5);">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalTitle">Confirm Delete</h5>
                            <button type="button" class="btn-close" wire:click="$set('showDeleteModal', false)"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this coupon?</p>
                            <p class="text-danger">This action cannot be undone and will permanently remove the coupon from your store.
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="$set('showDeleteModal', false)">Cancel</button>
                            <button type="button" class="btn btn-danger" wire:click="deleteCoupon('{{ $deleteId }}')">
                                <i class="fas fa-trash me-1"></i> Delete Coupon
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @include('layouts.meta')
