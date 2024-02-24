<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChildCategory extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'sub_category_id',
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

        static::creating(function ($childCategory) {
            $slug = $childCategory->name . ' ' . uniqid();
            $childCategory->slug = Str::slug($slug);
        });

        static::updating(function ($childCategory) {
            $slug = $childCategory->name . ' ' . uniqid();
            $childCategory->slug = Str::slug($slug);
        });
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id', 'id');
    }
}
