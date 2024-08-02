<?php


namespace App\Repositories;


use App\Models\User;
use App\Models\UserActivity;
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
    private UserActivity $userActivity;

    public function __construct(User $model, Role $roleModel, UserActivity $userActivity)
    {
        $this->model = $model;

        $this->roleModel = $roleModel;
        $this->userActivity = $userActivity;
    }

    public function index($show, $sort, $search, $filterStatus)
    {

        $query  = $this->model->query();

        if (!empty($search)) {
            $query->where('name', 'LIKE', "%$search%");
        }

        if (!empty($filterStatus) &&  $filterStatus == 'active') {
            $query->where('status', 1);
        }
        else if(!empty($filterStatus) &&  $filterStatus == 'inactive'){
            $query->where('status', 0);
        }
        else if(!empty($filterStatus) &&  $filterStatus == 'trashed'){
            $query->onlyTrashed();
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

        if ($validated['status']) {
            try {
                $model->update([
                    'status' => $validated['status']
                ]);
            } catch (\Throwable $th) {
                throw new UpdateResourceFailedException('Update Failed');
            }
        }else{
            try {
                $model->update([
                    'status' => 0
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

        if($user->status == 1){
            throw new DeleteResourceFailedException('Delete Failed! First Inactivated the User');
        }else{
            try {
                $user->delete();
            } catch (\Throwable $th) {
                throw new DeleteResourceFailedException('Delete Failed');
            }
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

    public function updateStatus($id)
    {
        try {
            $data = $this->model->findOrFail($id);
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }

        try {
            $data->update([
                'status' => !$data->status
            ]);
            return $data;
        } catch (\Throwable $th) {
            throw new UpdateResourceFailedException('User Status Update Failed');
        }
    }

    public function restore($id)
    {

        try {
            $data = $this->model->onlyTrashed()->findOrFail($id);
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }

        try {
            $data =  $data->restore();
            return $data;
        } catch (\Throwable $th) {
            throw new UpdateResourceFailedException('Restore Failed');
        }
    }

    public function userActivityIndex($show, $sort, $search, $id, $rangeDate)
    {
        try {
            $query = $this->userActivity->query()->where('user_id', $id);


            if (!empty($rangeDate)) {

                if (strpos($rangeDate, ' to ') !== false) {
                    // $rangeDate is a range like "2024-03-04 to 2024-03-06"
                    $date = explode(' to ', $rangeDate);
                    // Add one day to the end date
                    $endDate = date('Y-m-d', strtotime($date[1] . ' +1 day'));
                    $query->whereBetween('created_at', [$date[0], $endDate]);
                } else {
                    // $rangeDate is a single date like "2024-03-04"
                    $query->whereDate('created_at', $rangeDate);
                }
            }

            $query->orderBy('order_id');


        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }

        return $query->paginate($show);
    }
}
