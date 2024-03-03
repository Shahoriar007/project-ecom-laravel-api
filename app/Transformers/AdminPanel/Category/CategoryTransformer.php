<?php

namespace App\Transformers\AdminPanel\Category;

use App\Models\User;
use App\Models\Category;
use App\Transformers\RoleTransformer;
use League\Fractal\TransformerAbstract;
use App\Transformers\DesignationTransformer;
use App\Transformers\AdminPanel\SubCategory\SubCategoryTransformer;
use App\Transformers\AdminPanel\ChildCategory\ChildCategoryTransformer;

class CategoryTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'sub_categories', // Include subcategories
        'child_categories' // Include child categories
    ];


    public function transform(Category $category)
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'status' => (bool)$category->status,
            'is_featured' => (bool)$category->is_featured,
            'description' => $category->description,
            'parent_name' => $category->parent_name,
            'disabled' => (bool)$category->disabled,
            'category_image' => $category->getFirstMediaUrl('category_image'),
            'created_at' =>  $category->created_at,
            'created_by' => $category->created_by,
            'updated_by' => $category->updated_by,
            'sub_categories' => $category->subCategories,
            // 'child_categories' => $this->collection($category->childCategories, new ChildCategoryTransformer),

        ];
    }

    public function includeSubCategories(Category $category)
    {
        $subCategories = $category->subCategories; // Assuming this returns a collection
        return $this->collection($subCategories, new SubCategoryTransformer);
    }

    public function includeChildCategories(Category $category)
    {
        $childCategories = $category->childCategories; // Assuming this returns a collection
        return $this->collection($childCategories, new ChildCategoryTransformer);
    }
}
