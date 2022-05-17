<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogImage;
use App\Util\Image\Image;
use Illuminate\Http\Request;

class BlogImageController extends Controller
{
    public function index(Blog $blog)
    {
        $blog->load('images');
        
        return view('admin-blog.blog.image')->with(compact('blog'));
    }

    public function store(Request $request, Blog $blog)
    {
        $this->validate($request, [
            'image' => 'required|mimes:jpg,jpeg,png|dimensions:max_width=2000,max_height=2000|max:2048'
        ]);

        $image = new Image(BlogImage::IMAGE_FOLDER, $request);
        
        $image->save();

        $blog->image()->create([
            'image' => $image->name()
        ]);

        return back();
    }

    public function update(Request $request, Blog $blog, BlogImage $blogImage)
    {
        $this->validate($request, [
            'image' => 'required|mimes:jpg,jpeg,png|dimensions:max_width=2000,max_height=2000|max:2048'
        ]);

        $image = new Image(BlogImage::IMAGE_FOLDER, $request);

        if ($blogImage->image) $image->delete($blogImage->image);

        $image->save();

        $blogImage->image = $image->name();

        $blogImage->save();

        return back();
    }

    public function delete(Blog $blog, BlogImage $blogImage)
    {
        if ($blogImage->image) {
            $image = new Image(BlogImage::IMAGE_FOLDER);

            $image->delete($blogImage->image);
        }

        $blogImage->delete();

        return back();
    }

    public function sort(Request $request)
    {
        $ids = $request->image;

        if (BlogImage::whereIn('id', $ids)->count() != count($ids)) {
            abort(403);
        }

        BlogImage::setNewOrder($ids);

        return response([true]);
    }
}
