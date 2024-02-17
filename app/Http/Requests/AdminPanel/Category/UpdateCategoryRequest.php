<?php

namespace App\Http\Requests\AdminPanel\Category;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($this->category)],
            'status' => 'required|boolean',
            'description' => 'required|string',
            'image' => 'required_if:image_exists,false|image|mimes:png,jpg,jpeg|max:2048',
            'parent_name' => 'required|string',
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
