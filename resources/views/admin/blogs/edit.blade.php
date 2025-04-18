@extends('admin.layouts.master')
@section('title', 'Edit Blog')

@section('content')
    <div class="card">
        <form class="" action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label" for="name">@lang('Title') <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="@lang('Title')" value="{{ $blog->title }}" name="title" required>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="" class="form-label">Image</label>
                        <input type="file" accept="image/*" name="image" id="" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <img src="{{my_asset($blog->image)}}" class="timg" alt="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="name">@lang('Body') <span class="text-danger">*</span></label>
                    <textarea class="form-control" placeholder="@lang('Body')" id="tiny1" name="body"rows="4">{{ $blog->body }}</textarea>
                </div>

                <div class="me-2 text-end">
                    <button type="submit" class="btn btn-primary w-100">@lang('Update Blog')</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('page-title')
    <ol class="breadcrumb m-0">
        <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Blog')</a></li>
        <li class="breadcrumb-item active">@yield('title')</li>
    </ol>
@endsection
@push('styles')
<style>

    .timg{
        width: 250px;
        height: 200px;
    }

</style>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ static_asset('summer/summernote-lite.css') }}">
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="{{ static_asset('summer/summernote-lite.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#tiny1').summernote({
                height: 400
            });
        });
    </script>
@endpush
