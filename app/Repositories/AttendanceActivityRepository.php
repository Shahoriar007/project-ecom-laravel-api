<?php

namespace App\Repositories;

use App\Models\Attendance;
use App\Models\AttendanceActivity;
use Illuminate\Support\Facades\DB;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class AttendanceActivityRepository
{

    private AttendanceActivity $model;
    private Attendance $attendanceModel;

    public function __construct(AttendanceActivity $model, Attendance $attendanceModel)
    {
        $this->model = $model;
        $this->attendanceModel = $attendanceModel;
    }

    public function all()
    {
        return $this->model->all();
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

            DB::transaction(function () use ($model, $validated) {
                $old_worked_minutes = $model->worked_minutes;

                // update attendance activity
                $worked_minutes = diffHoursToMinutes($validated['check_in'], $validated['check_out']);

                $model->update([
                    ...$validated,
                    'worked_minutes' => $worked_minutes
                ]);

                // update attendance total worked  minutes

                $latest_worked_minutes =  $worked_minutes -  $old_worked_minutes;

                $attendance =  $this->attendanceModel->firstWhere([
                    'id' => $model->attendance_id,
                ]);

                if ($latest_worked_minutes >= 0) {
                    $attendance->update([
                        'total_worked_minutes' => $attendance->total_worked_minutes + $latest_worked_minutes,
                    ]);
                } else {
                    $attendance->update([
                        'total_worked_minutes' => $attendance->total_worked_minutes - abs($latest_worked_minutes),
                    ]);
                }

                //first_check_in update
                // get oldest attendance activity
                $oldestAttendanceActivity =  $this->model
                    ->where([
                        'attendance_id' => $model->attendance_id,
                        'date' => $model->date
                    ])->where('date', $model->date)
                    ->oldest()->first();

                // update attendance
                if ($model->id === $oldestAttendanceActivity->id) {
                    $this->attendanceModel->where([
                        'id' => $oldestAttendanceActivity->attendance_id,
                    ])->update([
                        'first_check_in' => $validated['check_in'],
                    ]);
                }

                // last_check_out update
                // get latest attendance activity
                $latestAttendanceActivity =  $this->model
                    ->where([
                        'attendance_id' => $model->attendance_id,
                        'date' => $model->date
                    ])
                    ->latest()->first();

                // update attendance
                if ($model->id === $latestAttendanceActivity->id) {
                    $this->attendanceModel->where([
                        'id' => $latestAttendanceActivity->attendance_id,
                    ])->update([
                        'last_check_out' => $validated['check_out'],
                    ]);
                }
            });

            return $model->fresh();
        } catch (\Throwable $th) {
            throw new HttpException('Update Failed');
        }
    }

    public function delete($id)
    {

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
}
