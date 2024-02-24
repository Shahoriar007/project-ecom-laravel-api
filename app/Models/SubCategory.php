<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'category_id',
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

        static::creating(function ($subCategory) {
            $slug = $subCategory->name . ' ' . uniqid();
            $subCategory->slug = Str::slug($slug);
        });

        static::updating(function ($subCategory) {
            $slug = $subCategory->name . ' ' . uniqid();
            $subCategory->slug = Str::slug($slug);
        });
    }


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function childCategories(): HasMany
    {
        return $this->hasMany(ChildCategory::class, 'sub_category_id', 'id');
    }
}
