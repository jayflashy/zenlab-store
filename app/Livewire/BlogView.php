<?php

namespace App\Livewire;

use App\Traits\LivewireToast;
use Livewire\Component;

class BlogView extends Component
{
    use LivewireToast;

    public function render()
    {
        return view('livewire.blog-view');
    }
}
