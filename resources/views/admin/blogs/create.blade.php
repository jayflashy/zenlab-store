@extends('admin.layouts.app')

@section('title', 'Create Blog')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Create Blog</h1>
            <p class="text-muted mb-0">Create engaging content for your readers</p>
        </div>
    </div>

    <div class="common-card card">
        <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-lg-8">
                        <!-- Title -->
                        <div class="form-group mb-4">
                            <label class="form-label" for="title">@lang('Title') <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="title" name="title"
                                placeholder="@lang('Enter blog title')" required>
                        </div>

                        <!-- Body Content -->
                        <div class="form-group mb-4">
                            <label class="form-label" for="body">@lang('Content') <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="summernote" name="body" rows="10"></textarea>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-lg-4">
                        <!-- Featured Image -->
                        <div class="form-group mb-4">
                            <label class="form-label" for="imageUpload">Featured Image <span class="text-danger">*</span></label>
                            <div class="image-upload-wrapper">
                                <div class="image-preview mb-3" id="imagePreview" style="display: none;">
                                    <img id="previewImage" src="#" alt="Preview" class="img-fluid rounded">
                                    <button type="button" class="btn btn-sm btn-danger mt-2" id="removeImage">Remove Image</button>
                                </div>
                                <div class="input-group">
                                    <input type="file" class="form-control" id="imageUpload" name="image" accept="image/*" required>
                                </div>
                                <small class="text-muted">Recommended size: 1200x630 pixels</small>
                            </div>
                        </div>

                        <!-- Tags -->
                        <div class="form-group mb-4">
                            <label class="form-label" for="tags">Tags</label>
                            <textarea class="form-control" id="tags" name="tags" rows="3" placeholder="Add tags separated by commas"></textarea>
                        </div>

                        <!-- SEO Title -->
                        <div class="form-group mb-4">
                            <label class="form-label" for="seo_title">SEO Title</label>
                            <input type="text" class="form-control" id="seo_title" name="seo_title" placeholder="Optional SEO title">
                        </div>

                        <!-- Meta Description -->
                        <div class="form-group mb-4">
                            <label class="form-label" for="meta_description">Meta Description</label>
                            <textarea class="form-control" id="meta_description" name="meta_description" rows="3" placeholder="Optional meta description"></textarea>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i> @lang('Publish Blog')
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <style>
        .image-upload-wrapper {
            border: 1px dashed #ddd;
            padding: 20px;
            border-radius: 8px;
            background: #f9f9f9;
            text-align: center;
        }

        .image-preview img {
            max-height: 200px;
            width: auto;
            margin-bottom: 10px;
        }

        .note-editor.note-frame {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }
    </style>
@endpush

@push('scripts')
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Summernote
            $('#summernote').summernote({
                height: 500,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            // Image preview
            const imageUpload = document.getElementById('imageUpload');
            const previewImage = document.getElementById('previewImage');
            const imagePreview = document.getElementById('imagePreview');
            const removeImage = document.getElementById('removeImage');

            imageUpload.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        imagePreview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                }
            });

            removeImage.addEventListener('click', function() {
                previewImage.src = '#';
                imageUpload.value = '';
                imagePreview.style.display = 'none';
            });
        });
    </script>
@endpush
