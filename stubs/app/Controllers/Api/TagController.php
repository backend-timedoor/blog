<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogTagResource;
use App\Http\Resources\BlogTagResourceCollection;
use App\Models\BlogTag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = BlogTag::filter()->latest()->paginate(10);

        return new BlogTagResourceCollection($tags);
    }

    public function detail(BlogTag $tag)
    {
        return new BlogTagResource($tag);
    }
}
