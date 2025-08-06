<?php

namespace App\Livewire\Admin;

use App\Models\OrderItem;
use App\Traits\LivewireToast;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Str;

#[Layout('admin.layouts.app')]
class LicenseManager extends Component
{
    use LivewireToast;
    use WithPagination;

    public $searchTerm = '';

    public $licenseTypeFilter = '';

    public $perPage = 25;

    public $viewingOrderItem;

    public $licenseCode;

    public $supportEndDate;

    public $editingLicense = false;
    public $deleteId;
    public $showDeleteModal = false;

    // meta
    public string $metaTitle = "LicenseManager";

    public function viewOrderItem($id)
    {
        $this->viewingOrderItem = OrderItem::with(['order.user', 'product'])->find($id);
        $this->licenseCode = $this->viewingOrderItem->license_code;
        $this->supportEndDate = show_date($this->viewingOrderItem->support_end_date);
    }

    public function closeViewOrderItem()
    {
        $this->viewingOrderItem = null;
        $this->licenseCode = null;
        $this->supportEndDate = null;
    }

    public function enableEditLicense()
    {
        $this->editingLicense = true;
        if ($this->viewingOrderItem) {
            $supportEnd = optional($this->viewingOrderItem)->support_end_date;

            $this->supportEndDate = $supportEnd
                ? Carbon::parse($supportEnd)->format('Y-m-d')
                : now()->addMonths(3)->format('Y-m-d');

            $this->licenseCode = $this->viewingOrderItem->license_code ?? Str::uuid()->toString();
        }
    }

    public function saveLicense()
    {
        $this->viewingOrderItem->license_code = $this->licenseCode;
        $this->viewingOrderItem->support_end_date = $this->supportEndDate;
        $this->viewingOrderItem->save();

        $this->editingLicense = false;
        $this->successAlert('License updated successfully');
    }


    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    /**
     * Delete the order
     */
    public function deleteOrderItem($id)
    {
        $order = OrderItem::findOrFail($id);
        $order->delete();

        $this->showDeleteModal = false;
        $this->deleteId = null;
        $this->successAlert('OrderItem deleted successfully!');
    }

    public function mount($id = null)
    {
        if ($id) {
            $this->viewOrderItem($id);
        }
    }

    public function render()
    {
        $orderItems = OrderItem::with(['order.user', 'product'])
            ->whereHas('order', function ($query) {
                $query->where('payment_status', 'completed');
            })
            ->when($this->searchTerm, function ($query) {
                $query->whereHas('order.user', function ($query) {
                    $query->where('name', 'like', '%' . $this->searchTerm . '%')
                        ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
                })
                    ->orWhereHas('product', function ($query) {
                        $query->where('name', 'like', '%' . $this->searchTerm . '%');
                    });
            })
            ->when($this->licenseTypeFilter, function ($query) {
                $query->where('license_type', $this->licenseTypeFilter);
            })->latest()
            ->paginate($this->perPage);
        return view('livewire.admin.license-manager', compact('orderItems'));
    }
}
