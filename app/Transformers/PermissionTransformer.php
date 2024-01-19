<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Spatie\Permission\Models\Permission;

class PermissionTransformer extends TransformerAbstract
{

    public function transform(Permission $permission)
    {
        return [
            'id' => $permission->id,
            'module_id' => $permission->module_id,
            'name' => $permission->name,
            'group' => $permission->group,
            'guard_name' => $permission->guard_name,
            'created_at' =>  $permission->created_at ? $permission->created_at->toFormattedDateString() : null,
            "updated_at" =>  $permission->updated_at ? $permission->updated_at->toFormattedDateString() : null,
        ];
    }
}
