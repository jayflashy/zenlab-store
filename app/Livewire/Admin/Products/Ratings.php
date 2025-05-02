<?php

namespace App\Livewire\Admin\Products;

use App\Models\Rating;
use App\Traits\LivewireToast;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('admin.layouts.app')]
class Ratings extends Component
{
    use LivewireToast;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public $status = '';

    public $type = '';

    public $stars = '';

    public $editingRating;

    public $editStars = 3;

    public $editReview = '';

    public $editType = 'Quality';

    public $isEditing = false;

    public $deleteId;

    public $showDeleteModal = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'type' => ['except' => ''],
        'stars' => ['except' => ''],
    ];

    protected $rules = [
        'editStars' => 'required|integer|min:1|max:5',
        'editReview' => 'nullable|string|max:1000',
        'editType' => 'required|string',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingType()
    {
        $this->resetPage();
    }

    public function updatingStars()
    {
        $this->resetPage();
    }

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

    public function approveRating($ratingId)
    {
        $rating = Rating::findOrFail($ratingId);
        $rating->update(['status' => 'approved']);
        $this->successAlert('Rating approved successfully!');
    }

    public function rejectRating($ratingId)
    {
        $rating = Rating::findOrFail($ratingId);
        $rating->update(['status' => 'rejected']);
        $this->successAlert('Rating rejected!', 'Ratings Rejected');
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteRating($ratingId)
    {
        $rating = Rating::findOrFail($ratingId);
        $rating->delete();
        $this->successAlert('Rating deleted successfully!');
    }

    public function render()
    {
        $ratingTypes = ['Quality', 'Value', 'Design', 'Functionality', 'Customer Service'];

        $ratings = Rating::with(['user', 'product'])
            ->when($this->search, function ($query): void {
                $query->where(function ($q): void {
                    $q->where('review', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', function ($u): void {
                            $u->where('name', 'like', '%' . $this->search . '%')
                                ->orWhere('email', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('product', function ($p): void {
                            $p->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->status, function ($query): void {
                $query->where('status', $this->status);
            })
            ->when($this->type, function ($query): void {
                $query->where('type', $this->type);
            })
            ->when($this->stars, function ($query): void {
                $query->where('stars', $this->stars);
            })
            ->latest()
            ->paginate(30);

        return view('livewire.admin.products.ratings', [
            'ratings' => $ratings,
            'ratingTypes' => $ratingTypes,
        ]);
    }
}
