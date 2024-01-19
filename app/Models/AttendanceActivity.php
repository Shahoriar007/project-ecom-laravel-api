<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_id',
        'date',
        'check_in',
        'check_out',
        'worked_minutes'
    ];

    public function attendances()
    {
        return $this->belongsTo(Attendance::class, 'attendance_id', 'id');
    }
}
