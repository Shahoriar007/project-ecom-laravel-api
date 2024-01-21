<?php

namespace App\Http\Requests\AdminPanel\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            //
            'name' => 'required|string|max:255|unique:categories,name',
            'status' => 'required|boolean',
            'description' => 'required|string',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ];
    }
}
