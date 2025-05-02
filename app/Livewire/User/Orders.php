<?php

namespace App\Livewire\User;

use App\Traits\LivewireToast;
use Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('user.layouts.app')]
class Orders extends Component
{
    use LivewireToast;

    use WithPagination;
    public $searchTerm = '';

    public $statusFilter = '';

    public $orders;
    public $perPage = 25;
    
    public function mount()
    {
        $this->orders = Auth::user()->orders()->paginate(getPaginate());
    }

    public function render()
    {
        return view('livewire.user.orders');
    }
}
