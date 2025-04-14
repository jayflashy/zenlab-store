<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::all();

        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // validate request
        $request->validate([
            'title' => 'required|string|max:100',
            'slug'  => 'nullable|string',
            'body'  => 'required|string',
            'image' => 'required|file|image',
        ]);
        $slug = slug($request->title);
        $blog = new Blog();
        $blog->title = $request->title;
        $blog->body = $request->body;
        $blog->slug = $slug;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'blog-' . Str::random(23) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/blogs'), $imageName);
            $blog->image = 'blogs/' . $imageName;
        }
        $blog->save();

        return to_route('admin.blogs.index')->withSuccess(__('Blog Created Successfully'));
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $blog = Blog::findorFail($id);

        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($blog, Request $request)
    {

        // slugg
        if ($blog->title != $request->title) {
            $slug = uniqueSlug($request->title, 'blogs');
        } else {
            $slug = $blog->slug;
        }
        $blog->title = $request->title;
        $blog->body = $request->body;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'blog-' . Str::random(23) . '.' . $image->getClientOriginalExtension();

            try {
                unlink(public_path('uploads/' . $blog->image));
            } catch (\Throwable $th) {
                // throw $th;
            }
            $image->move(public_path('uploads/blogs'), $imageName);
            $blog->image = 'blogs/' . $imageName;
        }
        $blog->slug = $slug;
        $blog->save();

        return to_route('admin.blogs.index')->withSuccess(__('Blog updated successfully'));
    }
    /**
     * Remove the specified resource from storage.
     */

    public function destroy($blog)
    {
        $blog->delete();

        return back()->withSuccess('Blog deleted successfully');
    }
}
