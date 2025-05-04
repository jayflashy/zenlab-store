@section('title', $metaTitle)
<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Reviews</h1>
            <p class="text-muted small">Manage your reviews on products</p>
        </div>
    </div>

    <div class="common-card card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table style-two">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $rating)
                            <tr>
                                <td>
                                    <a href="{{ route('products.view', $rating->product->slug) }}" target="_blank">
                                        {{ Str::limit($rating->product->name, 20) }}
                                    </a>
                                </td>
                                <td>
                                    <div class="star-rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="la {{ $i <= $rating->stars ? 'la-star text-warning' : 'la-star-o' }}"></i>
                                        @endfor
                                    </div>
                                </td>
                                <td>{{ $rating->review ? text_trimer($rating->review, 30) : 'No review' }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $rating->status === 'approved' ? 'success' : ($rating->status === 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($rating->status) }}
                                    </span>
                                </td>
                                <td>{{ show_date($rating->created_at, 'M d, Y H:i') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light" type="button" id="dropdownMenuButton{{ $rating->id }}"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $rating->id }}">
                                            <li>
                                                <button wire:click="editRating('{{ $rating->id }}')" class="dropdown-item">
                                                    <i class="las la-edit me-2"></i> Edit
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No ratings found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $reviews->links('partials.pagination') }}
            </div>
        </div>
    </div>

</div>

@include('layouts.meta')
