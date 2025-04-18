<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public function __construct(public $title, public $page) {}

    public function render()
    {
        return view('components.breadcrumb');
    }
}
