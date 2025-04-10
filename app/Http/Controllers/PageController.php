<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $page = Page::where('type', 'about')->firstOrFail();
        return view('page', compact('page'));
    }

    public function policy()
    {
        $page = Page::where('type', 'policy')->firstOrFail();
        return view('page', compact('page'));
    }

    public function terms()
    {
        $page = Page::where('type', 'terms')->firstOrFail();
        return view('page', compact('page'));
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('type', 'custom')->firstOrFail();
        return view('page', compact('page'));
    }
}
