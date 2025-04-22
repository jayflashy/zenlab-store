@section('title', $pageTitle)
<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ $formMode === 'edit' ? 'Edit Product' : 'Create Product' }}</h1>
            <p class="text-muted small">{{ $formMode === 'edit' ? 'Update product information' : 'Add a new product to your store' }}</p>
        </div>
        <div>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Products
            </a>
        </div>
    </div>

    <form wire:submit.prevent="save">
        <!-- Tab Navigation -->
        <div class="common-card card mb-4">
            <div class="card-body p-2">
                <ul class="nav nav-pills nav-fill">
                    <li class="nav-item">
                        <button type="button" class="nav-link {{ $activeTab === 'basic' ? 'active' : '' }}"
                            wire:click="setActiveTab('basic')">
                            <i class="fas fa-info-circle me-1"></i> Basic Info
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link {{ $activeTab === 'pricing' ? 'active' : '' }}"
                            wire:click="setActiveTab('pricing')">
                            <i class="fas fa-tag me-1"></i> Pricing
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link {{ $activeTab === 'media' ? 'active' : '' }}"
                            wire:click="setActiveTab('media')">
                            <i class="fas fa-images me-1"></i> Media
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link {{ $activeTab === 'content' ? 'active' : '' }}"
                            wire:click="setActiveTab('content')">
                            <i class="fas fa-file-alt me-1"></i> Content
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link {{ $activeTab === 'attributes' ? 'active' : '' }}"
                            wire:click="setActiveTab('attributes')">
                            <i class="fas fa-list-ul me-1"></i> Attributes
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link {{ $activeTab === 'download' ? 'active' : '' }}"
                            wire:click="setActiveTab('download')">
                            <i class="fas fa-download me-1"></i> Download
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Basic Info Tab -->
        <div class="common-card card mb-4 {{ $activeTab === 'basic' ? '' : 'd-none' }}">
            <div class="card-header">
                <h5 class="mb-0">Basic Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" class="common-input form-control @error('name') is-invalid @enderror"
                                wire:model.live.debounce.1000ms="name" id="name" placeholder="Enter product name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                            <input type="text" class="common-input form-control @error('slug') is-invalid @enderror" wire:model="slug"
                                id="slug" placeholder="product-slug">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="common-input form-select @error('category_id') is-invalid @enderror" wire:model="category_id"
                                id="category_id">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="common-input form-select @error('status') is-invalid @enderror" wire:model="status"
                                id="status">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="archived">Archived</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="publish_date" class="form-label">Publish Date</label>
                            <input type="text" class="common-input form-control @error('publish_date') is-invalid @enderror"
                                wire:model="publish_date" id="publish_date">
                            @error('publish_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <x-jdv-switch label="Featured Product" model="featured" />
                    </div>
                </div>

                <x-rich-text model="short_description" height="100px" />
            </div>
        </div>

        <!-- Pricing Tab -->
        <div class="common-card card mb-4 {{ $activeTab === 'pricing' ? '' : 'd-none' }}">
            <div class="card-header">
                <h5 class="mb-0">Pricing Information</h5>
            </div>
            <div class="card-body">

                <x-jdv-switch label="Free Product" model="is_free" live='true' />

                <div class="row" @if ($is_free) style="opacity: 0.5;" @endif>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="regular_price" class="form-label">Regular License Price</label>
                            <div class="input-group">
                                <span class="input-group-text">{{ $settings->currency }}</span>
                                <input type="number" step="0.01"
                                    class="common-input form-control @error('regular_price') is-invalid @enderror"
                                    wire:model="regular_price" id="regular_price" placeholder="0.00"
                                    @if ($is_free) disabled @endif>
                            </div>
                            @error('regular_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="extended_price" class="form-label">Extended License Price</label>
                            <div class="input-group">
                                <span class="input-group-text">{{ $settings->currency }}</span>
                                <input type="number" step="0.01"
                                    class="common-input form-control @error('extended_price') is-invalid @enderror"
                                    wire:model="extended_price" id="extended_price" placeholder="0.00"
                                    @if ($is_free) disabled @endif>
                            </div>
                            @error('extended_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="discount" class="form-label">Discount (%)</label>
                            <div class="input-group">
                                <input type="number" min="0" max="100"
                                    class="common-input form-control @error('discount') is-invalid @enderror" wire:model="discount"
                                    id="discount" placeholder="0" @if ($is_free) disabled @endif>
                                <span class="input-group-text">%</span>
                            </div>
                            @error('discount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                @if (!$is_free && $regular_price > 0)
                    <div class="alert alert-info mt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Regular License Final Price:</strong>
                                {{ format_price($product->final_price) }}
                            </div>
                            <div class="col-md-6">
                                <strong>Extended License Final Price:</strong>
                                {{ format_price($product->final_extended_price) }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Media Tab -->
        <div class="common-card card mb-4 {{ $activeTab === 'media' ? '' : 'd-none' }}">
            <div class="card-header">
                <h5 class="mb-0">Media Files</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label for="image" class="form-label">Main Image</label>
                            <div class="input-group">
                                <input type="file" class="form-control @error('image') is-invalid @enderror" wire:model="image"
                                    id="image" accept="image/*">
                            </div>
                            <div wire:loading wire:target="image" class="text-sm text-gray-500 mt-1">
                                Uploading...
                            </div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if ($image)
                                <div class="mt-2">
                                    <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail" style="max-height: 200px">
                                </div>
                            @elseif($existing_image)
                                <div class="mt-2">
                                    <img src="{{ my_asset($existing_image) }}" class="img-thumbnail" style="max-height: 200px">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label for="thumbnail" class="form-label">Thumbnail</label>
                            <div class="input-group">
                                <input type="file" class="form-control @error('thumbnail') is-invalid @enderror"
                                    wire:model="thumbnail" id="thumbnail" accept="image/*">
                            </div>
                            <div wire:loading wire:target="thumbnail" class="text-sm text-gray-500 mt-1">
                                Uploading...
                            </div>
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if ($thumbnail)
                                <div class="mt-2">
                                    <img src="{{ $thumbnail->temporaryUrl() }}" class="img-thumbnail" style="max-height: 200px">
                                </div>
                            @elseif($existing_thumbnail)
                                <div class="mt-2">
                                    <img src="{{ my_asset($existing_thumbnail) }}" class="img-thumbnail" style="max-height: 200px">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label for="demo_url" class="form-label">Demo URL</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-link"></i></span>
                        <input type="url" class="common-input form-control @error('demo_url') is-invalid @enderror"
                            wire:model="demo_url" id="demo_url" placeholder="https://example.com/demo">
                    </div>
                    @error('demo_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Screenshots</label>
                    <div class="input-group">
                        <input type="file" class="form-control" wire:model="screenshots" multiple accept="image/*">
                    </div>
                    <div wire:loading wire:target="screenshots" class="text-sm text-gray-500 mt-1">
                        Uploading...
                    </div>
                    <small class="text-muted">Upload multiple screenshots of your product</small>
                </div>

                <div class="row mt-3">
                    @if (count($screenshots) > 0)
                        <div class="col-12">
                            <label class="form-label">New Screenshots</label>
                        </div>
                        @foreach ($screenshots as $index => $screenshot)
                            <div class="col-md-3 mb-3">
                                <div class="position-relative">
                                    <img src="{{ $screenshot->temporaryUrl() }}" class="img-thumbnail"
                                        style="height: 150px; width: 100%; object-fit: cover;">
                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0"
                                        wire:click="removeScreenshot({{ $index }})">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @if (count($existing_screenshots) > 0)
                        <div class="col-12 mt-3">
                            <label class="form-label">Existing Screenshots</label>
                        </div>
                        @foreach ($existing_screenshots as $index => $screenshot)
                            <div class="col-md-3 mb-3">
                                <div class="position-relative">
                                    <img src="{{ my_asset($screenshot) }}" class="img-thumbnail"
                                        style="height: 150px; width: 100%; object-fit: cover;">
                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0"
                                        wire:click="removeExistingScreenshot({{ $index }})">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <!-- Content Tab -->
        <div class="common-card card mb-4 {{ $activeTab === 'content' ? '' : 'd-none' }}">
            <div class="card-header">
                <h5 class="mb-0">Product Content</h5>
            </div>
            <div class="card-body">
                <x-rich-text model="description" />

                <div class="form-group mb-4">
                    <label for="version" class="form-label">Version</label>
                    <input type="text" class="common-input form-control @error('version') is-invalid @enderror" wire:model="version"
                        id="version" placeholder="e.g. 1.0.0">
                    @error('version')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label class="form-label">Tags</label>
                    <div class="input-group">
                        <input type="text" class="common-input form-control" wire:model.defer="tag"
                            wire:keydown.enter.prevent="addTag" placeholder="Add tag and press Enter">
                        <button class="btn btn-outline-secondary" type="button" wire:click="addTag">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <small class="text-muted">Enter tag and press Enter or click the add button</small>

                    <div class="mt-2">
                        @foreach ($tags as $index => $tag)
                            <span class="badge bg-main me-1 mb-1">
                                {{ $tag }}
                                <i class="fas fa-times ms-1 cursor-pointer" wire:click="removeTag({{ $index }})"></i>
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Attributes Tab -->
        <div class="common-card card mb-4 {{ $activeTab === 'attributes' ? '' : 'd-none' }}">
            <div class="card-header">
                <h5 class="mb-0">Product Attributes</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-1"></i>
                    Product attributes help customers understand the technical details and specifications of your product.
                </div>

                <div class="form-group mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" class="common-input form-control" wire:model="attributeKey"
                                placeholder="Attribute Name (e.g. 'compatible_with')">
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="common-input form-control" wire:model="attributeValue"
                                placeholder="Attribute Value">
                        </div>
                        <div class="col-md-2">
                            <select class="common-input form-select" wire:model="attributeType">
                                <option value="text">Text</option>
                                <option value="boolean">Boolean</option>
                                <option value="array">Array (comma separated)</option>
                                <option value="number">Number</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-main w-100" wire:click="addAttribute">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mt-4">
                    <table class="table style-two">
                        <thead>
                            <tr>
                                <th>Attribute</th>
                                <th>Value</th>
                                <th>Type</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customattributes as $key => $value)
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td>
                                        @if (is_array($value))
                                            @foreach ((array) $value as $idx => $item)
                                                {{ is_array($item) ? json_encode($item) : $item }}{{ !$loop->last ? ', ' : '' }}
                                            @endforeach
                                        @elseif(is_bool($value))
                                            <span class="badge {{ $value ? 'bg-success' : 'bg-danger' }}">
                                                {{ $value ? 'Yes' : 'No' }}
                                            </span>
                                        @else
                                            {{ $value }}
                                        @endif
                                    </td>
                                    <td>
                                        @if (is_array($value))
                                            <span class="badge bg-info">Array</span>
                                        @elseif(is_bool($value))
                                            <span class="badge bg-warning">Boolean</span>
                                        @elseif(is_numeric($value))
                                            <span class="badge bg-main">Number</span>
                                        @else
                                            <span class="badge bg-secondary">Text</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            wire:click="removeAttribute('{{ $key }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3">No attributes added yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Attribute Templates</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <button type="button" class="btn btn-outline-main w-100"
                                        wire:click="loadAttributeTemplate('theme')">
                                        <i class="fas fa-paint-brush me-1"></i> Theme Template
                                    </button>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <button type="button" class="btn btn-outline-main w-100"
                                        wire:click="loadAttributeTemplate('plugin')">
                                        <i class="fas fa-puzzle-piece me-1"></i> Plugin Template
                                    </button>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <button type="button" class="btn btn-outline-main w-100"
                                        wire:click="loadAttributeTemplate('graphic')">
                                        <i class="fas fa-images me-1"></i> Graphic Template
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Download Tab -->
        <div class="common-card card mb-4 {{ $activeTab === 'download' ? '' : 'd-none' }}">
            <div class="card-header">
                <h5 class="mb-0">Download Information</h5>
            </div>
            <div class="card-body">
                <div class="form-group mb-4">
                    <label class="form-label">Download Type</label>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" wire:model.live="download_type" id="download_type_file"
                            value="file">
                        <label class="form-check-label" for="download_type_file">
                            File Upload (Store file on server)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" wire:model.live="download_type" id="download_type_link"
                            value="link">
                        <label class="form-check-label" for="download_type_link">
                            External Link (URL to file)
                        </label>
                    </div>
                </div>

                @if ($download_type === 'file')
                    <div class="form-group mb-4">
                        <label for="file_path" class="form-label">Product File</label>
                        <input type="file" class="common-input border form-control @error('file_path') is-invalid @enderror"
                            wire:model="file_path" id="file_path">

                        <div wire:loading wire:target="file_path" class="text-sm text-gray-500 mt-1 d-flex align-items-center">
                            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                            Uploading...
                        </div>

                        <small class="text-muted">Upload the file customers will download after purchase (ZIP, PDF, etc.). Max file size:
                            {{ ini_get('upload_max_filesize') }}</small>

                        @error('file_path')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if ($existing_file && $formMode === 'edit')
                            <div class="mt-2 alert alert-info">
                                <i class="fas fa-file me-1"></i> Current file: {{ basename($existing_file) }}
                            </div>
                        @endif
                    </div>
                @else
                    <div class="form-group mb-4">
                        <label for="download_link" class="form-label">Download URL</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-link"></i></span>
                            <input type="url" class="common-input form-control @error('download_link') is-invalid @enderror"
                                wire:model="download_link" id="download_link" placeholder="https://example.com/file.zip">
                        </div>
                        <small class="text-muted">Enter the URL where customers can download the file after purchase</small>
                        @error('download_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if ($download_link && $formMode === 'edit')
                            <div class="mt-2 alert alert-info">
                                <i class="fas fa-file me-1"></i> Current Link: {{ $download_link }}
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Form Actions -->
        <div class="card mb-4">
            <div class="card-body d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary" wire:click="setActiveTab('basic')">
                    <i class="fas fa-arrow-left me-1"></i> Back to Basic
                </button>
                <div>
                    <button type="submit" class="btn btn-main" wire:loading.attr="disabled">
                        <i class="fas fa-save me-1"></i> {{ $formMode === 'edit' ? 'Update' : 'Create' }} Product
                        <span wire:loading wire:target="save" class="spinner-border spinner-border-sm ms-1" role="status"></span>
                    </button>
                </div>
            </div>
        </div>
    </form>

</div>

@include('layouts.meta')
