<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminBlog\BlogTagRequest;
use App\Models\BlogTag;
use App\Util\Image\Image;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $tags = BlogTag::filter()->latest()->paginate(15);

        return view('admin-blog.tag.index')->with(compact('tags'));
    }
    
    public function store(BlogTagRequest $request)
    {
        $tag   = new BlogTag(array_merge($request->all(), $request->multilang));
        $image = new Image(BlogTag::IMAGE_FOLDER, $request);

        $image->save();

        $tag->image = $image->name();

        $tag->save();

        return back();
    }

    public function update(BlogTag $tag, BlogTagRequest $request)
    {
        $tag->fill(array_merge($request->except('image'), $request->multilang));

        if ($request->image) {
            $image = new Image(BlogTag::IMAGE_FOLDER, $request);

            if ($tag->image) {
                $image->delete($tag->image);
            }

            $image->save();

            $tag->image = $image->name();
        }

        $tag->save();

        return back();
    }

    public function delete(BlogTag $tag)
    {
        if ($tag->image) {
            $image = new Image(BlogTag::IMAGE_FOLDER);

            $image->delete($tag->image);
        }

        $tag->delete();

        return back();
    }
}
