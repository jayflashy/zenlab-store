@extends('layouts.app')
@section('title', $page->title)

@section('content')

    <x-breadcrumb title="{{ $page->title }}" page="{{ $page->title }}" />

    <section class="blog-details padding-y-120 pt-4 position-relative overflow-hidden" style="min-height: 20vh">
        <div class="container container-two">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="blog-details-content">
                        {!! $page->content !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
