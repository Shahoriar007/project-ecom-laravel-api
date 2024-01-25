<?php

namespace App\Transformers\AdminPanel\Product;

use App\Models\Product;

use League\Fractal\TransformerAbstract;


class ProductTransformer extends TransformerAbstract
{


    public function transform(Product $product)
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'status' => $product->status,
            'slug' => $product->slug,
            'description' => $product->description,
            'product_image_urls' => $product->getMedia('product_images'),
            'offer_notice' => $product->offer_notice,
            'price' => $product->price,
            'regular_price' => $product->regular_price,
            'sale_price' => $product->sale_price,
            'quantity' => $product->quantity,
            'sku_code' => $product->sku_code,
            'is_flash_sale' => $product->is_flash_sale,
            'offer_notice' => $product->offer_notice,
            'is_hot_deal' => $product->is_hot_deal,
            'is_new_arrival' => $product->is_new_arrival,
            'is_for_you' => $product->is_for_you,
            'category_id' => $product->category_id,
            'created_by' => $product->created_by,
            'updated_by' => $product->updated_by,
            'created_at' =>  $product->created_at,
            'updated_at' =>  $product->updated_at,
        ];
    }
}
