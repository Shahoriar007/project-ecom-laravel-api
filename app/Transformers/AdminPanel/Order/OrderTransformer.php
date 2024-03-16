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
            'created_at' => $order->created_at,
            'customer' => $order->customer,
            'products' => $this->transformProducts($order->products),

        ];
    }

    protected function transformProducts($products)
    {
        $transformedProducts = [];

        foreach ($products as $product) {
            $transformedProducts[] = [
                'id' => $product->id,
            'name' => $product->name,
            'status' => (bool)$product->status,
            'slug' => $product->slug,
            'price' => $product->price,
            'sku' => $product->sku,
            'stock' => $product->stock,
            'short_description' => $product->short_description,
            'offer_notice' => $product->offer_notice,
            'sale_price' => $product->sale_price,
            'sale_count' => $product->sale_count,
            'ratings' => $product->ratings,
            'is_hot' => (bool)$product->is_hot,
            'is_sale' => (bool) $product->is_sale,
            'is_new' => (bool)$product->is_new,
            'is_out_of_stock' => (bool)$product->is_out_of_stock,
            'is_for_you' => (bool) $product->is_for_you,
            'release_date' => $product->release_date,
            'developer' => $product->developer,
            'publisher' => $product->publisher,
            'rated' => (bool)$product->rated,
            'until' => $product->until,
            'labels' => $product->labels,
            'product_categories' => $product->categories,
            'large_pictures' => $product->getMedia('large_pictures'),
            'small_pictures' =>  $product->getMedia('large_pictures'),
            'category_id' => $product->category_id,
            'sub_category_id' => $product->sub_category_id,
            'child_category_id' => $product->child_category_id,
            'video_link' => $product->video_link,

            'created_by' => $product->created_by,
            'updated_by' => $product->updated_by,
            'created_at' =>  $product->created_at,
            'updated_at' =>  $product->updated_at,
                'pivot' => [
                    'order_id' => $product->pivot->order_id,
                    'product_id' => $product->pivot->product_id,
                    'quantity' => $product->pivot->quantity,
                ],
            ];
        }

        return $transformedProducts;
    }
}
