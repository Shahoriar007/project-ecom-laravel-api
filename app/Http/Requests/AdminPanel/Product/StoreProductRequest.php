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
            'price' => 'required|numeric|min:0',
            'sku' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'short_description' => 'required|string',
            'offer_notice' => 'required|string',
            'sale_price' => 'required|numeric|min:0',
            'status' => 'required|boolean',
            'is_hot' => 'required|boolean',
            'is_sale' => 'required|boolean',
            'is_new' => 'required|boolean',
            'is_for_you' => 'required|boolean',
            'category_id' => 'required|array',
            'category_id*' => ['required', 'exists:categories,id'],
            'large_pictures' => 'required|array',
            'large_pictures*' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'labels' => 'required|array',
            'labels*' => 'required|string',

        ];
    }
}
