<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Module;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Services\Constant\RolesService;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RoleRepository
{

    private Role $model;

    private User $userModel;

    private Module $moduleModel;

    public function __construct(Role $model, User $userModel, Module $moduleModel)
    {
        $this->model = $model;
        $this->userModel = $userModel;
        $this->moduleModel = $moduleModel;
    }

    public function index($show, $sort, $search)
    {

        $query  = $this->model->query()->withCount('users');

        if (!empty($search)) {
            $query->where('name', 'LIKE', "%$search%");
        }

        foreach ($sort as $key => $value) {
            $decode_data = json_decode($value);
            $query->orderBy($decode_data->field, $decode_data->type);
        }

        return $query->paginate($show);
    }

    public function all()
    {
        try {
            return $this->model->all();
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }
    }

    public function findById($id)
    {
        try {
            return $this->model->findOrFail($id);
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }
    }

    public function create($validated)
    {
        return $this->model->create($validated);
    }

    public function store($validated)
    {
        try {
            $model = $this->model->create($validated);

            return $model;
        } catch (\Throwable $th) {
            throw new StoreResourceFailedException('Create Failed');
        }
    }

    public function show($id)
    {
        try {
            return $this->findById($id);
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }
    }

    public function update($id, $validated)
    {
        try {
            $model = $this->findById($id);
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }

        try {
            $model->update($validated);
            return $model->fresh();
        } catch (\Throwable $th) {
            throw new UpdateResourceFailedException('Update Failed');
        }
    }

    public function delete($id)
    {
        try {
            $role = $this->findById($id);
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }

        if ($role->name == RolesService::ADMIN) {
            throw new DeleteResourceFailedException('Not Delete Admin');
        }

        $users_count = $this->userModel->role($role->name)->count();
        if ($users_count > 0) {
            throw new DeleteResourceFailedException('Role Has User');
        }

        try {
            $role->delete();
        } catch (\Throwable $th) {
            throw new DeleteResourceFailedException('Not Deleted');
        }
    }

    public function getModulesPermissions()
    {
        try {
            $modules = $this->moduleModel->get();

            return $modules;
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }
    }

    public function updatePermission($attach, $permission_id, $id)
    {
        try {
            $role = $this->findById($id);
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }

        try {
            if ($attach) {
                $role->givePermissionTo($permission_id);
            } else {
                $role->revokePermissionTo($permission_id);
            }
        } catch (\Throwable $th) {
            throw new  UpdateResourceFailedException('Not Updated');
        }

        return  $role->fresh();
    }

    public function priorityWiseRoles()
    {
        try {
            $user = Auth::user();
            $users_roles_priority = @$user->load(['roles'])->roles[0]->priority;
            $roles  = $this->all();

            $filtered = $roles->filter(function ($value, $key) use ($users_roles_priority) {
                return $value->priority >=  $users_roles_priority;
            })->values()->all();

            return  collect($filtered);
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }
    }
}
