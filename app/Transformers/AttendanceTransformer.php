<?php

namespace App\Transformers;

use App\Models\Attendance;
use League\Fractal\TransformerAbstract;

class AttendanceTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['leaveType', 'leaveRequest', 'attendanceActivities', 'user', 'attendanceStatus'];

    public function transform(Attendance $attendance)
    {
        return [
            'id' => $attendance->id,
            'user_id' => $attendance->user_id,
            'attendance_status_id' => $attendance->attendance_status_id,
            'leave_request_id' => $attendance->leave_request_id,
            'leave_type_id' => $attendance->leave_type_id,
            'date' => $attendance->date,
            'expected_duty_minutes' => $attendance->expected_duty_minutes,
            'first_check_in' => $attendance->first_check_in,
            'last_check_out' => $attendance->last_check_out,
            'total_worked_minutes' => $attendance->total_worked_minutes,
            'extra_less_duty_minutes' => $attendance->extra_less_duty_minutes,
            'on_leave' => (bool)$attendance->on_leave,
            'remarks' => $attendance->remarks,

        ];
    }

    public function includeLeaveType(Attendance $attendance)
    {
        if (isset($attendance->leaveType)) {
            return $this->item($attendance->leaveType, new LeaveTypeTransformer());
        }
    }

    public function includeLeaveRequest(Attendance $attendance)
    {
        if (isset($attendance->leaveRequest)) {
            return $this->item($attendance->leaveRequest, new LeaveRequestTransformer());
        }
    }

    public function includeUser(Attendance $attendance)
    {
        if (isset($attendance->user)) {
            return $this->item($attendance->user, new UserTransformer());
        }
    }

    public function includeAttendanceActivities(Attendance $attendance)
    {
        if (isset($attendance->attendanceActivities)) {
            return $this->collection($attendance->attendanceActivities, new AttendanceActivityTransformer());
        }
    }

    public function includeAttendanceStatus(Attendance $attendance)
    {
        if (isset($attendance->attendanceStatus)) {
            return $this->item($attendance->attendanceStatus, new AttendanceStatusTransformer());
        }
    }
}
