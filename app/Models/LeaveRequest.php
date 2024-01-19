<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'leave_type_id',
        'start_date',
        'end_date',
        'status',
        'remarks'
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'leave_request_id', 'id');
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
