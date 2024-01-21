<?php

namespace App\Models;

use App\Traits\CreatedBy;
use App\Traits\UpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    use CreatedBy;
    use UpdatedBy;

    protected $fillable = [
        'name',
        'description',
        'is_featured',

    ];


    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('category-images');
    }
}
