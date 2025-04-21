<?php

namespace App\Livewire\Admin\Products;

use App\Models\Category;
use App\Models\Product;
use App\Traits\LivewireToast;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use LivewireToast;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // filters
    public $search = '';

    public $statusFilter = '';

    public $categoryFilter = '';

    public $typeFilter = '';

    public $featuredFilter = '';

    public $sortField = 'created_at';

    public $sortDirection = 'desc';

    public $perPage = 25;

    // Bulk Actions
    public $selectedProducts = [];

    public $selectAll = false;

    public $products;

    // Modals
    public $showDeleteModal = false;

    public $deleteId = null;

    public $productToDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
        'typeFilter' => ['except' => ''],
        'featuredFilter' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'perPage' => ['except' => 10],
    ];

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatingTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingFeaturedFilter()
    {
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->productToDelete = Product::find($id);
        $this->showDeleteModal = true;
    }

    public function deleteProduct()
    {
        if ($this->deleteId) {
            $product = Product::find($this->deleteId);

            if ($product) {
                // Delete associated files
                if ($product->image && Storage::exists($product->image)) {
                    Storage::delete($product->image);
                }
                if ($product->thumbnail && Storage::exists($product->thumbnail)) {
                    Storage::delete($product->thumbnail);
                }
                if ($product->download_type === 'file' && $product->file_path && Storage::exists($product->file_path)) {
                    Storage::delete($product->file_path);
                }

                // Delete screenshots
                if ($product->screenshots) {
                    $screenshots = json_decode($product->screenshots, true);
                    foreach ($screenshots as $screenshot) {
                        if (Storage::exists($screenshot)) {
                            Storage::delete($screenshot);
                        }
                    }
                }

                // Delete the product
                $product->delete();

                session()->flash('success', 'Product deleted successfully.');
            }
        }

        $this->showDeleteModal = false;
        $this->deleteId = null;
        $this->productToDelete = null;
    }

    public function bulkDelete()
    {
        if (count($this->selectedProducts) > 0) {
            $products = Product::whereIn('id', $this->selectedProducts)->get();

            foreach ($products as $product) {
                // Delete associated files
                if ($product->image && Storage::disk('uploads')->exists($product->image)) {
                    Storage::disk('uploads')->delete($product->image);
                }
                if ($product->thumbnail && Storage::disk('uploads')->exists($product->thumbnail)) {
                    Storage::disk('uploads')->delete($product->thumbnail);
                }
                if ($product->download_type === 'file' && $product->file_path && Storage::disk('uploads')->exists($product->file_path)) {
                    Storage::disk('uploads')->delete($product->file_path);
                }

                // Delete screenshots
                if ($product->screenshots) {
                    $screenshots = json_decode($product->screenshots, true);
                    foreach ($screenshots as $screenshot) {
                        if (Storage::disk('uploads')->exists($screenshot)) {
                            Storage::disk('uploads')->delete($screenshot);
                        }
                    }
                }

                // Delete the product
                $product->delete();
            }

            $this->successAlert(count($this->selectedProducts).' Products deleted successfully');
            $this->selectedProducts = [];
            $this->selectAll = false;
        }
    }

    public function bulkPublish()
    {
        if (count($this->selectedProducts) > 0) {
            Product::whereIn('id', $this->selectedProducts)->update([
                'status' => 'published',
                'publish_date' => now(),
            ]);

            $this->successAlert(count($this->selectedProducts).' Products published successfully');
            $this->selectedProducts = [];
            $this->selectAll = false;
        }
    }

    public function bulkFeature()
    {
        if (count($this->selectedProducts) > 0) {
            Product::whereIn('id', $this->selectedProducts)->update([
                'featured' => 1,
            ]);

            $this->successAlert(count($this->selectedProducts).' Products featured successfully');
            $this->selectedProducts = [];
            $this->selectAll = false;
        }
    }

    public function bulkArchive()
    {
        if (count($this->selectedProducts) > 0) {
            Product::whereIn('id', $this->selectedProducts)->update([
                'status' => 'archived',
            ]);

            $this->successAlert(count($this->selectedProducts).' Products archived successfully');
            $this->selectedProducts = [];
            $this->selectAll = false;
        }
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedProducts = $this->products->pluck('id')->map(fn ($id) => (string) $id)->toArray();
        } else {
            $this->selectedProducts = [];
        }
    }

    public function getProductsProperty()
    {
        return $this->queryProducts()->get();
    }

    public function render()
    {
        $products = $this->queryProducts()->paginate($this->perPage);

        $categories = Category::orderBy('name')->get();

        $productTypes = Product::select('type')
            ->distinct()
            ->pluck('type')
            ->toArray();

        return view('livewire.admin.products.product-list', [
            'products' => $products,
            'categories' => $categories,
            'productTypes' => $productTypes,
            'pageTitle' => 'Manage Poducts',
        ])->layout('admin.layouts.app');
    }

    private function queryProducts()
    {
        $query = Product::query()
            ->with('category')
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('slug', 'like', '%'.$this->search.'%')
                        ->orWhere('short_description', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->categoryFilter, function ($query) {
                $query->where('category_id', $this->categoryFilter);
            })
            ->when($this->typeFilter, function ($query) {
                $query->where('type', $this->typeFilter);
            })
            ->when($this->featuredFilter !== '', function ($query) {
                $query->where('featured', $this->featuredFilter === '1');
            })
            ->orderBy($this->sortField, $this->sortDirection);

        return $query;
    }
}
