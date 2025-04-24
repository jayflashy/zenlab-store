<?php

namespace App\Livewire;

use App\Models\Blog;
use Livewire\Component;

class Home extends Component
{
    public $blogs;

    public function render()
    {
        $this->blogs = Blog::where('is_active', 1)->latest()->take(3)->get();

        return view('livewire.home');
    }
}
