<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public $title;

    public $page;

    public function __construct($title, $page)
    {
        $this->title = $title;
        $this->page = $page;
    }

    public function render()
    {
        return view('components.breadcrumb');
    }
}
