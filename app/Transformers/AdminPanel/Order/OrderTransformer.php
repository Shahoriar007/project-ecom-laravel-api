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
            'quantity' => $order->quantity,
            'delivery_charge' => $order->delivery_charge,
            'vat' => $order->vat,
            'tax' => $order->delivery_charge,
            'discount' => $order->discount,
            'total_amount' => $order->total_amount,
            'delivery_address' => $order->delivery_address,
            'payment_method' => $order->payment_method,
            'status' => $order->status,
            'customer_id' => $order->customer_id,
            'created_at' =>  $order->created_at,

        ];
    }
}
