<?php

namespace App\Http\Requests\AdminPanel\SubCategory;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSubCategoryRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'status' => 'required|boolean',
            'description' => 'required|string',
            'image' => 'required_if:image_exists,false|image|mimes:png,jpg,jpeg|max:2048',
            'is_featured' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
            'image_exists' => 'boolean'
        ];
    }
    public function messages()
    {
        return [
            'image.required_if' => 'The image field is required',

        ];
    }
}
