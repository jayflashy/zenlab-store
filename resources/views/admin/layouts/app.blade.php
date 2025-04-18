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
    @include('admin.layouts.mobile-nav')

    <section class="dashboard">
        <div class="dashboard__inner d-flex">

            {{-- sidebar --}}
            @include('admin.layouts.sidebar')


            <div class="dashboard-body">
                {{-- dashboard nav --}}
                @include('admin.layouts.nav')

                <div class="dashboard-body__content">
                    {{-- page content --}}
                    {{ $slot ?? '' }}
                    @yield('content')
                </div>

                {{-- Footer --}}
                @include('admin.layouts.footer')
            </div>
    </section>

    @include('layouts.partials.scripts')

</body>

</html>
