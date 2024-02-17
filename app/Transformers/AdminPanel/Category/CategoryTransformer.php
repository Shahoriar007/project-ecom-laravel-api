<?php

namespace App\Transformers\AdminPanel\Category;

use App\Models\Category;
use App\Models\User;
use App\Transformers\RoleTransformer;
use League\Fractal\TransformerAbstract;
use App\Transformers\DesignationTransformer;

class CategoryTransformer extends TransformerAbstract
{


    public function transform(Category $category)
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'status' => (bool)$category->status,
            'description' => $category->description,
            'parent_name' => $category->parent_name,
            'disabled' => (bool)$category->disabled,
            'category_image' => $category->getFirstMediaUrl('category_image'),
            'created_at' =>  $category->created_at,
            'created_by' => $category->created_by,
            'updated_by' => $category->updated_by,

        ];
    }
}
