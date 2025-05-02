<!DOCTYPE html>
<html lang="en">

<head>
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

    <!-- App css -->
    <link href="{{ static_asset('css/vendors.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ static_asset('css/custom.css') }}" rel="stylesheet" type="text/css">

    @yield('styles')
    @stack('styles')
    @livewireStyles()

    <style>
        :root {
            --primary_color: 19, 99, 223;
            --secondary_color: 29, 39, 52;
            --background_color: 247, 247, 247;
            --border_color: 235, 235, 235;
        }

        body {
            background-color: rgb(var(--background_color));
            padding-top: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }


        .invoice-container {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            min-height: 100vh;
            padding: 16px;
        }

        .invoice {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            padding: 40px 60px;
            max-width: 100%;
            width: 850px;
            background-color: #fff;
            margin: auto;
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
        }

        @media (max-width: 991.98px) {
            .invoice {
                padding: 30px;
            }
        }

        .invoice>* {
            -ms-flex-negative: 0;
            flex-shrink: 0;
        }

        .invoice-table-container {
            margin-right: -6px;
            margin-left: -6px;
        }

        .invoice-table {
            width: 100%;
            border-spacing: 6px;
            max-width: 100%;
        }

        .invoice-table th,
        .invoice-table td {
            padding: 12px 20px;
            border: 1px solid rgb(var(--border_color));
        }

        .invoice-table th {
            font-weight: 500;
            background-color: rgb(var(--background_color));
        }

        .invoice-table td {
            background-color: #fff;
        }

        .invoice-table td:first-child {
            min-width: 250px;
        }

        .invoice-table .invoice-table-bg td {
            font-weight: 600;
            font-size: 1.4rem;
            background-color: rgb(var(--background_color));
        }

        @media print {
            @page {
                size: auto;
                margin: 0;
            }

            .print-btn {
                display: none;
            }
        }
    </style>
</head>

<body>

    {{-- page content --}}
    @yield('content')
    {{ $slot ?? '' }}


    {{-- Footer --}}
    @include('layouts.partials.scripts')

</body>

</html>
