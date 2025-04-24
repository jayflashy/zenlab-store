<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StarRating extends Component
{
    public float $rating;

    public int $count;

    /**
     * Create a new component instance.
     */
    public function __construct(float $rating, int $count = 0)
    {
        $this->rating = $rating;
        $this->count = $count;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.star-rating');
    }
}
