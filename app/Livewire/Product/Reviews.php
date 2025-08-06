<?php

namespace App\Livewire\Product;

use App\Models\Product;
use App\Models\Rating;
use App\Traits\LivewireToast;
use Auth;
use Livewire\Component;

class Reviews extends Component
{
    use LivewireToast;

    public Product $product;

    public $userRating = null;

    public $stars = 0;

    public $editStars = 0;

    public $type = '';

    public $review = '';

    public $isEditing = false;

    public $showForm = false;

    public $ratingTypes = ['Quality', 'Value', 'Design', 'Functionality', 'Customer Service'];

    public function mount()
    {
        // Check if the user already has a rating for this product
        if (Auth::check()) {
            $this->userRating = Rating::where('product_id', $this->product->id)
                ->where('user_id', Auth::id())
                ->first();

            if ($this->userRating) {
                $this->stars = $this->userRating->stars;
                $this->editStars = $this->userRating->stars;
                $this->type = $this->userRating->type;
                $this->review = $this->userRating->review;
                $this->isEditing = true;
            }
        }
    }

    protected function rules()
    {
        return [
            'stars' => 'required|integer|min:1|max:5',
            'type' => 'required|string|max:100',
            'review' => 'required|string|min:10',
        ];
    }

    public function toggleForm()
    {
        $this->showForm = ! $this->showForm;

        // Reset the form if we're closing it
        if (! $this->showForm) {
            $this->resetForm();
        }
    }

    public function resetForm()
    {
        if ($this->userRating) {
            $this->stars = $this->userRating->stars;
            $this->editStars = $this->userRating->stars;
            $this->type = $this->userRating->type;
            $this->review = $this->userRating->review;
        } else {
            $this->stars = 0;
            $this->editStars = 0;
            $this->type = '';
            $this->review = '';
        }
    }

    // Update the stars model when clicking the star icons
    public function setStars($value)
    {
        $this->editStars = $value;
        $this->stars = $value;
    }

    public function submitReview()
    {
        if (! Auth::check()) {
            $this->errorAlert('Please login to submit a review');

            return;
        }

        $this->validate();
        $user = Auth::user();
        try {
            if ($this->isEditing && $this->userRating) {
                // Update existing rating
                $this->userRating->update([
                    'stars' => $this->stars,
                    'type' => $this->type,
                    'review' => $this->review,
                ]);
                $this->successAlert('Your review has been updated!');
            } else {
                // Create new rating
                $rating = Rating::create([
                    'product_id' => $this->product->id,
                    'user_id' => $user->id,
                    'stars' => $this->stars,
                    'type' => $this->type,
                    'review' => $this->review,
                    'status' => 'approved',
                ]);
                // notify admin
                sendAdminNotification('ADMIN_NEW_REVIEW', [
                    'moderation_link' => route('admin.products.ratings') . '?rating_id=' . $rating->id,
                    'product_name' => $this->product->name,
                    'authur_name' => $user->name,
                    'user_email' => $user->email,
                    'rating_stars' => $this->stars,
                    'review_content' => $this->review,
                ]);
                $this->successAlert('Thank you for your review!');
                $this->isEditing = true;
                $this->userRating = Rating::where('product_id', $this->product->id)->where('user_id', Auth::id())->first();
            }

            $this->showForm = false;
            $this->product->refresh();
        } catch (\Exception $e) {
            $this->errorAlert('Something went wrong: ' . $e->getMessage(), 'error');
        }
    }

    public function render()
    {
        $ratings = $this->product->ratings()->with('user')->orderBy('updated_at', 'desc')->get();
        $this->product->load('ratings.user');

        return view('livewire.product.reviews', compact('ratings'));
    }
}
