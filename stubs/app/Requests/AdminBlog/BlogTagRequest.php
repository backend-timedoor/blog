<?php

namespace App\Http\Requests\AdminBlog;

use Illuminate\Foundation\Http\FormRequest;

class BlogTagRequest extends FormRequest
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
        $rules = [
            'image'            => 'mimes:jpg,jpeg,png|dimensions:max_width=2000,max_height=2000|max:2048',
            'multilang.*.name' => 'required'
        ];

        if ($this->method() == 'POST') {
            $rules['image'] .= '|required';
        }

        return $rules;
    }
}
