<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Http\Resources\BlogResourceCollection;
use App\Models\Blog;
use App\Models\BlogFeatured;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $blogs = Blog::filter($request)->latest()->paginate(10);

        return new BlogResourceCollection($blogs);
    }

    public function detail(Blog $blog)
    {
        return new BlogResource($blog);
    }

    public function featured()
    {
        $blogs = BlogFeatured::orderBy('sort_order')->get()->pluck('blog');

        return new BlogResourceCollection($blogs);
    }
}
