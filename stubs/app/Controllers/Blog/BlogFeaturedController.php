<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Models\BlogFeatured;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BlogFeaturedController extends Controller
{
    public function index()
    {
        $blogs = BlogFeatured::orderBy('sort_order')->get()->pluck('blog');

        return view('admin-blog.blog-featured.index')->with(compact('blogs'));
    }

    public function delete(Blog $blog) 
    {
        $blog->featured()->delete();

        return back();
    }

    public function store(Request $request)
    {
        if (BlogFeatured::count() >= 5) {
            throw ValidationException::withMessages([
                'code' => ['Max featured blog is 5'],
            ]);
        }

        BlogFeatured::create([
            'blog_id' => $request->blog
        ]);

        return back();
    }

    public function filter()
    {
        $blogs = Blog::filter()
            ->whereDoesntHave('featured')
            ->get();
            
        return BlogResource::collection($blogs);
    }

    public function sort(Request $request)
    {
        $ids = $request->blog;

        if (BlogFeatured::whereIn('blog_id', $ids)->count() != count($ids)) {
            abort(403);
        }

        BlogFeatured::setNewOrder($ids, 1, 'blog_id');

        return response([true]);
    }
}
