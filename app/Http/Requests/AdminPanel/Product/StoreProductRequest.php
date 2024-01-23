<?php

namespace App\Http\Requests\AdminPanel\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|string|unique:products,name|max:255',
            'status' => 'required|boolean',
            'description' => 'required|string',
            'offer_notice' => 'required|string',
            'price' => 'required|numeric|min:0',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'sku_code' => 'required|string|max:255',
            'is_flash_sale' => 'required|boolean',
            'is_new_arrival' => 'required|boolean',
            'is_hot_deal' => 'required|boolean',
            'is_for_you' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
            'images' => 'required|array',
            'image*' => 'required|image|mimes:png,jpg,jpeg|max:2048'
            // Add any other validation rules as needed
            // 'image', 'mimes:png,jpg,jpeg', 'max:2048'
        ];
    }
}
