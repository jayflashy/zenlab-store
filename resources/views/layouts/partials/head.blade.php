<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="robots" content="index, follow">
<meta name="author" content="Jadesdev">

@yield('meta')
<!-- Canonical URL -->
<link rel="canonical" href="{{ url()->current() }}">

<title>@lang(get_setting('title')) | @yield('title')</title>
<link rel="shortcut icon" href="{{ my_asset(get_setting('favicon')) }}">

<!-- App css -->
<link href="{{ static_asset('css/vendors.css') }}" rel="stylesheet" type="text/css">
<link href="{{ static_asset('css/main.css') }}" rel="stylesheet" type="text/css">
<link href="{{ static_asset('css/custom.css') }}" rel="stylesheet" type="text/css">
@yield('styles')
@stack('styles')
@livewireStyles()
