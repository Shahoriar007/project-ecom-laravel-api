<?php

namespace App\Http\Requests\AdminPanel\ChildCategory;

use Illuminate\Foundation\Http\FormRequest;

class StoreChildCategoryRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'description' => 'required|string',
            'is_featured' => 'required|boolean',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ];
    }
}
