@section('title', $pageTitle)

<div class="container-fluid py-4">

    @if ($view == 'list')
        @include('partials.orders.list')
    @elseif($view == 'details')
        @include('partials.orders.details')
    @endif

</div>
@include('layouts.meta')
