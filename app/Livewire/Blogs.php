<?php

namespace App\Livewire;

use App\Models\Blog;
use App\Traits\LivewireToast;
use Livewire\Component;
use Livewire\WithPagination;

class Blogs extends Component
{
    use LivewireToast;
    use WithPagination;

    public function render()
    {
        $blogs = Blog::whereIsActive(1)->latest()->paginate(15);

        return view('livewire.blogs', compact('blogs'));
    }
}
