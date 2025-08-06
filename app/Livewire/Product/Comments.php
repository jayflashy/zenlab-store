<?php

namespace App\Livewire\Product;

use App\Models\Comment;
use App\Models\Product;
use App\Traits\LivewireToast;
use Auth;
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

        $user = Auth::user();
        $comment =  $this->product->comments()->create([
            'content' => $this->newComment,
            'parent_id' => $this->parentId,
            'user_id' => $user->id,
            'status' => 'approved',
        ]);
        // TODO: product settings auto approve comments?
        if ($comment->parent_id) {
            $parentComment = Comment::find($comment->parent_id)->load('user');
            if ($parentComment) {
                $recipient = $parentComment->user;
                if ($recipient->id != $user->id) {
                    sendNotification('COMMENT_REPLY', $recipient, [
                        'comment' => $comment,
                        'user_name' => $recipient->name,
                        'replier_name' => $user->name,
                        'product_name' => $this->product->name,
                        'comment_link' => route('products.view', $this->product->slug)."?comments#comment-".$comment->id,
                    ]);
                }
            }
        }

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
        $comments = $this->product->comments()->approved()
            ->whereNull('parent_id')
            ->with('replies.user', 'user') // eager load
            ->latest()
            ->paginate(15);

        return view('livewire.product.comments', compact('comments'));
    }
}
