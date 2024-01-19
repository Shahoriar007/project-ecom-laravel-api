<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'attendance_status_id',
        'first_check_in',
        'last_check_out',
        'expected_duty_minutes',
        'total_worked_minutes',
        'extra_less_duty_minutes',
        'leave_request_id',
        'leave_type_id',
        'on_leave',
        'remarks'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function attendanceActivities()
    {
        return $this->hasMany(AttendanceActivity::class, 'attendance_id', 'id');
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id', 'id');
    }

    public function leaveRequest()
    {
        return $this->belongsTo(LeaveRequest::class, 'leave_request_id', 'id');
    }

    public function attendanceStatus()
    {
        return $this->belongsTo(AttendanceStatus::class,  'attendance_status_id', 'id');
    }
}
