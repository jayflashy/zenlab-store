<?php

namespace App\Livewire;

use App\Models\Blog;
use App\Models\Product;
use Livewire\Component;

class Home extends Component
{
    public $blogs;
    public $products;

    public function render()
    {
        $this->blogs = Blog::where('is_active', 1)->latest()->take(3)->get();
        $this->products = Product::where('status', 'published')->latest()->take(12)->get();

        return view('livewire.home');
    }
}
