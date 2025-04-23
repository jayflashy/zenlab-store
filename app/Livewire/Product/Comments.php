<?php

namespace App\Livewire\Product;

use App\Models\Product;
use App\Traits\LivewireToast;
use Livewire\Component;

class Comments extends Component
{
    use LivewireToast;

    public Product $product;
    public string $newComment = '';
    public ?string $parentId = null;

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

        $this->reset('newComment', 'parentId');
    }

    public function replyTo($commentId)
    {
        $this->parentId = $commentId;
    }
    public function render()


    {
        $comments = $this->product->comments()
            ->whereNull('parent_id')
            ->with('replies.user', 'user') // eager load
            ->latest()
            ->get();
        return view('livewire.product.comments', compact('comments'));
    }
}
