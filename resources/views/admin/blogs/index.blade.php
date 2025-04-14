@extends('admin.layouts.app')
@section('title', 'Blogs')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">All Blogs</h1>
            <p class="text-muted small">Manage blogs</p>
        </div>
        <div>
            <a wire:navigate href="{{ route('admin.blogs.create') }}" class="btn btn-main">
                <i class="fa fa-plus-circle me-1"></i> Add New Blog
            </a>
        </div>
    </div>
    <div class="common-card card">
        <div class="card-body table-responsive">
            <table class="table table-hover style-two" id="datatable">
                <thead>
                    <tr>
                        <th>Title </th>
                        <th>Image</th>
                        <th>Tags</th>
                        <th>Actions </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($blogs as $key => $item)
                        <tr>
                            <td>
                                <a href="{{ route('blog.view', $item->slug) }}" wire:navigate> {{ text_trim($item->title, 50) }}</a>
                            </td>
                            <td><img src="{{ my_asset($item->image) }}" class="timg" alt=""></td>
                            <td>{{ text_trim($item->body, 200) }}</td>
                            <td>
                                <div class="dropstart">
                                    <button class="btn btn-light" type="button" id="" data-bs-toggle="dropdown">
                                        <em class="fas fa-ellipsis-v"></em>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" wire:navigate href="{{ route('admin.blogs.edit', $item->id) }}">Edit</a>
                                        <a class="dropdown-item delete-btn" wire:navigate
                                            href="{{ route('admin.blogs.delete', $item->id) }}">@lang('Delete')</a>
                                        <a class="dropdown-item" wire:navigate href="{{ route('blog', $item->slug) }}">View</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection


@push('styles')
    <style>
        .timg {
            width: 50px;
            height: 50px;
        }
    </style>
@endpush
