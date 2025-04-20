@section('title', 'Blog Manager')
<div>
    {{-- List View --}}
    @if ($view === 'list')
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">All Blogs</h1>
                <p class="text-muted small">Manage all your blog content</p>
            </div>
            <div>
                <a wire:navigate href="{{ route('admin.blogs.create') }}" class="btn btn-main">
                    <i class="fa fa-plus-circle me-1"></i> Add New Blog
                </a>
            </div>
        </div>

        {{-- Search & Filter --}}
        <div class="common-card card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <input type="text" class="common-input border" placeholder="Search blogs..." wire:model.debounce.300ms="search">
                    </div>
                </div>
            </div>
        </div>

        {{-- Blog List --}}
        <div class="common-card card">
            <div class="card-body table-responsive">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <table class="table table- style-two">
                    <thead>
                        <tr>
                            <th wire:click="sortBy('title')" style="cursor: pointer;">
                                Title
                                @if ($sortField === 'title')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </th>
                            <th>Image</th>
                            <th>About</th>
                            <th>Tags</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($blogs as $blog)
                            <tr>
                                <td>{{ text_trimer($blog->title, 50) }}</td>
                                <td>
                                    @if ($blog->image)
                                        <img src="{{ my_asset($blog->image) }}" class="img-thumbnail"
                                            style="width: 50px; height: 50px; object-fit: cover;" alt="{{ $blog->title }}">
                                    @else
                                        <span class="badge bg-secondary">No Image</span>
                                    @endif
                                </td>
                                <td>{{text_trimer($blog->about, 50) }}</td>
                                <td>{{text_trimer($blog->tags, 30) }}</td>
                                <td>
                                    @if ($blog->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm" type="button" id="dropdownMenuButton{{ $blog->id }}"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $blog->id }}">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('blogs.view', $blog->slug) }}" target="_blank">
                                                    <i class="fas fa-eye me-2"></i> View
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{route('admin.blogs.edit', $blog->id)}}" wire:navigate >
                                                    <i class="fas fa-edit me-2"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-danger"
                                                    wire:click="confirmDelete('{{ $blog->id }}')">
                                                    <i class="fas fa-trash me-2"></i> Delete
                                                </button>
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
                                        <h5 class="text-muted">No blogs found</h5>
                                        @if ($search)
                                            <p class="text-muted small">Try adjusting your search criteria</p>
                                        @else
                                            <a wire:navigate href="{{ route('admin.blogs.create') }}" class="btn btn-sm btn-primary mt-2">
                                                <i class="fas fa-plus-circle me-1"></i> Create your first blog
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $blogs->links() }}
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
                            Are you sure you want to delete this blog? This action cannot be undone.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="cancelDelete">Cancel</button>
                            <button type="button" class="btn btn-danger" wire:click="deleteBlog">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Create/Edit Form --}}
    @else
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">{{ $view === 'create' ? 'Create Blog' : 'Edit Blog' }}</h1>
                <p class="text-muted mb-0">
                    {{ $view === 'create' ? 'Create blog' : 'Update content' }}</p>
            </div>
            <div>
                <a wire:navigate href="{{route('admin.blogs')}}"  class="btn btn-outline-secondary">
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
                                    wire:model.debounce.300ms="title" placeholder="Enter blog title">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Slug --}}
                            <div class="form-group mb-4">
                                <label for="slug" class="form-label">Slug</label>
                                <div class="input-group">
                                    <span class="input-group-text text-muted bg-light">{{ url('/blog/') }}/</span>
                                    <input type="text" class="form-control common-input border @error('slug') is-invalid @enderror" id="slug"
                                        wire:model.defer="slug" placeholder="auto-generated-slug">
                                </div>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">URL-friendly version of the title (auto-generated, but can be edited)</small>
                            </div>

                            {{-- Body Content --}}
                            <div class="form-group mb-4" wire:ignore>
                                <label for="summernote" class="form-label">Content <span class="text-danger">*</span></label>
                                <textarea class="common-input border @error('body') is-invalid @enderror"  wire:model.defer="body" id="summernote" rows="10">{{ $body }}</textarea>
                            </div>
                            @error('body')
                                <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            {{-- About (Short Description) --}}
                            <div class="form-group mb-4">
                                <label for="about" class="form-label">Short Description</label>
                                <textarea class="common-input border @error('about') is-invalid @enderror" id="about" wire:model.defer="about" rows="3"
                                    placeholder="Brief summary of your blog post"></textarea>
                                @error('about')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Short description used in blog listings (max 255 characters)</small>
                            </div>
                        </div>

                        {{-- Right Column --}}
                        <div class="col-lg-4">
                            {{-- Status --}}
                            <div class="form-group mb-4">
                                <label class="form-label d-block">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" wire:model.defer="is_active">
                                    <label class="form-check-label" for="is_active">
                                        {{ $is_active ? 'Active' : 'Inactive' }}
                                    </label>
                                </div>
                                <small class="text-muted">Inactive blogs won't be displayed on the website</small>
                            </div>

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
                                    @endif

                                    <div class="mb-2 {{ $imagePreviewUrl ? 'mt-3' : '' }}">
                                        <label for="image"
                                            class="btn btn-outline-primary w-100 {{ $imagePreviewUrl ? 'd-none' : '' }}">
                                            <i class="fas fa-cloud-upload-alt me-2"></i>
                                            {{ $view === 'edit' ? 'Change Image' : 'Upload Image' }}
                                        </label>
                                        <input type="file" id="image" class="d-none" wire:model="image" accept="image/*">
                                    </div>

                                    <div class="text-muted small {{ $imagePreviewUrl ? 'd-none' : '' }}">
                                        Recommended size: 1200x630 pixels. JPG, PNG or WebP format.
                                    </div>
                                </div>
                                @error('image')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tags --}}
                            <div class="form-group mb-4">
                                <label for="tags" class="form-label">Tags</label>
                                <textarea class="common-input border @error('tags') is-invalid @enderror" id="tags" wire:model.defer="tags" rows="2"
                                    placeholder="lifestyle, technology, tips"></textarea>
                                @error('tags')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Enter tags separated by commas</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                        <a type="button" class="btn btn-secondary" wire:navigate href="{{ route('admin.blogs') }}" >
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> {{ $view === 'create' ? 'Create Blog' : 'Update Blog' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>


@section('styles')
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection

@section('scripts')
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
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
                        @this.set('body', contents);
                    }
                }
            });
        // });
    </script>
@endsection
@include('layouts.meta')
