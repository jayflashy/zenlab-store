@section('title', 'Page Manager')
<div>
    {{-- List View --}}
    @if ($view === 'list')
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">All Pages</h1>
                <p class="text-muted small">Manage all your page content</p>
            </div>
            <div>
                <a wire:navigate href="{{ route('admin.pages.create') }}" class="btn btn-main">
                    <i class="fa fa-plus-circle me-1"></i> Add New Page
                </a>
            </div>
        </div>

        {{-- Search & Filter --}}
        <div class="common-card card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <input type="text" class="common-input border" placeholder="Search pages..." wire:model="search"
                            wire:keydown="applySearch">
                    </div>
                </div>
            </div>
        </div>

        {{-- Page List --}}
        <div class="common-card card">
            <div class="card-body table-responsive">
                <table class="table table- style-two">
                    <thead>
                        <tr>
                            <th wire:click="sortBy('title')" style="cursor: pointer;">
                                Name
                                @if ($sortField === 'title')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </th>
                            <th>Image</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pages as $page)
                            <tr>
                                <td>{{ text_trimer($page->title, 50) }}</td>
                                <td>
                                    @if ($page->image)
                                        <img src="{{ my_asset($page->image) }}" class="img-thumbnail"
                                            style="width: 50px; height: 50px; object-fit: cover;" alt="{{ $page->title }}">
                                    @else
                                        <span class="badge bg-secondary">No Image</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($page->type == 'custom')
                                        <span class="badge bg-info">Custom</span>
                                    @else
                                        <span class="badge bg-primary">Default</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm" type="button" id="dropdownMenuButton{{ $page->id }}"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $page->id }}">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('pages.view', $page->slug) }}" target="_blank">
                                                    <i class="fas fa-eye me-2"></i> View
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.pages.edit', $page->id) }}" wire:navigate>
                                                    <i class="fas fa-edit me-2"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                @if ($page->type == 'custom')
                                                    <button class="dropdown-item text-danger"
                                                        wire:click="confirmDelete('{{ $page->id }}')">
                                                        <i class="fas fa-trash me-2"></i> Delete
                                                    </button>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No pages found</h5>
                                        @if ($search)
                                            <p class="text-muted small">Try adjusting your search criteria</p>
                                        @else
                                            <a wire:navigate href="{{ route('admin.pages.create') }}" class="btn btn-sm btn-primary mt-2">
                                                <i class="fas fa-plus-circle me-1"></i> Create your first page
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $pages->links() }}
                </div>
            </div>
        </div>

        {{-- Delete Confirmation Modal --}}
        @if ($confirmingDelete)
            <div class="common-modal modal fade show" style="display: block; background-color: rgba(0, 0, 0, 0.5);">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm Delete</h5>
                            <button type="button" class="btn-close" wire:click="cancelDelete"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this page? This action cannot be undone.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="cancelDelete">Cancel</button>
                            <button type="button" class="btn btn-danger" wire:click="deletePage">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Create/Edit Form --}}
    @else
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">{{ $view === 'create' ? 'Create Page' : 'Edit Page' }}</h1>
                <p class="text-muted mb-0">
                    {{ $view === 'create' ? 'Create page' : 'Update content' }}</p>
            </div>
            <div>
                <a wire:navigate href="{{ route('admin.pages') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to List
                </a>
            </div>
        </div>

        <div class="common-card card">
            <div class="card-body">
                <form wire:submit.prevent="save">
                    <div class="row">
                        {{-- Left Column --}}
                        <div class="col-lg-8">
                            {{-- Title --}}
                            <div class="form-group mb-4">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text"
                                    class="common-input border common-input border-lg @error('title') is-invalid @enderror" id="title"
                                    wire:model.debounce.300ms="title" placeholder="Enter page title">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Slug --}}
                            <div class="form-group mb-4">
                                <label for="slug" class="form-label">Slug</label>
                                <div class="input-group">
                                    <span class="input-group-text text-muted bg-light">{{ url('/page/') }}/</span>
                                    <input type="text" class="form-control common-input border @error('slug') is-invalid @enderror"
                                        id="slug" wire:model.defer="slug" placeholder="auto-generated-slug">
                                </div>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">URL-friendly version of the title (auto-generated, but can be edited)</small>
                            </div>

                            {{-- Body Content --}}
                            <div class="form-group mb-4" wire:ignore>
                                <label for="summernote" class="form-label">Content <span class="text-danger">*</span></label>                            
                                <textarea wire:model.defer="content" class="common-input border @error('content') is-invalid @enderror" id="summernote" rows="10">{{ $content }}</textarea>
                            </div>
                            @error('content')
                                <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                        </div>

                        {{-- Right Column --}}
                        <div class="col-lg-4">

                            {{-- Featured Image --}}
                            <div class="form-group mb-4">
                                <label class="form-label">Featured Image
                                    @if ($view === 'create')
                                        <span class="text-danger">*</span>
                                    @endif
                                </label>
                                <div class="image-upload-wrapper border p-3 mb-2">
                                    @if ($imagePreviewUrl)
                                        <div class="image-preview mb-3">
                                            <img src="{{ $imagePreviewUrl }}" alt="Preview" class="img-fluid rounded mb-2"
                                                style="max-height: 200px;">
                                            <br>
                                            <button type="button" class="btn btn-sm btn-danger" wire:click="removeImage">Remove
                                                Image</button>
                                        </div>
                                    @elseif ($isUploading)
                                        <div class="text-center py-3">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <p class="mt-2">Uploading...</p>
                                        </div>
                                    @endif

                                    <div class="mb-2 {{ $imagePreviewUrl ? 'mt-3' : '' }}">
                                        <label for="image"
                                            class="btn btn-outline-primary w-100 {{ $imagePreviewUrl ? 'd-none' : '' }}">
                                            <i class="fas fa-cloud-upload-alt me-2"></i>
                                            {{ $view === 'edit' ? 'Change Image' : 'Upload Image' }}
                                        </label>
                                        <input type="file" id="image" class="d-none" wire:model="image"
                                            wire:loading.attr="disabled" wire:loading.class="opacity-50" wire:target="image"
                                            x-on:livewire-upload-start="$wire.isUploading = true"
                                            x-on:livewire-upload-finish="$wire.isUploading = false"
                                            x-on:livewire-upload-error="$wire.isUploading = false" accept="image/*">
                                    </div>

                                    <div class="text-muted small {{ $imagePreviewUrl ? 'd-none' : '' }}">
                                        Recommended size: 1200x630 pixels. JPG, PNG or WebP format.
                                    </div>
                                </div>
                                @error('image')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                        <a type="button" class="btn btn-secondary" wire:navigate href="{{ route('admin.pages') }}">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                            <i class="fas fa-save me-1"></i> {{ $view === 'create' ? 'Create Page' : 'Update Page' }}
                            <span wire:loading wire:target="save" class="spinner-border spinner-border-sm ms-1" role="status"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>



@section('scripts')
    <script>
        // document.addEventListener('livewire:load', function() {
            $('#summernote').summernote({
                height: 500,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onChange: function(contents) {
                        @this.set('content', contents);
                    }
                }
            });
        // });
    </script>
@endsection
@include('layouts.meta')
