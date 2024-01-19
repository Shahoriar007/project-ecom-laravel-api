<?php

namespace App\Transformers;

use App\Models\User;
use App\Transformers\RoleTransformer;
use League\Fractal\TransformerAbstract;
use App\Transformers\DesignationTransformer;

class UserTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['department', 'designation', 'permissions', 'roles', 'leaveRequests', 'attendances'];

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

    // public function includeDivisionHead(User $user)
    // {
    //     if (isset($user->divisionHead)) {
    //         return $this->item($user->divisionHead, new DivisionTransformer());
    //     }
    // }

    // public function includeDepartmentHead(User $user)
    // {
    //     if (isset($user->departmentHead)) {
    //         return $this->item($user->departmentHead, new DepartmentTransformer());
    //     }
    // }


    // public function includeUserDepartment(User $user)
    // {
    //     if (isset($user->userDepartment)) {
    //         return $this->item($user->userDepartment, new DepartmentTransformer());
    //     }
    // }

    public function includeDepartment(User $user)
    {
        if (isset($user->department)) {
            return $this->item($user->department, new DepartmentTransformer());
        }
    }

    public function includeDesignation(User $user)
    {
        if (isset($user->designation)) {
            return $this->item($user->designation, new DesignationTransformer());
        }
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

    public function includeLeaveRequests(User $user)
    {
        if (isset($user->leaveRequests)) {
            return $this->collection($user->leaveRequests, new LeaveRequestTransformer());
        }
    }

    public function includeAttendances(User $user)
    {
        if (isset($user->attendances)) {
            return $this->collection($user->attendances, new AttendanceTransformer());
        }
    }
}
