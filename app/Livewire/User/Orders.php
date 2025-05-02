<?php

namespace App\Livewire\User;

use App\Models\Order;
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

    public $paymentStatusFilter = '';

    public int $perPage = 25;

    public $view = 'list';

    public ?Order $order = null;

    public $metaTitle = 'Order History';

    public $pageTitle = 'Order History';

    public function mount($code = null)
    {
        $this->view = 'list';

        $routeName = request()->route()->getName();

        if ($routeName === 'user.orders.view' && $code) {
            $this->resetPage();
            $this->orderDetails($code);
        }
    }

    public function orderDetails($code)
    {
        $order = Order::whereUserId(Auth::id())->whereCode($code)->with(['user', 'items.product'])->firstOrFail();
        $this->view = 'details';
        $this->order = $order;
        $this->pageTitle = 'Order Details - ' . $order->code;
    }

    public function orderInvoice($code)
    {
        $order = Order::whereUserId(Auth::id())->whereCode($code)->with(['user', 'items.product'])->firstOrFail();
        $this->view = 'invoice';
        $this->order = $order;
        $this->pageTitle = 'Order Invoice - ' . $order->code;
    }

    public function render()
    {
        $ordersQuery = Order::query()
            ->whereUserId(Auth::id())->with(['user', 'items.product'])
            ->when($this->searchTerm, function ($query) {
                $query->where(function ($query) {
                    $query->where('code', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('email', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('name', 'like', '%' . $this->searchTerm . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('order_status', $this->statusFilter);
            })
            ->when($this->paymentStatusFilter, function ($query) {
                $query->where('payment_status', $this->paymentStatusFilter);
            });

        $orders = $ordersQuery->latest()->paginate($this->perPage);
        $orderStatuses = [
            'pending' => 'Pending',
            'processing' => 'Processing',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            'failed' => 'Failed',
        ];

        $paymentStatuses = [
            'pending' => 'Pending',
            'completed' => 'Completed',
            'failed' => 'Failed',
        ];

        return view('livewire.user.orders', compact('orders', 'orderStatuses', 'paymentStatuses'));
    }
}
