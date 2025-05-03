@section('title', $metaTitle)
<div>
    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="search-box">
                <input wire:model.live.debounce.300ms="search" type="text" class="common-input common-input--lg pill border border-gray-five" placeholder="Search Your Downloads">
                <button type="submit" class="btn btn-main btn-icon icon border-0"><img src="{{static_asset('images/icons/search.svg')}}" alt=""></button>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="download-wrapper bg-white border border-gray-five">
                @forelse ($items as $item)
                <div class="download-item flx-between gap-3">
                    <div class="download-item__content flx-align flex-nowrap gap-3 flex-grow-1">
                        <div class="download-item__thumb flex-shrink-0">
                            <img src="{{ $item->product->thumbnail ? my_asset($item->product->thumbnail) : my_asset('products/default.jpg') }}" alt="{{ $item->product->name }}">
                        </div>
                        <div class="download-item__info">
                            <h6 class="download-item__title mb-1">
                                <a href="{{ route('products.view', $item->product->slug) }}" class="link">{{ $item->product->name }}</a>
                            </h6>
                            <a href="#" class="download-item__text text-main mb-3 font-12 hover-text-decoration-underline">{{ $item->license_type ?? 'Standard License' }}</a>
                            <div class="common-check">
                                <input class="form-check-input" type="checkbox" name="checkbox" id="notified_{{ $item->id }}" wire:model.live="notify.{{ $item->id }}">
                                <label class="form-check-label text-body fw-400 mb-0" for="notified_{{ $item->id }}">Get notified by email if this item is updated</label>
                            </div>
                        </div>
                    </div>
                    <div class="download-item__right flex-shrink-0 d-inline-flex flex-column gap-2 align-items-center">
                        <a href="#" class="btn btn-main pill px-4">
                            Download <span class="icon-right icon ms-0"> <i class="las la-download"></i></span>
                        </a>

                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <div class="mb-3">
                        <img src="{{ static_asset('images/icons/no-data.svg') }}" alt="No Downloads" class="w-25">
                    </div>
                    <h5>No downloads found</h5>
                    <p class="text-muted">You don't have any downloadable items yet</p>
                    <a href="{{ route('products') }}" class="btn btn-main mt-3">Browse Products</a>
                </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $items->links('partials.pagination') }}
            </div>
        </div>
    </div>
</div>

@include('layouts.meta')
