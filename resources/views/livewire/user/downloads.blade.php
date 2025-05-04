@section('title', $metaTitle)
<div>
    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="search-box">
                <input wire:model.live.debounce.300ms="search" type="text"
                    class="common-input common-input--lg pill border border-gray-five" placeholder="Search Your Downloads">
                <button type="submit" class="btn btn-main btn-icon icon border-0"><img src="{{ static_asset('images/icons/search.svg') }}"
                        alt=""></button>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="download-wrapper bg-white border border-gray-five">
                @forelse ($items as $item)
                    <div class="download-item flx-between gap-3 p-3">
                        <div class="position-absolute top-0 start-0 translate-middle-y bg-light px-2 py-1 rounded small text-muted">
                            <i class="fas fa-hashtag me-1"></i>{{ $item->order?->code ?? '' }}
                        </div>
                        <div class="download-item__content flx-align flex-nowrap gap-3 flex-grow-1">
                            <div class="download-item__thumb flex-shrink-0">
                                <img src="{{ $item->product->thumbnail ? my_asset($item->product->thumbnail) : my_asset('products/default.jpg') }}"
                                    alt="{{ $item->product->name }}" style="width: 80px; height: 80px; object-fit: cover;">
                            </div>
                            <div class="download-item__info w-100">
                                <h6 class="download-item__title mb-1">
                                    <a href="{{ route('products.view', $item->product->slug) }}"
                                        class="link">{{ $item->product->name }}</a>
                                </h6>

                                <div class="row text-muted font-12 mb-2">
                                    <div class="col-auto">
                                        <strong>License:</strong> {{ ucfirst($item->license_type) ?? 'Standard' }}
                                    </div>
                                    <div class="col-auto">
                                        <strong>Date:</strong> {{ show_datetime($item->created_at) }}
                                    </div>
                                </div>
                                @if ($item->support_end_date)
                                    <div class="col-auto">
                                        <strong>Support:</strong> {{ show_datetime($item->support_end_date) }}
                                    </div>
                                @endif

                                <div class="common-check mt-1">
                                    <input class="form-check-input" type="checkbox" id="notified_{{ $item->product->id }}"
                                        wire:model.live="notify.{{ $item->product->id }}">
                                    <label class="form-check-label text-body fw-400 mb-0" for="notified_{{ $item->product->id }}">
                                        Get notified when updated
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="download-item__right flex-shrink-0 d-inline-flex flex-column gap-2 align-items-end text-end">
                            <button type="button" class="btn btn-outline-main" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.download', $item->id) }}">
                                        <i class="las la-download me-2"></i>Download
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#purchaseCodeModal"
                                        data-code="{{ $item->license_code }}">
                                        <i class="las la-key me-2"></i>License Code
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.license.certificate', $item->id) }}" target="_blank">
                                        <i class="las la-file-alt me-2"></i>License Certificate
                                    </a>
                                </li>
                            </ul>

                            @if ($item->userReview)
                                <div class="bg-white py-1 px-2 rounded d-inline-block mt-2">
                                    <ul class="star-rating justify-content-center mb-0">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <li class="star-rating__item font-14">
                                                <i class="{{ $i <= $item->userReview->rating ? 'fas' : 'far' }} fa-star"></i>
                                            </li>
                                        @endfor
                                    </ul>
                                </div>
                            @else
                                <a href="{{ route('products.view', ['slug' => $item->product->slug, 'review' => 'true']) }}"
                                    class=" mt-2 text-decoration-underline">
                                    Review
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <img src="{{ static_asset('images/icons/sidebar-icon6.svg') }}" alt="No Downloads" class="w-25">
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

    <div class="modal fade" id="purchaseCodeModal" tabindex="-1" aria-labelledby="purchaseCodeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Purchase Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <input id="purchaseCode" type="text" class="form-control common-input form-control-md border border-gray-five"
                            value="" readonly="">
                        <button class="btn btn-primary px-3 btn-copy" data-clipboard-target="#purchaseCode"><i class="far fa-clone"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('purchaseCodeModal');
        modal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const code = button.getAttribute('data-code');
            const modalBody = modal.querySelector('#purchaseCode');
            modalBody.value = code || 'No code available.';

            modal.querySelector('.btn-copy').onclick = function() {
                navigator.clipboard.writeText(modalBody.value).then(function() {
                    toastr.success('License Code Copied');
                }, function(err) {
                    toastr.error('Could not copy text: ', err);
                });
            };
        });
    </script>
</div>

@include('layouts.meta')
