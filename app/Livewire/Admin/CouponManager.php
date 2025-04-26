<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Traits\LivewireToast;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('admin.layouts.app')]
class CouponManager extends Component
{
    use LivewireToast;
    use WithPagination;

    public $view = 'list'; // possible values: list, create, edit

    // List view properties
    public $searchTerm = '';

    public $showExpired = false;

    public $perPage = 10;

    // Form properties
    public $editingCouponId = null;

    public $code;

    public $discount;

    public $discount_type = 'percent';

    public $type = 'general';

    public $product_id = null;

    public $category_id = null;

    public $limit = null;

    public $expires_at = null;

    public bool $active = true;

    public $deleteId;

    public $showDeleteModal = false;

    protected $listeners = ['delete'];

    // Defining constants for dropdown values
    protected const DISCOUNT_TYPES = [
        'percent' => 'Percentage (%)',
        'fixed' => 'Fixed Amount',
    ];

    protected const COUPON_TYPES = [
        'general' => 'General (All Products)',
        'product' => 'Specific Product',
        'category' => 'Product Category',
    ];

    public function backToList(): void
    {
        $this->view = 'list';
        $this->resetForm();
    }

    protected function rules()
    {
        $rules = [
            'code' => 'required|string|max:20|unique:coupons,code',
            'discount' => 'required|numeric|min:0',
            'discount_type' => 'required|in:fixed,percent',
            'type' => 'required|in:general,product,category',
            'product_id' => 'nullable|exists:products,id',
            'category_id' => 'nullable|exists:categories,id',
            'limit' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date|after_or_equal:today',
            'active' => 'boolean',
        ];

        // Adjust unique validation rule for updates
        if ($this->editingCouponId) {
            $rules['code'] = "required|string|max:20|unique:coupons,code,{$this->editingCouponId}";
        }

        return $rules;
    }

    protected function validationAttributes()
    {
        return [
            'discount_type' => 'discount type',
            'product_id' => 'product',
            'category_id' => 'category',
            'expires_at' => 'expiration date',
        ];
    }

    /**
     * Initialize the create form
     */
    public function create()
    {
        $this->resetForm();
        $this->view = 'create';
    }

    /**
     * Load coupon data for editing
     */
    public function edit($id)
    {
        $this->resetForm();
        $this->editingCouponId = $id;

        $coupon = Coupon::findOrFail($id);

        $this->code = $coupon->code;
        $this->discount = $coupon->discount;
        $this->discount_type = $coupon->discount_type->value;
        $this->type = $coupon->type->value;
        $this->product_id = $coupon->product_id;
        $this->category_id = $coupon->category_id;
        $this->limit = $coupon->limit;
        $this->expires_at = $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : null;
        $this->active = boolval($coupon->active) ?? $coupon->active;

        $this->view = 'edit';
    }

    /**
     * Save the coupon (create or update)
     */
    public function save()
    {
        $this->validate();

        $coupon = $this->editingCouponId
            ? Coupon::findOrFail($this->editingCouponId)
            : new Coupon;

        $coupon->fill([
            'code' => $this->code,
            'discount' => $this->discount,
            'discount_type' => $this->discount_type,
            'type' => $this->type,
            'active' => $this->active,
            'limit' => $this->limit,
            'expires_at' => $this->expires_at,

            // Conditionally set related fields based on coupon type
            'product_id' => $this->type === 'product' ? $this->product_id : null,
            'category_id' => $this->type === 'category' ? $this->category_id : null,
        ]);

        $coupon->save();

        $message = $this->editingCouponId ? 'Coupon updated successfully!' : 'Coupon created successfully!';
        $this->successAlert($message);

        $this->resetForm();
        $this->backToList();
    }

    /**
     * Cancel the edit/create form
     */
    public function cancelEdit()
    {
        $this->resetForm();

        $this->backToList();
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
     * Delete the coupon
     */
    public function deleteCoupon($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        $this->showDeleteModal = false;
        $this->deleteId = null;
        $this->successAlert('Coupon deleted successfully!');
    }

    /**
     * Reset form fields to default values
     */
    private function resetForm()
    {
        $this->reset([
            'editingCouponId',
            'code',
            'discount',
            'discount_type',
            'type',
            'product_id',
            'category_id',
            'limit',
            'expires_at',
            'active',
        ]);

        // Set defaults
        $this->discount_type = 'percent';
        $this->type = 'general';
        $this->active = true;
    }

    /**
     * Get the current form title based on view state
     */
    public function getFormTitleProperty()
    {
        return $this->view === 'edit' ? 'Edit Coupon' : 'Create New Coupon';
    }

    /**
     * Render the component
     */
    public function render()
    {
        $couponsQuery = Coupon::query()
            ->when(
                $this->searchTerm,
                fn ($query) => $query->where('code', 'like', "%{$this->searchTerm}%")
            )
            ->when(
                ! $this->showExpired,
                fn ($query) => $query->where(function ($q) {
                    $q->whereNull('expires_at')
                        ->orWhere('expires_at', '>', now());
                })
            );

        $coupons = $couponsQuery->latest()->paginate($this->perPage);

        return view('livewire.admin.coupon-manager', [
            'coupons' => $coupons,
            'products' => Product::orderBy('name')->get(['id', 'name']),
            'categories' => Category::orderBy('name')->get(['id', 'name']),
            'discountTypes' => self::DISCOUNT_TYPES,
            'couponTypes' => self::COUPON_TYPES,
        ]);
    }
}
