<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'head_id', 'division_id'];


    public function head()
    {
        return $this->hasOne(User::class, 'id', 'head_id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'department_id', 'id');
    }
}
