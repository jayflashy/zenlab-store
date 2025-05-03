<?php

namespace App\Livewire\User;

use App\Models\OrderItem;
use App\Traits\LivewireToast;
use Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('user.layouts.app')]
class Downloads extends Component
{
    use LivewireToast;
    use WithPagination;

    public $search = '';
    public $metaTitle = 'Downloads';

    public function render()
    {
        $query = OrderItem::whereHas('order', function ($query) {
            $query->where('user_id', Auth::id())->where('order_status', 'pending');
        })->with(['product.ratings'])->latest();

        if ($this->search) {
            $query->whereHas('product', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        $items = $query->paginate(30);
        return view('livewire.user.downloads', compact('items'));
    }
}
