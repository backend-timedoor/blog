<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Resources\MultilanguageResource;
use App\Models\MultilanguageSetting;
use Illuminate\Http\Request;

class MultilanguageSettingController extends Controller
{
    public function index()
    {
        $languages = MultilanguageSetting::filter()->enable()->orderByDesc('updated_at')->paginate(10);

        return view('admin-blog.language-setting.index')->with(compact('languages'));
    }

    public function searchLanguage()
    {
        $languages = MultilanguageSetting::filter()->get();

        return MultilanguageResource::collection($languages);
    }

    public function store(Request $request)
    {
        $language = MultilanguageSetting::find($request->language_id);

        $language->is_enable = true;
        $language->save();

        forgetCache(); // refresh cache

        return back();
    }

    public function delete(MultilanguageSetting $language)
    {
        $language->is_enable = false;
        $language->save();

        forgetCache(); // refresh cache

        return back();
    }
}
