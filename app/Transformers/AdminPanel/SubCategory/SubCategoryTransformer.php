<?php

namespace App\Transformers\AdminPanel\SubCategory;


use App\Models\SubCategory;
use League\Fractal\TransformerAbstract;


class SubCategoryTransformer extends TransformerAbstract
{


    public function transform(SubCategory $subCategory)
    {
        return [
            'id' => $subCategory->id,
            'name' => $subCategory->name,
            'slug' => $subCategory->slug,
            'status' => (bool)$subCategory->status,
            'description' => $subCategory->description,
            'is_featured' => (bool)$subCategory->disabled,
            'sub_category_image' => $subCategory->getFirstMediaUrl('sub_category_image'),
            'category_id' =>  $subCategory->category_id,
            'created_at' =>  $subCategory->created_at,
            'created_by' => $subCategory->created_by,
            'updated_by' => $subCategory->updated_by,

        ];
    }
}
