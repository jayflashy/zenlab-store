@section('title', 'Product Ratings')

<div class="common-card card">
    <div class="card-header bg-white">
        <h5 class="mb-0">Manage Product Ratings</h5>
    </div>

    <div class="card-body">
        <div class="row mb-4">
            <div class="col-sm-6 col-md-3">
                <input wire:model.debounce.live.300ms="search" type="text" class="form-control common-input"
                    placeholder="Search...">
            </div>
            <div class="col-sm-6 col-md-3">
                <select wire:model.live="status" class="form-select common-input">
                    <option value="">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <div class="col-sm-6 col-md-3">
                <select wire:model.live="type" class="form-select common-input">
                    <option value="">All Types</option>
                    @foreach ($ratingTypes as $ratingType)
                        <option value="{{ $ratingType }}">{{ $ratingType }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6 col-md-3">
                <select wire:model.live="stars" class="form-select common-input">
                    <option value="">All Ratings</option>
                    <option value="5">5 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="2">2 Stars</option>
                    <option value="1">1 Star</option>
                </select>
            </div>
        </div>

        <!-- Ratings Table -->
        <div class="table-responsive">
            <table class="table style-two">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>User</th>
                        <th>Rating</th>
                        <th>Type</th>
                        <th>Review</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ratings as $rating)
                        <tr>
                            <td>
                                <a href="{{ route('products.view', $rating->product->slug) }}" target="_blank">
                                    {{ Str::limit($rating->product->name, 20) }}
                                </a>
                            </td>
                            <td>
                                @if ($rating->user)
                                    <a href="{{ route('admin.users.show', $rating->user->id) }}">
                                        {{ $rating->user?->name }}
                                    </a>
                                @else
                                    Guest User
                                @endif

                            </td>
                            <td>
                                <div class="star-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i
                                            class="la {{ $i <= $rating->stars ? 'la-star text-warning' : 'la-star-o' }}"></i>
                                    @endfor
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $rating->type }}</span>
                            </td>
                            <td>{{ $rating->review ? Str::limit($rating->review, 30) : 'No review' }}</td>
                            <td>
                                <span
                                    class="badge bg-{{ $rating->status === 'approved' ? 'success' : ($rating->status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($rating->status) }}
                                </span>
                            </td>
                            <td>{{ $rating->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light" type="button"
                                        id="dropdownMenuButton{{ $rating->id }}" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $rating->id }}">
                                        <li>
                                            <button wire:click="editRating('{{ $rating->id }}')"
                                                class="dropdown-item">
                                                <i class="las la-edit me-2"></i> Edit
                                            </button>
                                        </li>
                                        <li>
                                            <button wire:click="approveRating('{{ $rating->id }}')"
                                                class="dropdown-item {{ $rating->status === 'approved' ? 'disabled' : '' }}">
                                                <i class="las la-check me-2"></i> Approve
                                            </button>
                                        </li>
                                        <li>
                                            <button wire:click="rejectRating('{{ $rating->id }}')"
                                                class="dropdown-item {{ $rating->status === 'rejected' ? 'disabled' : '' }}">
                                                <i class="las la-ban me-2"></i> Reject
                                            </button>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <button wire:click="confirmDelete('{{ $rating->id }}')"
                                                class="dropdown-item text-danger">
                                                <i class="las la-trash me-2"></i> Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">No ratings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $ratings->links() }}
        </div>
    </div>

    <!-- Edit Rating Modal -->
    @if ($isEditing)
        <div class="common-modal modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);"
            tabindex="-1">
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
                                <input type="text" class="form-control common-input"
                                    value="{{ $editingRating->product->name }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">User</label>
                                <input type="text" class="form-control common-input"
                                    value="{{ $editingRating->user ? $editingRating->user->name : 'Guest User' }}"
                                    readonly>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Rating Type</label>
                                    <select wire:model.defer="editType" class="form-select common-input">
                                        @foreach ($ratingTypes as $ratingType)
                                            <option value="{{ $ratingType }}">{{ $ratingType }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Star Rating</label>
                                    <div class="star-rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <button type="button" wire:click="$set('editStars', {{ $i }})"
                                                class="btn btn-link p-0 text-decoration-none">
                                                <i
                                                    class="la {{ $i <= $editStars ? 'la-star text-warning' : 'la-star-o text-secondary' }} fs-3"></i>
                                            </button>
                                        @endfor
                                        <span class="ms-2">({{ $editStars }}/5)</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Review</label>
                                <textarea wire:model.defer="editReview" class="form- common-input" rows="4"></textarea>
                                @error('editReview')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary"
                                    wire:click="cancelEdit">Cancel</button>
                                <button type="submit" class="btn btn-primary">Update Rating</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- delete modal --}}
    @if ($showDeleteModal)
        <div class="common-modal modal fade show" tabindex="-1" id="deleteModal" aria-hidden="true"
            style="display:block;background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Delete</h5>
                        <button type="button" class="btn-close"
                            wire:click="$set('showDeleteModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this rating?</p>
                        <p class="text-danger">This action cannot be undone and will permanently remove the rating from
                            your store.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            wire:click="$set('showDeleteModal', false)">Cancel</button>
                        <button type="button" class="btn btn-danger"
                            wire:click="deleteRating('{{ $deleteId }}')">
                            <i class="fas fa-trash me-1"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@include('layouts.meta')
