<?php

namespace App\Repositories;

use App\Models\LeaveType;
use App\Models\User;
use Dingo\Api\Auth\Auth;
use Illuminate\Support\Facades\DB;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class LeaveTypeRepository
{

    private LeaveType $model;
    private User $userModel;

    public function __construct(LeaveType $model, User $userModel)
    {
        $this->model = $model;
        $this->userModel = $userModel;
    }

    public function all()
    {
        try {
            return $this->model->all();
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }
    }

    public function index()
    {
        try {
            return $this->model->withCount('leaveRequests')->get();
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

    public function store($validated)
    {

        try {
            $model = $this->model->create($validated);

            return $model;
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
        $leave_requests_count = $this->model->where('id', $id)
            ->withCount(['leaveRequests'])
            ->first()->leave_requests_count;

        if ($leave_requests_count > 0) {
            throw new DeleteResourceFailedException('Leave Type Has Leave Request');
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

    public function eligibleAll()
    {
        try {
            $gender = auth()->user()->gender;
            $gender_data = $this->model->where(['gender' => $gender])->get();

            $employee_type_id = @auth()->user()->designation->employee_type_id;

            if ($employee_type_id) {
                $data = $this->model->where([
                    'employee_type_id' => $employee_type_id,
                ])->get();

                $gender_data = $gender_data->merge($data);
            }

            $data = $gender_data->unique();
            return $data;
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }
    }
}
