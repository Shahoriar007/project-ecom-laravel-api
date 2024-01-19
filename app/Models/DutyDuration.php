<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DutyDuration extends Model
{
    use HasFactory;

    protected $fillable = [
        'duration',
        'check_in_time',
        'weekend_days',
        'penalty_hour'
    ];
}
