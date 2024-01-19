<?php

namespace App\Transformers;

use App\Models\Department;
use League\Fractal\TransformerAbstract;

class DepartmentTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['head', 'division', 'users'];

    public function transform(Department $department)
    {
        return [
            'id' => $department->id,
            'name' => $department->name,
            'division_id' => $department->division_id,
            'head_id' => $department->head_id,
            'created_at' =>  $department->created_at ? $department->created_at->toFormattedDateString() : null,
            'users_count' => $department->users_count,
        ];
    }

    public function includeHead(Department $department)
    {
        if (isset($department->head)) {
            return $this->item($department->head, new UserTransformer());
        }
    }

    public function includeDivision(Department $department)
    {
        if (isset($department->division)) {
            return $this->item($department->division, new DivisionTransformer());
        }
    }


    public function includeUsers(Department $department)
    {
        if (isset($department->users)) {
            return $this->collection($department->users, new UserTransformer());
        }
    }
}
