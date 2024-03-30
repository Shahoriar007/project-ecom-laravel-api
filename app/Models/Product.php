<?php

namespace App\Models;

use App\Models\Label;
use App\Traits\CreatedBy;
use App\Traits\UpdatedBy;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'sku',
        'stock',
        'short_description',
        'offer_notice',
        'sale_price',
        'sale_count',
        'status',
        'ratings',
        'is_hot',
        'is_sale',
        'is_new',
        'is_out_of_stock',
        'is_for_you',
        'release_date',
        'developer',
        'publisher',
        'category_id',
        'sub_category_id',
        'child_category_id',
        'rated',
        'until',
        'created_by',
        'updated_by',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $slug = $product->name . ' ' . uniqid();
            $product->slug = Str::slug($slug);
        });

        static::updating(function ($product) {
            $slug = $product->name . ' ' . uniqid();
            $product->slug = Str::slug($slug);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function childCategory()
    {
        return $this->belongsTo(ChildCategory::class, 'child_category_id');
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product', 'order_id', 'product_id')->withPivot('quantity');
    }
}
