<?php

namespace App\Models;

use App\Traits\CreatedBy;
use App\Traits\UpdatedBy;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    // use CreatedBy;
    // use UpdatedBy;

    protected $fillable = [
        'name',
        'description',
        'is_featured',
        'slug',
        'status',
        'created_by',
        'updated_by'

    ];


    public static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });

        static::updating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }


    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
