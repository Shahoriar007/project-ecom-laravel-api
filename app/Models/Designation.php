<?php

namespace App\Models;

use App\Traits\LogPreference;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Designation extends Model
{
    use HasFactory, LogPreference;

    /**
     * The name of the logs to differentiate
     *
     * @var string
     */
    protected $fillable = [
        'name', 'description', 'employee_type_id'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'designation_id', 'id');
    }

    public function employeeType()
    {
        return $this->belongsTo(EmployeeType::class, 'employee_type_id', 'id');
    }
}
