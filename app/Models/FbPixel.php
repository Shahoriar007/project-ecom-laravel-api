<?php

namespace App\Models;
use App\Traits\CreatedBy;
use App\Traits\UpdatedBy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FbPixel extends Model
{
    use HasFactory;

    protected $fillable = [
        'pixel_code',
        'created_by',
        'updated_by'
    ];
}
