<?php

namespace App\Livewire;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class Home extends Component
{
    public $blogs;

    public $featuredCategories;

    public $activeCategory = 'all';

    public $allProducts = [];

    public $categoryProducts = [];

    public $categories;

    public function selectCategory($categoryId)
    {
        $this->activeCategory = $categoryId;

        if ($categoryId === 'all') {
            $this->loadAllProducts();
        }
    }

    public function mount()
    {
        $this->featuredCategories = Category::active()->has('products')->parents()->take(3)->get();

        foreach ($this->featuredCategories as $category) {
            $this->categoryProducts[$category->id] = $category->products()->latest()->take(8)->get();
        }

        $this->loadAllProducts();
    }

    protected function loadAllProducts()
    {
        $this->allProducts = Product::with(['category', 'ratings'])->latest()->take(6)->get();
    }

    public function render()
    {
        $this->blogs = Blog::where('is_active', 1)->latest()->take(3)->get();

        $allCategories = Category::active()->parents()->withCount('products')->orderBy('order')->limit(10)->get();
        $this->categories = $allCategories;

        return view('livewire.home', [
            'topCategories' => $allCategories->take(8),
        ]);
    }
}
