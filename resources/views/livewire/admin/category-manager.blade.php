@section('title', 'Manage Category')

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Categories</h1>
            <p class="text-muted small">Manage your product categories</p>
        </div>
        <div>
            <button wire:click="create" class="btn btn-main">
                <i class="fa fa-plus-circle me-1"></i> Add New Category
            </button>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="card common-card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <input wire:model.live.debounce.300ms="searchTerm" type="search" class="common-input border"
                            placeholder="Search categories">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check form-switch">
                        <input wire:model.live="showInactive" class="form-check-input" type="checkbox" id="show-inactive">
                        <label class="form-check-label" for="show-inactive">Show Inactive</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flexs align-items-center">
                        <label for="per-page" class="me-2 form-label mb-0">Show</label>
                        <div class="select-has-icon">

                            <select wire:model.live="perPage" id="per-page" class="common-input border">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Create/Edit Form -->
    @if ($isCreating)
        <div class="card common-card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between">
                <h5 class="card-title mb-0">{{ $editingCategoryId ? 'Edit Category' : 'Create New Category' }}</h5>
                <button type="button" wire:click="cancelEdit" class="btn btn-sm close">
                    <i class="fa fa-close"></i>
                </button>
            </div>
            <div class="card-body">
                <form wire:submit="save" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" wire:model="name" id="name"
                                class="common-input border @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" wire:model="slug" id="slug"
                                class="common-input border @error('slug') is-invalid @enderror">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea wire:model="description" id="description" rows="3" class="common-input border @error('description') is-invalid @enderror"></textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="icon" class="form-label">Icon (CSS class or SVG)</label>
                            <input type="text" wire:model="icon" id="icon"
                                class="common-input border @error('icon') is-invalid @enderror">
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" wire:model="image" id="image"
                                class="common-input border @error('image') is-invalid @enderror">
                            <div wire:loading wire:target="image" class="text-muted mt-1 small">Uploading...</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if ($editingCategoryId && !$image)
                                @php
                                    $category = \App\Models\Category::find($editingCategoryId);
                                @endphp
                                @if ($category && $category->image)
                                    <div class="mt-2">
                                        <p class="text-muted small">Current image:</p>
                                        <img src="{{ my_asset($category->image) }}" alt="{{ $category->name }}" class="img-thumbnail"
                                            style="max-height: 100px">
                                    </div>
                                @endif
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label for="parentId" class="form-label">Parent Category</label>
                            <div class="select-has-icon">
                                <select wire:model="parentId" id="parentId"
                                    class="common-input border @error('parentId') is-invalid @enderror">
                                    <option value="">None (Top Level)</option>
                                    @foreach ($parentCategories as $parentCategory)
                                        @if (!$editingCategoryId || $parentCategory->id !== $editingCategoryId)
                                            <option value="{{ $parentCategory->id }}">{{ $parentCategory->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('parentId')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="order" class="form-label">Order</label>
                            <input type="number" wire:model="sortOrder" id="order"
                                class="common-input border @error('sortOrder') is-invalid @enderror">
                            @error('sortOrder')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="metaTitle" class="form-label">Meta Title</label>
                            <input type="text" wire:model="metaTitle" id="metaTitle"
                                class="common-input border @error('metaTitle') is-invalid @enderror">
                            @error('metaTitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="metaDescription" class="form-label">Meta Description</label>
                            <input type="text" wire:model="metaDescription" id="metaDescription"
                                class="common-input border @error('metaDescription') is-invalid @enderror">
                            @error('metaDescription')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input wire:model="isActive" id="isActive" type="checkbox" class="form-check-input">
                                <label for="isActive" class="form-check-label">Active</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" wire:click="cancelEdit" class="btn btn-outline-secondary">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-main">
                            {{ $editingCategoryId ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Categories Table -->
    <div class="card common-card">
        <div class="card-body table-responsive">
            <table class="table style-two">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Parent</th>
                        <th>Products</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if ($category->icon)
                                        <span class="me-2 border border-main rounded p-2 py-1">{!! $category->icon !!}</span>
                                    @endif
                                    <span>{{ $category->name }}</span>
                                </div>
                            </td>
                            <td> <img src="{{ my_asset($category->image) }}" style="width: 50px" alt=""> </td>
                            <td>{{ $category->parent ? $category->parent->name : '-' }}</td>
                            {{-- <td>{{ $category->children_count }}</td> --}}
                            <td>{{ $category->products_count }}</td>
                            <td>
                                <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <button wire:click="edit('{{ $category->id }}')" class="btn btn-sm btn-outline-main">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button wire:click="confirmDelete('{{ $category->id }}')" class="btn btn-sm btn-outline-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                No categories found. Create your first category!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($categories->hasPages())
            <div class="card-footer">
                <div>
                    {{ $categories->links('livewire::bootstrap') }}
                </div>
            </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal -->
    @if ($confirmingCategoryDeletion)
        <div class="common-modal modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1"
            aria-labelledby="deleteModalLabel" aria-modal="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Delete Category</h5>
                        <button type="button" class="btn-close" wire:click="cancelDelete" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this category? This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="cancelDelete">Cancel</button>
                        <button type="button" class="btn btn-danger" wire:click="deleteCategory">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
