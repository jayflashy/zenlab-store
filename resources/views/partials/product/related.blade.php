
<div class="product-item shadow-sm overlay-none">
    <div class="product-item__thumb d-flex max-h-unset">
        <a href="{{route('products.view', 'product-details')}}" wire:navigate class="link w-100">
            <img src="{{static_asset('images/thumbs/product-img3.png')}}" alt="" class="cover-img">
        </a>
    </div>
    <div class="product-item__content">
        <h6 class="product-item__title">
            <a href="{{route('products.view', 'product-details')}}" wire:navigate class="link">Title here digital products new marketplace theme</a>
        </h6>
        <div class="product-item__info flx-between gap-2">
            <span class="product-item__author">
                by
                <a href="profile.html" class="link hover-text-decoration-underline"> themepix</a>
            </span>
            <div class="flx-align gap-2">
                <h6 class="product-item__price mb-0">$56</h6>
                <span class="product-item__prevPrice text-decoration-line-through">$65</span>
            </div>
        </div>
        <div class="product-item__bottom flx-between gap-2">
                <span class="product-item__sales font-16 mb-2">1230 Sales</span>
                <a href="{{route('products.view', 'product-details')}}" wire:navigate class="btn btn-main pill">Purchase</a>

        </div>
    </div>
</div>
