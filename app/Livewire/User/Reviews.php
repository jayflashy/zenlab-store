<?php

namespace App\Livewire\User;

use App\Models\Rating;
use App\Traits\LivewireToast;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('user.layouts.app')]
class Reviews extends Component
{
    use LivewireToast;

    public $metaTitle = 'Reviews';
    public $type = '';

    public $stars = '';

    public $editingRating;

    public $editStars = 3;

    public $editReview = '';

    public $editType = 'Quality';

    public $isEditing = false;
    public $ratingTypes = ['Quality', 'Value', 'Design', 'Functionality', 'Customer Service'];

    protected $rules = [
        'editStars' => 'required|integer|min:1|max:5',
        'editReview' => 'nullable|string|max:1000',
        'editType' => 'required|string',
    ];
    public function editRating($ratingId)
    {
        $this->isEditing = true;
        $this->editingRating = Rating::findOrFail($ratingId);
        $this->editStars = $this->editingRating->stars;
        $this->editReview = $this->editingRating->review;
        $this->editType = $this->editingRating->type;
    }

    public function updateRating()
    {
        $this->validate();

        $this->editingRating->update([
            'stars' => $this->editStars,
            'review' => $this->editReview,
            'type' => $this->editType,
        ]);

        $this->isEditing = false;
        $this->editingRating = null;
        $this->reset(['editStars', 'editReview', 'editType']);

        $this->successAlert('Rating updated successfully!');
    }

    public function cancelEdit()
    {
        $this->isEditing = false;
        $this->editingRating = null;
        $this->reset(['editStars', 'editReview', 'editType']);
    }

    public function render()
    {
        $reviews = Auth::user()->reviews()->paginate(25);
        $reviews->load(['user', 'product']);

        return view('livewire.user.reviews', compact('reviews'));
    }
}
