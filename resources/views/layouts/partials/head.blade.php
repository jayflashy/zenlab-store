<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="robots" content="index, follow">
<meta name="author" content="Jadesdev">

@yield('meta')
<!-- Canonical URL -->
<link rel="canonical" href="{{ url()->current() }}">

<title>@lang(get_setting('title', 'ZenLab')) | @yield('title')</title>
<link rel="shortcut icon" href="{{ my_asset(get_setting('favicon', 'favicon.png')) }}">

{{-- check for dark mode --}}
<script>
    (function () {
        try {
            const theme = localStorage.getItem('zenlab-theme');
            if (theme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
            } else {
                document.documentElement.setAttribute('data-theme', 'light');
            }
        } catch (e) {
            // fallback
            document.documentElement.setAttribute('data-theme', 'light');
        }
    })();
</script>


<!-- App css -->
<link href="{{ static_asset('css/vendors.css') }}" rel="stylesheet" type="text/css">
<link href="{{ static_asset('css/main.css') }}" rel="stylesheet" type="text/css">
<link href="{{ static_asset('css/custom.css') }}" rel="stylesheet" type="text/css">

{{-- summernotes --}}
<link rel="stylesheet" href="{{ static_asset('summernote/summernote-lite.min.css') }}">
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />

@yield('styles')
@stack('styles')
@livewireStyles()
