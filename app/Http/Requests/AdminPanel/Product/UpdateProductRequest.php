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
            'description' => 'required|string',
            'offer_notice' => 'required|string',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'sku_code' => 'required|string|max:255',
            'is_flash_sale' => 'boolean',
            'is_new_arrival' => 'boolean',
            'is_hot_deal' => 'boolean',
            'is_for_you' => 'boolean',
            'category_id' => 'required|exists:categories,id',
            'images' => 'required_if:image_exists,false|array',
            'images*' => 'required_if:image_exists,false|image|mimes:png,jpg,jpeg|max:2048',
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
