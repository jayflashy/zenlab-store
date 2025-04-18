
@section('meta')
    {{-- Primary Meta Tags --}}
    <meta name="title" content="{{ $metaTitle ?? get_setting('title', 'ZenLab stores') }}">
    <meta name="description" content="{{ $metaDescription ?? get_setting('meta_description', 'Zenlab scripts store for quality scripts') }}">
    <meta name="keywords" content="{{ $metaKeywords ?? get_setting('meta_keywords', 'web, design, scripts, templates') }}">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $metaTitle ?? get_setting('title', 'ZenLab stores') }}">
    <meta property="og:description" content="{{ $metaDescription ?? get_setting('meta_description', 'Zenlab scripts store for quality scripts') }}">
    <meta property="og:image" content="{{ $metaImage ?? my_asset(get_setting('logo')) }}">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ $metaTitle ?? get_setting('title', 'ZenLab stores') }}">
    <meta name="twitter:description" content="{{ $metaDescription ?? get_setting('meta_description', 'Zenlab scripts store for quality scripts') }}">
    <meta name="twitter:image" content="{{ $metaImage ?? my_asset(get_setting('logo')) }}">
@endsection
