<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminBlog\BlogCategoryRequest;
use App\Models\BlogCategory;
use App\Util\Image\Image;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = BlogCategory::filter($request)->latest()->paginate(15);

        return view('admin-blog.category.index')->with(compact('categories'));
    }
    
    public function store(BlogCategoryRequest $request)
    {
        $category = new BlogCategory(array_merge($request->all(), $request->multilang));

        $image = new Image(BlogCategory::IMAGE_FOLDER, $request);

        $image->save();

        $category->image = $image->name();

        $category->save();

        return back();
    }

    public function update(BlogCategory $category, BlogCategoryRequest $request)
    {
        $category->fill(array_merge($request->except('image'), $request->multilang));

        if ($request->image) {
            $image = new Image(BlogCategory::IMAGE_FOLDER, $request);

            if ($category->image) {
                $image->delete($category->image);
            }

            $image->save();

            $category->image = $image->name();
        }

        $category->save();

        return back();
    }

    public function delete(BlogCategory $category)
    {
        if ($category->image) {
            $image = new Image(BlogCategory::IMAGE_FOLDER);

            $image->delete($category->image);
        }

        $category->delete();

        return back();
    }
}
