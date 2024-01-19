<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Division extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'head_id'];


    public function head()
    {
        return $this->hasOne(User::class, 'id', 'head_id');
    }

    public function departments()
    {
        return $this->hasMany(Department::class, 'division_id', 'id');
    }
}
