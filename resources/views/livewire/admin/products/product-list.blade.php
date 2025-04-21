@section('title', $pageTitle)

<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Products</h1>
            <p class="text-muted small">Manage product inventory</p>
        </div>
        <div>
            <a href="{{ route('admin.products.create') }}" wire:navigate class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add New Product
            </a>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="common-card card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4 col-lg-3">
                    <label for="search" class="form-label">Search</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="common-input border form-control" wire:model.live.debounce.300ms="search"
                            placeholder="Search products...">
                    </div>
                </div>

                <div class="col-md-4 col-lg-2">
                    <label for="categoryFilter" class="form-label">Category</label>
                    <select class="common-input form-select" wire:model.live="categoryFilter" id="categoryFilter">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-4 col-lg-2">
                    <label for="statusFilter" class="form-label">Status</label>
                    <select class="common-input form-select" wire:model.live="statusFilter" id="statusFilter">
                        <option value="">All Statuses</option>
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>


                <div class="col-6 col-md-4 col-lg-2">
                    <label for="typeFilter" class="form-label">Type</label>
                    <select class="common-input form-select" wire:model.live="typeFilter" id="typeFilter">
                        <option value="">All Types</option>
                        @foreach ($productTypes as $type)
                            <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-sm-6 col-md-4 col-lg-2">
                    <label for="featuredFilter" class="form-label">Featured</label>
                    <select class="common-input form-select" wire:model.live="featuredFilter" id="featuredFilter">
                        <option value="">All Products</option>
                        <option value="1">Featured Only</option>
                        <option value="0">Non-Featured Only</option>
                    </select>
                </div>

                <div class="col-6 col-sm-6 col-md-4 col-lg-1">
                    <label for="perPage" class="form-label">Show</label>
                    <select class="common-input form-select" wire:model.live="perPage" id="perPage">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Actions -->
    @if (count($selectedProducts) > 0)
        <div class="common-card card mb-4 bg-light">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="me-2">{{ count($selectedProducts) }} products selected</span>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-success" wire:click="bulkPublish"
                            wire:confirm="Are you sure you want to publish {{ count($selectedProducts) }} products?">
                            <i class="fas fa-check-circle me-1"></i> Publish
                        </button>
                        <button type="button" class="btn btn-outline-secondary" wire:click="bulkArchive"
                            wire:confirm="Are you sure you want to archive {{ count($selectedProducts) }} products?">
                            <i class="fas fa-archive me-1"></i> Archive
                        </button>
                        <button type="button" class="btn btn-outline-secondary" wire:click="bulkFeature"
                            wire:confirm="Are you sure you want to Feature {{ count($selectedProducts) }} products?">
                            <i class="fas fa-check-circle text-success me-1"></i> Featured
                        </button>
                        <button type="button" class="btn btn-outline-danger" wire:click="bulkDelete"
                            wire:confirm="Are you sure you want to delete {{ count($selectedProducts) }} products? This cannot be undone.">
                            <i class="fas fa-trash me-1"></i> Delete
                        </button>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-link text-danger" wire:click="$set('selectedProducts', [])">
                    Clear Selection
                </button>
            </div>
        </div>
    @endif

    <!-- Products Table -->
    <div class="common-card card mb-4">
        <div class="table-responsive">
            <table class="table style-two ">
                <thead>
                    <tr>
                        <th class="col-auto">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model.live="selectAll" id="selectAll">
                            </div>
                        </th>
                        <th>Image</th>
                        <th>
                            <a href="#" wire:click.prevent="sortBy('name')" class="d-flex align-items-center">
                                Product
                                @if ($sortField === 'name')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </a>
                        </th>
                        <th class="col-auto">Category</th>
                        <th class="col-auto">
                            <a href="#" wire:click.prevent="sortBy('regular_price')" class="d-flex align-items-center">
                                Price
                                @if ($sortField === 'regular_price')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </a>
                        </th>
                        <th class="col-auto">
                            <a href="#" wire:click.prevent="sortBy('sales_count')" class="d-flex align-items-center">
                                Sales
                                @if ($sortField === 'sales_count')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </a>
                        </th>
                        <th class="col-auto">
                            <a href="#" wire:click.prevent="sortBy('status')" class="d-flex align-items-center">
                                Status
                                @if ($sortField === 'status')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </a>
                        </th>
                        <th class="col-auto">
                            <a href="#" wire:click.prevent="sortBy('created_at')" class="d-flex align-items-center">
                                Date
                                @if ($sortField === 'created_at')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </a>
                        </th>
                        <th class="">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" wire:model.live="selectedProducts"
                                        value="{{ $product->id }}" id="product-{{ $product->id }}">
                                </div>
                            </td>
                            <td>
                                @if ($product->thumbnail)
                                    <img src="{{ my_asset($product->thumbnail) }}" class="img-thumbnail"
                                        style="width: 60px; height: 60px; object-fit: cover;" alt="{{ $product->name }}">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center mx-auto"
                                        style="width: 60px; height: 60px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $product->name }}</strong>
                                @if ($product->featured)
                                    <i class="fa fa-check-circle text-success"></i>
                                @endif
                            </td>
                            <td>{{ $product->category->name ?? 'Nil' }}
                            </td>
                            <td>
                                @if ($product->is_free)
                                    <span class="badge bg-success">Free</span>
                                @else
                                    {{ format_price($product->regular_price) }}
                                    @if ($product->discount > 0)
                                        <br>
                                        <span class="badge bg-danger ms-1">-{{ $product->discount }}%</span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                <span class="badge rounded-pill bg-primary">{{ $product->sales_count }}</span>
                            </td>
                            <td>
                                @if ($product->status === 'published')
                                    <span class="badge bg-success">Published</span>
                                @elseif($product->status === 'draft')
                                    <span class="badge bg-warning text-dark">Draft</span>
                                @else
                                    <span class="badge bg-secondary">Archived</span>
                                @endif
                            </td>
                            <td>
                                <div class="small">
                                    <div>{{ show_date($product->created_at, 'M d, Y') }}</div>
                                    @if ($product->publish_date)
                                        <div> {{show_date($product->publish_date) }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end">
                                    <a href="{{ route('admin.products.edit', $product) }}" wire:navigate
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('products.view', $product->slug) }}" wire:navigate
                                        class="btn btn-outline-info btn-sm" target="_blank">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                        wire:click="confirmDelete('{{ $product->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                    <h5>No products found</h5>
                                    <p class="text-muted">Try adjusting your search or filter to find what you're looking for.</p>
                                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm mt-2">
                                        <i class="fas fa-plus me-1"></i> Add New Product
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mb-4">
        {{ $products->links() }}
    </div>

    <!-- Delete Modal -->
    @if ($showDeleteModal)
        <div class="common-modal modal fade show" tabindex="-1" id="deleteModal" aria-hidden="true"
            style="display:block;background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Delete</h5>
                        <button type="button" class="btn-close" wire:click="$set('showDeleteModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        @if ($productToDelete)
                            <p>Are you sure you want to delete <strong>{{ $productToDelete->name }}</strong>?</p>
                            <p class="text-danger">This action cannot be undone and will permanently remove the product from your store.
                            </p>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showDeleteModal', false)">Cancel</button>
                        <button type="button" class="btn btn-danger" wire:click="deleteProduct">
                            <i class="fas fa-trash me-1"></i> Delete Product
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@include('layouts.meta')
