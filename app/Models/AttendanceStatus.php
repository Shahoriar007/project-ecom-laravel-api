<?php

namespace App\Models;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttendanceStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sort_name',
        'color_code',
        'class',
    ];
}
