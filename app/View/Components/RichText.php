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
    public function __construct(/**
     * The Livewire model binding for the editor content.
     */
        public string $model, $id = null, /**
     * Height of the editor in CSS units.
     */
        public string $height = '350px', /**
     * Label text displayed above the editor.
     */
        public string $label = 'Description')
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
