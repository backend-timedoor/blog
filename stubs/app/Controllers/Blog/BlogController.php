<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminBlog\BlogRequest;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $blogs = Blog::filter($request)->latest()->paginate(15);

        return view('admin-blog.blog.index')->with(compact('blogs'));
    }

    public function create()
    {
        $blog       = new Blog();
        $categories = BlogCategory::all();
        $tags       = BlogTag::all();

        return view('admin-blog.blog.create')->with(compact('blog', 'categories', 'tags'));
    }

    public function store(BlogRequest $request)
    {
        $blog = new Blog(array_merge($request->all(), $request->multilang));

        $blog->save();

        $blog->tags()->attach($request->tags);

        return redirect(route('admin-blog.blog.index'));
    }

    public function edit(Blog $blog)
    {
        $categories = BlogCategory::all();
        $tags       = BlogTag::all();

        return view('admin-blog.blog.edit')->with(compact('blog', 'categories', 'tags'));
    }

    public function update(BlogRequest $request, Blog $blog)
    {
        $blog->fill(array_merge($request->all(), $request->multilang));

        $blog->save();

        $blog->tags()->sync($request->tags);

        return redirect(route('admin-blog.blog.index'));
    }

    public function delete(Blog $blog)
    {
        $blog->delete();

        return back();
    }
}
