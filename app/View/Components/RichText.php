<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RichText extends Component
{
    /**
     * Unique identifier for the editor instance.
     */
    public string $id;

    /**
     * Create a new component instance.
     */
    public function __construct(public string $model, $id = null, public string $height = '350px', public string $label = 'Description')
    {
        $this->model = $model;
        $this->id = $id ?? 'editor_'.uniqid();
        $this->height = $height;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.rich-text');
    }
}
