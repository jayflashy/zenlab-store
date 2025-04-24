@section('title', $blog->title)
<div>
    <section class="blog-details padding-y-120 position-relative overflow-hidden">
        <div class="container container-two">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- blog details top Start -->
                    <div class="blog-details-top mb-64">
                        <div class="blog-details-top__info flx-align gap-3 mb-4">
                            <span class="blog-details-top__date flx-align gap-2">
                                <img src="{{ static_asset('images/icons/clock.svg') }}" alt="">
                                {{ show_date($blog->created_at, 'd M Y') }}
                            </span>
                        </div>
                        <h2 class="blog-details-top__title mb-4 text-capitalize">{{ $blog->title }}
                        </h2>
                        <p class="blog-details-top__desc">{{ $blog->about }}</p>
                    </div>
                    <!-- blog details top End -->
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- blog details content Start -->
                    <div class="blog-details-content">
                        <div class="blog-details-content__thumb mb-32">
                            <img src="{{ my_asset($blog->image) }}" alt="{{ $blog->title }}">
                        </div>
                        {{-- content --}}
                        {!! nl2br($blog->body) !!}

                        <!-- Post Tag & Share Start -->
                        <div class="flx-between gap-2 mb-40 mt-40">
                            <div class="post-tag flx-align gap-3">
                                <span class="post-tag__text text-heading fw-500">Post Tag: </span>
                                <ul class="post-tag__list flx-align gap-2">
                                    @foreach ($tags as $tag)
                                        <li class="post-tag__item">
                                            <a href="javascript::void()"
                                                class="post-tag__link font-14 text-heading pill fw-500">{{ $tag }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="socail-share flx-align gap-3">
                                <span class="socail-share__text text-heading fw-500">Share On: </span>
                                <x-share-buttons url="{{ url()->current() }}" title="{{ $blog->title }}" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@include('layouts.meta')
