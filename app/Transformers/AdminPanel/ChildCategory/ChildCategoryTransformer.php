<?php

namespace App\Transformers\AdminPanel\ChildCategory;


use App\Models\ChildCategory;
use League\Fractal\TransformerAbstract;


class ChildCategoryTransformer extends TransformerAbstract
{


    public function transform(ChildCategory $childCategory)
    {
        return [
            'id' => $childCategory->id,
            'name' => $childCategory->name,
            'slug' => $childCategory->slug,
            'status' => (bool)$childCategory->status,
            'description' => $childCategory->description,
            'is_featured' => (bool)$childCategory->disabled,
            'sub_category_image' => $childCategory->getFirstMediaUrl('sub_category_image'),
            'sub_category_id' =>  $childCategory->sub_category_id,
            'created_at' =>  $childCategory->created_at,
            'created_by' => $childCategory->created_by,
            'updated_by' => $childCategory->updated_by,

        ];
    }
}
