<?php

namespace App\Transformers\AdminPanel\Label;

use App\Models\User;
use App\Models\Label;
use App\Models\Category;
use App\Transformers\RoleTransformer;
use League\Fractal\TransformerAbstract;
use App\Transformers\DesignationTransformer;

class LabelTransformer extends TransformerAbstract
{


    public function transform(Label $label)
    {
        return [
            'id' => $label->id,
            'name' => $label->name

        ];
    }
}
