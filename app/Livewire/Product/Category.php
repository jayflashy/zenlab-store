<?php

namespace App\Livewire\Product;

use App\Models\Category as ModelsCategory;
use App\Models\Product;
use App\Traits\LivewireToast;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Category extends Component
{
    use LivewireToast;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // meta
    public string $metaTitle;

    public string $slug;

    public string $metaDescription;

    public $category;

    public $products;

    public $categoryId;

    public $categories;

    public string $metaKeywords;

    public string $metaImage;

    public function getTotalProductsCount()
    {
        return $this->category->products()->active()->count();
    }

    public function getCategories()
    {
        return ModelsCategory::active()->parents()->withCount('products')->orderBy('order')->get();
    }

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->category = ModelsCategory::where('slug', $slug)->firstOrFail();
        $this->products = Product::where('category_id', $this->category->id)->active()->limit(12)->get();
        $this->categories = $this->getCategories();

        // set meta
        $this->metaTitle = $this->category->name;
        $this->metaDescription = $this->category->description;
    }

    public function render()
    {
        return view('livewire.product.category');
    }
}
