<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Spatie\Permission\Models\Role;

class RoleTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['users', 'permissions'];

    public function transform(Role $role)
    {
        return [
            'id' => $role->id,
            'name' => $role->name,

            'created_at' =>  $role->created_at ? $role->created_at->toFormattedDateString() : null,
            'users_count' => $role->users_count,
        ];
    }

    public function includeUsers(Role $role)
    {
        if (isset($role->users)) {
            return $this->collection($role->users, new UserTransformer());
        }
    }

    public function includePermissions(Role $role)
    {
        if (isset($role->permissions)) {
            return $this->collection($role->permissions, new PermissionTransformer());
        }
    }
}
