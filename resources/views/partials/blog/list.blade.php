<div class="col-lg-4 col-sm-6">
    <div class="post-item">
        <div class="post-item__thumb">
            <a href="{{ route('blogs.view', $blog->slug) }}" wire:navigate class="link">
                <img src="{{ my_asset($blog->image ?? 'blogs/default.png') }}" class="cover-img" alt="">
            </a>
        </div>
        <div class="post-item__content">
            <div class="post-item__top flx-align">
                {{-- <a href="{{route('blogs.view', $blog->slug)}}" wire:navigate class="post-item__tag pill font-14 text-heading fw-500 hover-text-main">Hiring</a> --}}
                <div class="post-item__date font-14 flx-align gap-2 font-14 text-heading fw-500">
                    <span class="icon">
                        <img src="{{ static_asset('images/icons/calendar.svg') }}" alt="" class="white-version">
                        <img src="{{ static_asset('images/icons/calendar-white.svg') }}" alt="" class="dark-version">
                    </span>
                    <span class="text">{{ show_date($blog->created_at, 'M d, Y') }}</span>
                </div>
            </div>
            <h5 class="post-item__title">
                <a href="{{ route('blogs.view', $blog->slug) }}" wire:navigate class="link">{{ $blog->title }}</a>
            </h5>
            <p class="mb-1">{{ textTrim($blog->about, 100) }}</p>
            <a href="{{ route('blogs.view', $blog->slug) }}" wire:navigate class="btn btn-outline-light pill fw-600">Read More </a>
        </div>
    </div>
</div>

