<?php

namespace App\Livewire;

use App\Models\OrderItem;
use App\Traits\LivewireToast;
use Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('user.layouts.app')]
class User extends Component
{
    use LivewireToast;

    public $user;
    public int $totalOrders = 0;
    public int $totalItems = 0;
    public int $completedOrders = 0;
    public float $totalSpent = 0.0;
    public string $metaTitle = 'User Dashboard';
    public $orders;


    public function mount()
    {
        $this->user = Auth::user();
        $this->totalOrders = $this->user->orders()->count();
        $this->completedOrders = $this->user->orders()->where('order_status', 'completed')->count();
        $this->totalSpent = $this->user->orders()->where('payment_status', 'completed')->sum('total');
        $this->totalItems = OrderItem::whereHas('order', function ($query): void {
            $query->where('user_id', $this->user->id)->where('order_status', 'completed');
        })->count();
        $this->orders = $this->user->orders()->with('items.product')->latest()->limit(5)->get();
    }

    public function render()
    {

        return view('livewire.user');
    }
}
