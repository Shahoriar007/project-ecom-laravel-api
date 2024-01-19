<?php

namespace App\Transformers;

use App\Models\Division;
use League\Fractal\TransformerAbstract;

class DivisionTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['head', 'departments'];

    public function transform(Division $division)
    {
        return [
            'id' => $division->id,
            'name' => $division->name,
            'head_id' => $division->head_id,
            'created_at' =>  $division->created_at ? $division->created_at->toFormattedDateString() : null,
            'departments_count' => $division->departments_count,
        ];
    }

    public function includeHead(Division $division)
    {
        if (isset($division->head)) {
            return $this->item($division->head, new UserTransformer());
        }
    }

    public function includeDepartments(Division $division)
    {
        if (isset($division->departments)) {
            return $this->collection($division->departments, new DepartmentTransformer());
        }
    }
}
