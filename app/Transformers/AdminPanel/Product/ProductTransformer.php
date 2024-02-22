<?php

namespace App\Transformers\AdminPanel\Product;

use App\Models\Product;
use Intervention\Image\Facades\Image;
use League\Fractal\TransformerAbstract;
use App\Transformers\AdminPanel\Label\LabelTransformer;


class ProductTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['labels'];

    public function transform(Product $product)
    {


        return [
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
            'created_by' => $product->created_by,
            'updated_by' => $product->updated_by,
            'created_at' =>  $product->created_at,
            'updated_at' =>  $product->updated_at,
        ];
    }

    public function includeLabels(Product $product)
    {
        if (isset($product->labels)) {
            return $this->collection($product->labels, new LabelTransformer());
        }
    }
}
