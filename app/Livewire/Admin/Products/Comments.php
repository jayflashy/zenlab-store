<?php

namespace App\Livewire\Admin\Products;

use App\Models\Comment;
use App\Traits\LivewireToast;
use Livewire\Component;
use Livewire\WithPagination;

class Comments extends Component
{
    use LivewireToast;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $status = '';
    public $editingComment = null;
    public $editContent = '';
    public $isEditing = false;
    public $isPreviewingComment = false;
    public $previewComment = null;
    public $deleteId;
    public $showDeleteModal = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    protected $rules = [
        'editContent' => 'required|string|max:1000',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function editComment($commentId)
    {
        $this->isEditing = true;
        $this->isPreviewingComment = false;
        $this->editingComment = Comment::findOrFail($commentId);
        $this->editContent = $this->editingComment->content;
    }

    public function updateComment()
    {
        $this->validate();

        $this->editingComment->update([
            'content' => $this->editContent
        ]);

        $this->isEditing = false;
        $this->editingComment = null;
        $this->editContent = '';

        $this->successAlert('Comment updated successfully!');
    }

    public function cancelEdit()
    {
        $this->isEditing = false;
        $this->editingComment = null;
        $this->editContent = '';
    }

    public function showPreview($commentId)
    {
        $this->isPreviewingComment = true;
        $this->isEditing = false;
        $this->previewComment = Comment::with(['user', 'product', 'parent'])->findOrFail($commentId);
    }

    public function closePreview()
    {
        $this->isPreviewingComment = false;
        $this->previewComment = null;
    }

    public function approveComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->update(['status' => 'approved']);
        $this->isPreviewingComment = false;
        $this->successAlert('Comment approved successfully!');
    }

    public function rejectComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->update(['status' => 'rejected']);
        $this->isPreviewingComment = false;
        $this->warningAlert('Comment rejected!', 'Rejected');
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }
    public function deleteComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        $hasReplies = Comment::where('parent_id', $commentId)->exists();

        if ($hasReplies) {
            $this->errorAlert('Cannot delete a comment with replies. Consider rejecting it instead.', 'error');
            return;
        }

        $comment->delete();
        $this->showDeleteModal = false;
        $this->deleteId = null;
        $this->isPreviewingComment = false;
        $this->successAlert('Comment deleted successfully!');
    }
    public function render()
    {
        $comments = Comment::with(['user', 'product', 'parent'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('content', 'like', '%' . $this->search . '%')
                        // ->orWhereHas('user', function ($u) {
                        //     $u->where('name', 'like', '%' . $this->search . '%')
                        //         ->orWhere('email', 'like', '%' . $this->search . '%');
                        // })
                        ->orWhereHas('product', function ($p) {
                            $p->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->latest()
            ->paginate(10);
        return view('livewire.admin.products.comments', compact('comments'))
            ->layout('admin.layouts.app');
    }
}
