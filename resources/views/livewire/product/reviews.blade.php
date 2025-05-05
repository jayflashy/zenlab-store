<div class="product-review-wrapper">
    <h5 class="mb-32">Product Ratings</h5>

    <!-- Review Form -->
    @auth
        <div class="review-form-container mb-4">
            <div class="d-flex justify-content-between">
                <h6 class="mb-3">{{ $isEditing ? 'Update Your Review' : 'Write a Review' }}</h6>
                <button type="button" class="btn btn-primary" wire:click="toggleForm">
                    {{ $showForm ? 'Cancel' : ($isEditing ? 'Edit Your Review' : 'Add Review') }}
                </button>
            </div>

            @if ($showForm)
                <form wire:submit.prevent="submitReview" class="border border-secondary p-2 my-3">
                    <div class="mb-3">
                        <label class="form-label">Your Rating</label>
                        <div class="star-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="button" wire:click="setStars({{ $i }})" class="btn btn-link p-0 text-decoration-none">
                                    <i class="la fa-2x {{ $i <= $editStars ? 'la-star text-warning' : 'la-star-o text-secondary' }} fs-3"></i>
                                </button>
                            @endfor
                            <span class="ms-2">({{ $editStars }}/5)</span>
                        </div>
                        @error('stars')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Review Category</label>
                        <select class="common-input form-select" wire:model="type">
                            <option value="">Select a category</option>
                            @foreach ($ratingTypes as $ratingType)
                                <option value="{{ $ratingType }}">{{ $ratingType }}</option>
                            @endforeach
                        </select>
                        @error('type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Your Review</label>
                        <textarea class="common-input form-control" wire:model="review" rows="4" placeholder="Share your experience with this product..."></textarea>
                        @error('review')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">
                            {{ $isEditing ? 'Update Review' : 'Submit Review' }}
                        </button>
                        <button type="button" class="btn btn-secondary" wire:click="toggleForm">
                            Cancel
                        </button>
                    </div>
                </form>
            @elseif($isEditing)
                <div class="border border-light p-3 my-3">
                    <div class="d-flex align-items-center mb-2">
                        <div class="me-3">
                            <x-star-rating :rating="$userRating->stars" />
                        </div>
                        <span class="badge bg-secondary">{{ $userRating->type }}</span>
                    </div>
                    <p class="mb-0">{!! nl2br($userRating->review) !!}</p>
                </div>
            @endif
        </div>
    @else
        <div class="alert alert-info mb-4">
            <p>Please <a href="{{ route('login') }}">login</a> to submit a review.</p>
        </div>
    @endauth

    <!-- Existing Reviews -->
    @forelse ($ratings as $rating)
        <div class="product-review">
            <div class="product-review__top flx-between">
                <div class="product-review__rating flx-align">
                    <x-star-rating :rating="$rating->stars" />
                    <span class="product-review__reason">For <span class="product-review__subject">{{ $rating->type }}</span> </span>
                </div>
                <div class="product-review__date">
                    by <a href="#" class="product-review__user text--base">{{ $rating->user->name ?? 'User' }} </a>
                    {{ $rating->updated_at->diffForHumans() }}
                </div>
            </div>
            <div class="product-review__body">
                <p class="product-review__desc">{!! nl2br($rating->review) !!}</p>
            </div>
        </div>
    @empty
        <div class="product-review text-center">
            <p class="">No ratings found</p>
        </div>
    @endforelse
</div>
