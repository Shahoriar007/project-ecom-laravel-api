<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'weekends',
        'check_in_out_time'
    ];

    protected $casts = [
        'weekends' => 'array',
        'check_in_out_time' => 'array',
    ];

    // public function getWeekendsAttribute($value)
    // {
    //     $weekendsArray = json_decode($value);

    //     return $weekendsArray;
    //     // $this->attributes['weekends'] =  $weekendsArray;
    // }
}
