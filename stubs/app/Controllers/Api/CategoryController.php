<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogCategoryResource;
use App\Http\Resources\BlogCategoryResourceCollection;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::filter()->latest()->paginate(10);

        return new BlogCategoryResourceCollection($categories);
    }

    public function detail(BlogCategory $category)
    {
        return new BlogCategoryResource($category);
    }
}
