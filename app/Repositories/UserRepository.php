<?php


namespace App\Repositories;


use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserRepository
{

    private User $model;

    private Role $roleModel;

    public function __construct(User $model, Role $roleModel)
    {
        $this->model = $model;

        $this->roleModel = $roleModel;
    }

    public function index($show, $sort, $search)
    {

        $query  = $this->model->query();

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
        return  DB::transaction(function () use ($validated) {
            try {
                $model = $this->model->create($validated);
            } catch (\Throwable $th) {
                throw new StoreResourceFailedException('Create Failed');
            }

            try {
                $role = $this->roleModel->findById($validated['role_id']);

                $model->assignRole($role);

                return $model;
            } catch (\Throwable $th) {
                throw new NotFoundHttpException('Not Found');
            }
        });
    }

    public function update($id, $validated)
    {
        try {
            $model = $this->findById($id);
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }

        if (!empty($validated['name'])) {
            try {
                $model->update([
                    'name' => $validated['name']
                ]);
            } catch (\Throwable $th) {
                throw new UpdateResourceFailedException('Update Failed');
            }
        }

        if (!empty($validated['email'])) {
            try {
                $model->update([
                    'email' => $validated['email']
                ]);
            } catch (\Throwable $th) {
                throw new UpdateResourceFailedException('Update Failed');
            }
        }

        if (!empty($validated['status'])) {
            try {
                $model->update([
                    'status' => $validated['status']
                ]);
            } catch (\Throwable $th) {
                throw new UpdateResourceFailedException('Update Failed');
            }
        }

        if (!empty($validated['password'])) {
            try {
                $model->update([
                    'password' => $validated['password']
                ]);
            } catch (\Throwable $th) {
                throw new UpdateResourceFailedException('Update Failed');
            }
        }

        if (!empty($validated['designation_id'])) {
            try {
                $model->update([
                    'designation_id' => $validated['designation_id']
                ]);
            } catch (\Throwable $th) {
                throw new UpdateResourceFailedException('Update Failed');
            }
        }

        if (!empty($validated['employee_type_id'])) {
            try {
                $model->update([
                    'employee_type_id' => $validated['employee_type_id']
                ]);
            } catch (\Throwable $th) {
                throw new UpdateResourceFailedException('Update Failed');
            }
        }

        if (!empty($validated['gender'])) {
            try {
                $model->update([
                    'gender' => $validated['gender']
                ]);
            } catch (\Throwable $th) {
                throw new UpdateResourceFailedException('Update Failed');
            }
        }

        if (!empty($validated['role_id'])) {
            try {
                $role = $this->roleModel->findById($validated['role_id']);

                $model->syncRoles($role);

                return $model;
            } catch (\Throwable $th) {
                throw new NotFoundHttpException('Not Found');
            }
        }



        return $model->fresh();
    }

    public function delete($id)
    {
        try {
            $user = $this->findById($id);
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }

        try {
            $user->delete();
        } catch (\Throwable $th) {
            throw new DeleteResourceFailedException('Delete Failed');
        }
    }

    public function departmentUsers($show, $sort, $search, $id)
    {

        $query  = $this->model->query()->where([
            "department_id" => $id
        ]);

        if (!empty($search)) {
            $query->where('name', 'LIKE', "%$search%");
        }

        foreach ($sort as $key => $value) {
            $decode_data = json_decode($value);
            $query->orderBy($decode_data->field, $decode_data->type);
        }

        return $query->paginate($show);
    }

    public function searchUsers($search, $id)
    {
        $query = $this->model->query()->where('department_id', '!=', $id)->orWhereNull('department_id');
        $query = $query->where('name', 'LIKE', "%$search%")->get();
        return $query;
    }
}
