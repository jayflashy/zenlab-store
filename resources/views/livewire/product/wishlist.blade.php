@section('title', 'Wishlist')
<div>
    <x-breadcrumb title="{{ $metaTitle }}" page="{{ $metaTitle }}" />

    <div class="container">
        @if ($wishlistItems->count() > 0)
            <div class="row py-5 gy-4 list-grid-wrapper grid-view">
                @forelse($wishlistItems as $wishlistItem)
                    @include('partials.product.list', ['product' => $wishlistItem->product])
                @empty
                @endforelse
            </div>
        @else
            <div class="text-center py-5">
                <i class="far fa-heart fa-3x text-muted mb-3"></i>
                <h4>Your wishlist is empty</h4>
                <p>Start adding products to your wishlist!</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Browse Products</a>
            </div>
        @endif
    </div>
</div>

@include('layouts.meta')
