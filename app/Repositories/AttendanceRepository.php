<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\AttendanceActivity;
use App\Models\AttendanceStatus;
use App\Models\Setting;
use App\Services\Constant\AttendanceStatusService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class AttendanceRepository
{

    private Attendance $model;
    private AttendanceActivity $attendanceActivityModel;
    private Setting $settingModel;
    private AttendanceStatus $attendanceStatusModel;

    public function __construct(Attendance $model, AttendanceActivity $attendanceActivityModel, Setting $settingModel, AttendanceStatus $attendanceStatusModel)
    {
        $this->model = $model;
        $this->attendanceActivityModel = $attendanceActivityModel;
        $this->settingModel = $settingModel;
        $this->attendanceStatusModel = $attendanceStatusModel;
    }

    public function presentEmployees()
    {
        try {
            return $this->model->where('on_leave', false)->get();
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }
    }

    public function leaveEmployees()
    {
        try {
            return $this->model->where('on_leave', true)->get();
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }
    }

    public function all()
    {
        try {
            return $this->model->all();
        } catch (\Throwable $th) {
            throw new NotFoundHttpException('Not Found');
        }
    }

    public function index($show, $sort, $search)
    {
        $query  = $this->model->query();

        if (!empty($search)) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%");
            })->get();
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

    public function isCheckIn(): bool
    {
        $user = Auth::user();
        $today = Carbon::now()->format('Y-m-d');

        $todayAttendance = $user->attendances()->firstWhere('date', $today);

        if ($todayAttendance) {

            $attendanceActivity =  $todayAttendance->attendanceActivities()
                ->where('date', $today)
                ->latest()->first();

            if ($attendanceActivity->check_out) {

                return false;
            } else {
                return true;
            }
        }
        return false;
    }


    public function checkIn()
    {
        $user = Auth::user();
        $today = Carbon::now()->format('Y-m-d');
        $time = Carbon::now()->format('H:i:s');

        $todayAttendance = $user->attendances()->firstWhere('date', $today);

        if (!$todayAttendance) {

            $check_in_out_time = $this->settingModel->select('check_in_out_time')->take(1)->first()->check_in_out_time;
            $check_in_time = $check_in_out_time[0]['value'];
            $check_out_time = $check_in_out_time[1]['value'];
            $expected_duty_minutes = diffHoursToMinutes($check_in_time, $check_out_time);

            $attendance_status_id = null;
            if (diffTime($check_in_time, $time) >= 0) {
                $attendanceStatus = $this->attendanceStatusModel->firstWhere('name', AttendanceStatusService::PRESENT);
                $attendance_status_id = $attendanceStatus->id;
            } elseif (diffTime($check_in_time, $time) < 0) {
                $attendanceStatus = $this->attendanceStatusModel->firstWhere('name', AttendanceStatusService::DELAY);
                $attendance_status_id = $attendanceStatus->id;
            } else {
                $attendance_status_id = null;
            }

            try {
                DB::transaction(function () use ($user, $today, $time, $expected_duty_minutes, $attendance_status_id) {
                    $attendance   = $this->model->create([
                        'user_id' => $user->id,
                        'attendance_status_id' => $attendance_status_id,
                        'date' => $today,
                        'first_check_in' => $time,
                        'expected_duty_minutes' => $expected_duty_minutes,
                    ]);

                    $this->attendanceActivityModel->create([
                        'attendance_id' => $attendance->id,
                        'date' => $today,
                        'check_in' => $time,
                    ]);
                });
            } catch (\Throwable $th) {
                throw new  StoreResourceFailedException('Check In Failed');
            }
        } else {

            $latestAttendanceActivity =  $todayAttendance->attendanceActivities()
                ->where('date', $today)
                ->latest()->first();

            if (!$latestAttendanceActivity->check_out) {
                throw new  StoreResourceFailedException('Need Check Out');
            }

            try {
                $this->attendanceActivityModel->create([
                    'attendance_id' => $todayAttendance->id,
                    'date' => $today,
                    'check_in' => $time,
                ]);
            } catch (\Throwable $th) {
                throw new  StoreResourceFailedException('Check In Failed');
            }
        }
    }

    public function checkOut()
    {
        $user = Auth::user();
        $today = Carbon::now()->format('Y-m-d');
        $time = Carbon::now()->format('H:i:s');

        $todayAttendance = $user->attendances()
            ->firstWhere('date', $today);

        if (!$todayAttendance) {
            throw new NotFoundHttpException('Not Found');
        }

        $latestAttendanceActivity =  $todayAttendance->attendanceActivities()
            ->where('date', $today)
            ->latest()->first();

        if ($latestAttendanceActivity->check_out) {
            throw new  StoreResourceFailedException('Already Check Out');
        }

        try {

            $worked_minutes = diffHoursToMinutes($latestAttendanceActivity->check_in, $time);

            $oldestAttendanceActivity =  $todayAttendance->attendanceActivities()
                ->where('date', $today)
                ->oldest()->first();

            $check_in_out_time = $this->settingModel->select('check_in_out_time')->take(1)->first()->check_in_out_time;
            $check_in_time = $check_in_out_time[0]['value'];
            $check_out_time = $check_in_out_time[1]['value'];

            $attendance_status_id = null;
            if (diffTime($check_out_time, $time) > 0) {
                $attendanceStatus = $this->attendanceStatusModel->firstWhere('name', AttendanceStatusService::EARLY_CHECK_OUT);
                $attendance_status_id = $attendanceStatus->id;
            } elseif (diffTime($check_in_time, $oldestAttendanceActivity->check_in) >= 0) {
                $attendanceStatus = $this->attendanceStatusModel->firstWhere('name', AttendanceStatusService::PRESENT);
                $attendance_status_id = $attendanceStatus->id;
            } elseif (diffTime($check_in_time,  $oldestAttendanceActivity->check_in) < 0) {
                $attendanceStatus = $this->attendanceStatusModel->firstWhere('name', AttendanceStatusService::DELAY);
                $attendance_status_id = $attendanceStatus->id;
            } else {
                $attendance_status_id = null;
            }

            DB::transaction(function () use ($todayAttendance, $latestAttendanceActivity, $time, $worked_minutes, $attendance_status_id) {
                $latestAttendanceActivity->update([
                    'check_out' => $time,
                    'worked_minutes' => $worked_minutes,
                ]);

                $total_worked_minutes = $todayAttendance->total_worked_minutes + $worked_minutes;
                $extra_less_duty_minutes =  $total_worked_minutes - $todayAttendance->expected_duty_minutes;

                $todayAttendance->update([
                    'attendance_status_id' => $attendance_status_id,
                    'last_check_out' => $time,
                    'total_worked_minutes' => $total_worked_minutes,
                    'extra_less_duty_minutes' => $extra_less_duty_minutes,
                ]);
            });
        } catch (\Throwable $th) {
            throw new  UpdateResourceFailedException('Check Out Failed');
        }
    }
}
