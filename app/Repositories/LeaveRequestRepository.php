<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\AttendanceStatus;
use Illuminate\Support\Facades\DB;
use App\Services\Constant\AttendanceStatusService;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class LeaveRequestRepository
{

    private LeaveRequest $model;
    private Attendance $attendanceModel;
    private AttendanceStatus $attendanceStatusModel;

    public function __construct(LeaveRequest $model, Attendance $attendanceModel,   AttendanceStatus $attendanceStatusModel)
    {
        $this->model = $model;
        $this->attendanceModel = $attendanceModel;
        $this->attendanceStatusModel = $attendanceStatusModel;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function index($show, $sort)
    {
        $query  = $this->model->query();

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
            return $this->model->create([
                'user_id' => auth()->user()->id,
                ...$validated
            ]);
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

        if ($model->status) {
            throw new  UpdateResourceFailedException('Approved Leave Request Does Not Update');
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
            $model = $this->findById($id);
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }

        if ($model->status) {
            throw new  DeleteResourceFailedException('Approved Leave Request Does Not Delete');
        }

        try {
            $model->delete();
        } catch (\Throwable $th) {
            throw new DeleteResourceFailedException('Delete Failed');
        }
    }

    public function approve($id)
    {

        try {
            $model = $this->findById($id);
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }

        if ($model->status) {
            throw new  UpdateResourceFailedException('Already Approved');
        }

        // date wise attendance create

        $date_time = Carbon::now()->format('Y-m-d\TH:i:s.Z\Z');

        $diff_date = diffDate($model->start_date, $model->end_date);

        // get attendance status
        $attendanceStatus = $this->attendanceStatusModel->firstWhere('name', AttendanceStatusService::LEAVE);
        $attendance_status_id = $attendanceStatus->id;

        $leave_date_attendance = [];
        for ($i = 0; $i <= $diff_date; $i++) {

            if ($i === 0) {
                $date = strtotime($model->start_date);
            } else {
                $date = strtotime("+$i day", strtotime($model->start_date));
            }

            $date = date("Y-m-d", $date);

            $leave_date_attendance[$i] = [
                'user_id' => auth()->user()->id,
                'attendance_status_id' => $attendance_status_id,
                'date' => $date,
                'on_leave' => true,
                'leave_request_id' => $model->id,
                'leave_type_id' => $model->leave_type_id,
                'created_at' => $date_time,
                'updated_at' => $date_time,
            ];
        }

        try {

            DB::transaction(function () use ($model, $leave_date_attendance) {
                $model->update([
                    'status' => true
                ]);

                $this->attendanceModel->insert($leave_date_attendance);
            });
        } catch (\Throwable $th) {
            throw new  UpdateResourceFailedException('Update Failed');
        }
    }
}
