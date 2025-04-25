<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CartBreadcrumb extends Component
{
    public $step;

    public $stepTitle;

    /**
     * Create a new component instance.
     */
    public function __construct(int $step = 1, string $stepTitle = 'Cart')
    {
        $this->step = $step;
        $this->stepTitle = $stepTitle;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cart-breadcrumb');
    }
}
