<?php

namespace App\Transformers\AdminPanel\Order;

use App\Models\Order;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{


    public function transform(Order $order)
    {
        return [
            'id' => $order->id,
            'delivery_charge' => $order->delivery_charge,
            'total_price' => $order->total_price,
            'company_name' => $order->company_name,
            'country_name' => $order->country_name,
            'city_name' => $order->city_name,
            'detail_address' => $order->detail_address,
            'order_notes' => $order->order_notes,
            'payment_method' => $order->payment_method,
            'status' => $order->status,
            'customer' => $order->customer,
            'products' => $order->products,

        ];
    }
}
