<?php

namespace App\Livewire\User;

use App\Traits\LivewireToast;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('user.layouts.app')]
class Reviews extends Component
{
    use LivewireToast;

    public $metaTitle = 'Reviews';

    public function render()
    {
        $reviews = Auth::user()->reviews()->paginate(25);
        $reviews->load(['user','product']);

        return view('livewire.user.reviews', compact('reviews'));
    }
}
