<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.partials.head')
</head>

<body>
    @include('inc.loaders')

    <div class="overlay"></div>

    <div class="side-overlay"></div>
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    {{-- mobile menu --}}
    @include('layouts.mobile-nav')

    {{-- header --}}
    @include('layouts.header')

    {{-- page content --}}
    <main class="">
        @yield('content')
        {{ $slot  ?? ''}}
    </main>

    {{-- Footer --}}
    @include('layouts.footer')
    @include('layouts.partials.scripts')

</body>

</html>
