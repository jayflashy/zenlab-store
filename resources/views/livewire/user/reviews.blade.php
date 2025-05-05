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
                                <td>{{ $rating->review ? text_trimer($rating->review, 30) : 'No review found' }}</td>
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
    <!-- Edit Rating Modal -->
    @if ($isEditing)
        <div class="common-modal modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Rating</h5>
                        <button wire:click="cancelEdit" type="button" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="updateRating">
                            <div class="mb-3">
                                <label class="form-label">Product</label>
                                <input type="text" class="form-control common-input" value="{{ $editingRating->product?->name }}"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Star Rating</label>
                                <div class="star-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <button type="button" wire:click="$set('editStars', {{ $i }})"
                                            class="btn btn-link p-0 text-decoration-none">
                                            <i
                                                class="la la-2x {{ $i <= $editStars ? 'la-star text-warning' : 'la-star-o text-secondary' }} fs-3"></i>
                                        </button>
                                    @endfor
                                    <span class="ms-2">({{ $editStars }}/5)</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Rating Type</label>
                                <select wire:model.defer="editType" class="form-select common-input">
                                    @foreach ($ratingTypes as $ratingType)
                                        <option value="{{ $ratingType }}">{{ $ratingType }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-3">
                                <label class="form-label">Review</label>
                                <textarea wire:model.defer="editReview" class="form-controls common-input" rows="4"></textarea>
                                @error('editReview')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" wire:click="cancelEdit">Cancel</button>
                                <button type="submit" class="btn btn-primary">Update Rating</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@include('layouts.meta')
