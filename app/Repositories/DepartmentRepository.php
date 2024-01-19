<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Department;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DepartmentRepository
{

    private Department $model;

    private User $userModel;

    public function __construct(Department $model, User $userModel)
    {
        $this->model = $model;
        $this->userModel = $userModel;
    }

    public function index($show, $sort, $search)
    {
        $query  = $this->model->query()->withCount("users");

        if (!empty($search)) {
            $query->where('name', 'LIKE', "%$search%");
        }

        foreach ($sort as $key => $value) {
            $decode_data = json_decode($value);
            $query->orderBy($decode_data->field, $decode_data->type);
        }

        return $query->paginate($show);
    }


    public function findById($id)
    {
        try {
            return $this->model->findOrFail($id);
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }
    }

    public function store($validated)
    {
        try {
            return $this->model->create($validated);
        } catch (\Throwable $th) {
            throw new StoreResourceFailedException('Create Failed');
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
        $users_count = $this->model->where('id', $id)
            ->withCount(['users'])
            ->first()->users_count;

        if ($users_count > 0) {
            throw new DeleteResourceFailedException('Department Has User');
        }


        try {
            $data = $this->findById($id);
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }

        try {
            $data->delete();
        } catch (\Throwable $th) {
            throw new DeleteResourceFailedException('Delete Failed');
        }
    }


    public function syncUserToDepartment($request)
    {
        try {
            $department_id = null;
            if (!empty($request->department_id)) {
                $department = $this->findById($request->department_id);
                $department_id = $department->id;
            }
            $user = $this->userModel->findOrFail($request->user_id);
            $user->department_id =  $department_id;
            $user->save();
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }
    }
}
