<?php

namespace App\Http\Requests\AdminPanel\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:255',
            'companyName' => 'nullable|string|max:255',
            'countryName' => 'required|string|max:255',
            'cityName' => 'required|string|max:255',
            'detailAddress' => 'required|string|max:255',
            'orderNotes' => 'nullable|string',
            'paymentMethod' => 'nullable|string|max:255',
            'status' => 'nullable',
            'products' => 'required|array',
            'products.*.id' => 'required|integer|exists:products,id',
            'products.*.qty' => 'required|integer|min:1',
            'deliveryCharge' => 'required|numeric',
            'vat' => 'nullable|numeric',
            'tax' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'totalPrice' => 'required|numeric',

        ];
    }
}
