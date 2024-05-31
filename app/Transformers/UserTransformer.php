<?php

namespace App\Transformers;

use App\Models\User;
use App\Transformers\RoleTransformer;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['permissions', 'roles'];

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'status' => $user->status,
            'avatar' => $user->getFirstMediaUrl('user-avatar', 'avatar'),
            'department_id' => $user->department_id,
            'designation_id' => $user->designation_id,
            'employee_type_id' => $user->employee_type_id,
            'gender' => $user->gender,
            'created_at' =>  $user->created_at ? $user->created_at->toFormattedDateString() : null,
        ];
    }


    public function includePermissions(User $user)
    {
        if (isset($user->permissions)) {
            return $this->collection($user->getAllPermissions(), new PermissionTransformer());
        }
    }

    public function includeRoles(User $user)
    {
        if (isset($user->roles)) {
            return $this->collection($user->roles, new RoleTransformer());
        }
    }


}
