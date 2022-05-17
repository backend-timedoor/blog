<?php

namespace App\Http\Requests\AdminBlog;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'multilang.*.title'   => 'required',
            'multilang.*.content' => 'required',
            'blog_category_id'    => 'required|exists:blog_categories,id',
            'tags'                => 'required|array',
            'tags.*'              => 'exists:blog_tags,id'
        ];
    }
}
