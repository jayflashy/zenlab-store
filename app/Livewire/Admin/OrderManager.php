<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Services\OrderService;
use App\Traits\LivewireToast;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('admin.layouts.app')]
class OrderManager extends Component
{
    use LivewireToast;
    use WithFileUploads;
    use WithPagination;

    public $searchTerm = '';

    public $statusFilter = '';

    public $paymentStatusFilter = '';

    public $paymentGatewayFilter = '';

    public $dateFrom = '';

    public $dateTo = '';

    public $perPage = 25;

    // Order view and edit properties
    public $viewingOrder;

    public $editingNotes = false;

    public $orderNotes = '';

    // Status update properties
    public $updatingOrderId;

    public $newOrderStatus = '';

    public $newPaymentStatus = '';

    public $deleteId;

    public $showDeleteModal = false;

    // For manual payment verification
    public $manualPaymentReceipt;

    protected $orderService;

    protected $listeners = ['refreshOrders' => '$refresh'];

    public function boot(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function viewOrder($id)
    {
        $this->viewingOrder = Order::with(['items.product', 'user'])->find($id);
        $this->orderNotes = $this->viewingOrder->notes;
    }

    public function closeViewOrder()
    {
        $this->viewingOrder = null;
        $this->editingNotes = false;
        $this->orderNotes = '';
    }

    public function enableEditNotes()
    {
        $this->editingNotes = true;
    }

    public function saveNotes()
    {
        if (! $this->viewingOrder) {
            return;
        }

        $this->viewingOrder->notes = $this->orderNotes;
        $this->viewingOrder->save();

        $this->editingNotes = false;
        $this->successAlert('Order notes updated successfully');
    }

    public function prepareStatusUpdate($orderId)
    {
        $this->updatingOrderId = $orderId;
        $order = Order::find($orderId);
        $this->newOrderStatus = $order->order_status;
        $this->newPaymentStatus = $order->payment_status;
    }

    public function updateStatus()
    {
        $order = Order::find($this->updatingOrderId);

        if (! $order) {
            $this->errorAlert('Order not found');

            return;
        }

        $oldPaymentStatus = $order->payment_status;

        $order->order_status = $this->newOrderStatus;
        $order->payment_status = $this->newPaymentStatus;

        // If marking as completed and wasn't completed before
        if ($this->newPaymentStatus === 'completed' && $oldPaymentStatus !== 'completed') {
            $this->orderService->completeOrder($order);
            $this->successAlert('Order marked as completed and processed successfully');
        }
        // If marking as failed and wasn't failed before
        elseif ($this->newPaymentStatus === 'failed' && $oldPaymentStatus !== 'failed') {
            $this->orderService->failOrder($order);
            $this->successAlert('Order marked as failed');
        }
        // Otherwise just update the status
        else {
            $order->save();
            $this->successAlert('Order status updated successfully');
        }

        $this->updatingOrderId = null;
        $this->newOrderStatus = '';
        $this->newPaymentStatus = '';
    }

    public function cancelStatusUpdate()
    {
        $this->updatingOrderId = null;
        $this->newOrderStatus = '';
        $this->newPaymentStatus = '';
    }

    public function verifyManualPayment($orderId)
    {
        $order = Order::find($orderId);

        if (! $order) {
            $this->erroralert('Order not found');

            return;
        }

        // Mark order as completed
        $this->orderService->completeOrder($order, [
            'manual_verification' => true,
            'verified_at' => now(),
        ]);

        $this->successAlert('Manual payment verified and order completed successfully');
    }

    public function downloadReceipt($orderId)
    {
        $order = Order::find($orderId);

        if (! $order || ! $order->payment_receipt) {
            $this->erroralert('Receipt not found');

            return;
        }

        return response()->download(public_path('uploads/' . $order->payment_receipt));
    }

    /**
     * Show delete confirmation dialog
     */
    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    /**
     * Delete the order
     */
    public function deleteOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        $this->showDeleteModal = false;
        $this->deleteId = null;
        $this->successAlert('Order deleted successfully!');
    }

    public function render()
    {
        $ordersQuery = Order::query()
            ->with(['user', 'items.product'])
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
            })
            ->when($this->paymentGatewayFilter, function ($query): void {
                $query->where('payment_method', $this->paymentGatewayFilter);
            })
            ->when($this->dateFrom, function ($query): void {
                $query->whereDate('created_at', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query): void {
                $query->whereDate('created_at', '<=', $this->dateTo);
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

        $paymentMethods = [
            'paystack_payment' => 'Paystack',
            'flutterwave_payment' => 'Flutterwave',
            'paypal_payment' => 'PayPal',
            'cryptomus_payment' => 'Cryptomus',
            'manual_payment' => 'Bank Transfer',
        ];

        return view('livewire.admin.order-manager', [
            'orders' => $orders,
            'orderStatuses' => $orderStatuses,
            'paymentStatuses' => $paymentStatuses,
            'paymentMethods' => $paymentMethods,
        ]);
    }
}
