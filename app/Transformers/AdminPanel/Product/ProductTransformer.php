<?php

namespace App\Transformers\AdminPanel\Product;

use App\Models\Product;

use League\Fractal\TransformerAbstract;


class ProductTransformer extends TransformerAbstract
{


    public function transform(Product $product)
    {
        return [
            // 'id' => $category->id,
            // 'name' => $category->name,
            // 'status' => $category->status,
            // 'image_url' => $category->getFirstMediaUrl('user-avatar', 'avatar'),
            // 'created_at' =>  $category->created_at
        ];
    }
}
