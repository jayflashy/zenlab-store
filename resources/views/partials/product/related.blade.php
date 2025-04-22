<div class="product-item shadow-sm overlay-none">
    <div class="product-item__thumb d-flex max-h-unset">
        <a href="{{ route('products.view', $relatedProduct->slug) }}" wire:navigate class="link w-100">
            <img src="{{ my_asset($relatedProduct->image ?? 'products/default.jpg') }}" alt="" class="cover-img">
        </a>
    </div>
    <div class="product-item__content">
        <h6 class="product-item__title">
            <a href="{{ route('products.view', $relatedProduct->slug) }}" wire:navigate class="link">{{$relatedProduct->name}}</a>
        </h6>
        <div class="product-item__info flx-between gap-2">
            <span class="product-item__author">

            </span>
            <div class="flx-align gap-2">
                <h6 class="product-item__price mb-0">{{ format_price($relatedProduct->final_price) }}</h6>
                <span class="product-item__prevPrice text-decoration-line-through">{{ format_price($relatedProduct->regular_price) }}</span>
            </div>
        </div>
        <div class="product-item__bottom flx-between gap-2">
            <span class="product-item__sales font-16 mb-2">{{ $relatedProduct->total_sales }} Sales</span>
            <a href="{{ route('products.view', $relatedProduct->slug) }}" wire:navigate class="btn btn-main pill">Purchase</a>
        </div>
    </div>
</div>
