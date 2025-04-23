<?php

namespace App\Livewire\Product;

use App\Models\Product;
use App\Traits\LivewireToast;
use Livewire\Component;
use Livewire\WithPagination;

class Comments extends Component
{
    use LivewireToast;
    use WithPagination;

    public Product $product;
    public string $newComment = '';
    public ?string $parentId = null;
    public ?string $replyingTo = null;

    protected $rules = [
        'newComment' => 'required|string|max:1000',
    ];

    public function postComment()
    {
        $this->validate();

        $this->product->comments()->create([
            'content' => $this->newComment,
            'parent_id' => $this->parentId,
            'user_id' => null,
        ]);

        $this->reset('newComment', 'parentId', 'replyingTo');
    }

    public function replyTo($commentId)
    {
        $this->parentId = $commentId;
        $this->replyingTo = $commentId;
    }
    public function cancelReply()
    {
        $this->reset('parentId', 'replyingTo');
    }
    public function render()
    {
        $comments = $this->product->comments()
            ->whereNull('parent_id')
            ->with('replies.user', 'user') // eager load
            ->latest()
            ->paginate(15);
        return view('livewire.product.comments', compact('comments'));
    }
}
