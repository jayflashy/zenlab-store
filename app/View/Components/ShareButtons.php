<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ShareButtons extends Component
{
    public $url;
    public $title;
    /**
     * Create a new component instance.
     */
    public function __construct($url = null, $title = null)
    {
        $this->url = $url ?? url()->current();
        $this->title = $title ??  get_setting()->title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.share-buttons');
    }
}
