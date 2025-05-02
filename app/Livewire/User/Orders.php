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
        $order = Order::whereUserId(Auth::id())->whereCode($code)->with(['items.product'])->firstOrFail();
        $this->view = 'details';
        $this->order = $order;
        $this->pageTitle = 'Order Details - ' . $order->code;
    }
    private function getOrderStatuses(): array
    {
        return [
            'pending'    => 'Pending',
            'processing' => 'Processing',
            'completed'  => 'Completed',
            'cancelled'  => 'Cancelled',
            'failed'     => 'Failed',
        ];
    }

    private function getPaymentStatuses(): array
    {
        return [
            'pending'   => 'Pending',
            'completed' => 'Completed',
            'failed'    => 'Failed',
        ];
    }

    public function render()
    {
        $ordersQuery = Order::query()
            ->whereUserId(Auth::id())->with(['items.product'])
            ->when($this->searchTerm, function ($query): void {
                $query->where(function ($query): void {
                    $query->where('code', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('email', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('name', 'like', '%' . $this->searchTerm . '%');
                });
            })
            ->when($this->statusFilter, function ($query): void {
                $query->where('order_status', $this->statusFilter);
            })
            ->when($this->paymentStatusFilter, function ($query): void {
                $query->where('payment_status', $this->paymentStatusFilter);
            });

        $orders = $ordersQuery->latest()->paginate($this->perPage);
        $orderStatuses = $this->getOrderStatuses();
        $paymentStatuses = $this->getPaymentStatuses();

        return view('livewire.user.orders', compact('orders', 'orderStatuses', 'paymentStatuses'));
    }
}
