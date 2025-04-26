<div class="card common-card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">{{ $view === 'edit' ? 'Edit Coupon Details' : 'Enter Coupon Details' }}</h5>
    </div>
    <div class="card-body">
        <form wire:submit="save">
            <div class="row g-3">
                {{-- Coupon Code --}}
                <div class="col-md-6">
                    <label for="code" class="form-label">Coupon Code</label>
                    <input type="text" wire:model="code" id="code" class="common-input border @error('code') is-invalid @enderror"
                        placeholder="SUMMER2025">
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Discount Value --}}
                <div class="col-md-3">
                    <label for="discount" class="form-label">Discount Value</label>
                    <input type="number" wire:model="discount" id="discount" step="0.01"
                        class="common-input border @error('discount') is-invalid @enderror">
                    @error('discount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Discount Type --}}
                <div class="col-md-3">
                    <label for="discount_type" class="form-label">Discount Type</label>
                    <div class="select-has-icon">
                        <select wire:model="discount_type" id="discount_type"
                            class="common-input border @error('discount_type') is-invalid @enderror">
                            @foreach ($discountTypes as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('discount_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Coupon Type --}}
                <div class="col-md-6">
                    <label for="type" class="form-label">Coupon Type</label>
                    <div class="select-has-icon">
                        <select wire:model.live="type" id="type" class="common-input border @error('type') is-invalid @enderror">
                            @foreach ($couponTypes as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Product Selection (conditionally displayed) --}}
                @if ($type === 'product')
                    <div class="col-md-6">
                        <label for="product_id" class="form-label">Apply to Product</label>
                        <div class="select-has-icon">
                            <select wire:model="product_id" id="product_id"
                                class="common-input border @error('product_id') is-invalid @enderror">
                                <option value="">Select a product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endif

                {{-- Category Selection (conditionally displayed) --}}
                @if ($type === 'category')
                    <div class="col-md-6">
                        <label for="category_id" class="form-label">Apply to Category</label>
                        <div class="select-has-icon">
                            <select wire:model="category_id" id="category_id"
                                class="common-input border @error('category_id') is-invalid @enderror">
                                <option value="">Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endif

                {{-- Usage Limit --}}
                <div class="col-md-6">
                    <label for="limit" class="form-label">Usage Limit</label>
                    <input type="number" wire:model="limit" id="limit" class="common-input border @error('limit') is-invalid @enderror"
                        placeholder="Leave blank for unlimited">
                    @error('limit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Expiration Date --}}
                <div class="col-md-6">
                    <label for="expires_at" class="form-label">Expiration Date</label>
                    <input type="date" wire:model="expires_at" id="expires_at"
                        class="common-input border @error('expires_at') is-invalid @enderror">
                    @error('expires_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status Switch --}}
                <div class="col-12">
                    <x-jdv-switch label="Status" model="active" />
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="d-flex justify-content-end gap-2 mt-4">
                <button type="submit" class="btn btn-main">
                    {{ $view === 'edit' ? 'Update Coupon' : 'Create Coupon' }}
                </button>
            </div>
        </form>
    </div>
</div>
