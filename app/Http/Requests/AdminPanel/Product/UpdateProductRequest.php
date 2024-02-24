<?php

namespace App\Http\Requests\AdminPanel\Product;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', Rule::unique('products')->ignore($this->product)],
            'status' => 'required|boolean',
            'short_description' => 'required|string',
            'offer_notice' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|max:255',
            'is_hot' => 'boolean',
            'is_sale' => 'boolean',
            'is_new' => 'boolean',
            'is_for_you' => 'boolean',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'child_category_id' => 'required|exists:child_categories,id',
            'large_pictures' => 'required_if:image_exists,false|array',
            'large_pictures*' => 'required_if:image_exists,false|image|mimes:png,jpg,jpeg|max:2048',
            'labels' => 'required|array',
            'labels*' => 'required|string',
            'image_exists' => 'boolean',
            'remove_all_image' => 'boolean'
        ];
    }

    public function messages()
    {
        return [
            'images.required_if' => 'The image field is required',

        ];
    }
}
