<?php

namespace App\Transformers;

use App\Models\EmployeeType;
use League\Fractal\TransformerAbstract;

class EmployeeTypeTransformer extends TransformerAbstract
{

    // protected $availableIncludes = [];

    public function transform(EmployeeType $employeeType)
    {
        return [
            'id' => $employeeType->id,
            'name' => $employeeType->name,
            'description' => $employeeType->description,
            'created_at' =>  $employeeType->created_at ? $employeeType->created_at->toFormattedDateString() : null,
        ];
    }
}
