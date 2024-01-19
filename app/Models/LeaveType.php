<?php

namespace App\Models;

use App\Models\EmployeeType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveType extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'gender',
        'employee_type_id'
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'leave_type_id', 'id');
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class, 'leave_type_id', 'id');
    }

    public function employeeType()
    {
        return $this->belongsTo(EmployeeType::class, 'employee_type_id', 'id');
    }
}
