<?php

namespace App\Transformers\AdminPanel\FbPixel;

use App\Models\FbPixel;
use App\Models\User;
use App\Transformers\RoleTransformer;
use League\Fractal\TransformerAbstract;
use App\Transformers\DesignationTransformer;

class FbPixelTransformer extends TransformerAbstract
{


    public function transform(FbPixel $category)
    {
        return [
            'id' => $category->id,
            'pixel_code' => $category->pixel_code,
            'created_at' =>  $category->created_at,
            'created_by' => $category->created_by,
            'updated_by' => $category->updated_by,

        ];
    }
}
