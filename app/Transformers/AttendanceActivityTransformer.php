<?php

namespace App\Transformers;

use App\Models\AttendanceActivity;
use League\Fractal\TransformerAbstract;

class AttendanceActivityTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['attendances'];

    public function transform(AttendanceActivity $attendanceActivity)
    {
        return [
            'id' => $attendanceActivity->id,
            'attendance_id' => $attendanceActivity->attendance_id,
            'date' => $attendanceActivity->date,
            'check_in' => $attendanceActivity->check_in,
            'check_out' => $attendanceActivity->check_out,
            'worked_minutes' => $attendanceActivity->worked_minutes,

        ];
    }

    public function includeAttendances(AttendanceActivity $attendanceActivity)
    {
        if (isset($attendanceActivity->attendances)) {
            return $this->item($attendanceActivity->attendances, new AttendanceTransformer());
        }
    }
}
