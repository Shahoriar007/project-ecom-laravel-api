<?php

namespace App\Http\Requests\AdminPanel\SubCategory;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubCategoryRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ];
    }
}
