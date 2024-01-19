<?php

namespace App\Transformers;

use App\Models\Designation;
use League\Fractal\TransformerAbstract;

class DesignationTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['users', 'employeeType'];

    public function transform(Designation $designation)
    {
        return [
            'id' => $designation->id,
            'name' => $designation->name,
            'description' => $designation->description,
            'employee_type_id' => $designation->employee_type_id,
            'users_count' => $designation->users_count,
            'created_at' =>  $designation->created_at ? $designation->created_at->toFormattedDateString() : null,
        ];
    }

    public function includeUsers(Designation $designation)
    {
        if (isset($designation->users)) {
            return $this->collection($designation->users, new UserTransformer());
        }
    }

    public function includeEmployeeType(Designation $designation)
    {
        if (isset($designation->employeeType)) {
            return $this->item($designation->employeeType, new EmployeeTypeTransformer());
        }
    }
}
