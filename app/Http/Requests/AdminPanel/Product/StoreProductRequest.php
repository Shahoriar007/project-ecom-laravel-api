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
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'description' => 'required|string',
            'offer_notice' => 'required|string',
            'price' => 'required|numeric|min:0',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'sku_code' => 'required|string|max:255',
            'is_flash_sale' => 'boolean',
            'is_new_arrival' => 'boolean',
            'is_hot_deal' => 'boolean',
            'is_for_you' => 'boolean',
            'category_id' => 'required|exists:categories,id',
            'product_images' => 'required|image|mimes:png,jpg,jpeg|max:2048'
            // Add any other validation rules as needed
            // 'image', 'mimes:png,jpg,jpeg', 'max:2048'
        ];
    }
}
