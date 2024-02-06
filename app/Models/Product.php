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
        'status',
        'description',
        'offer_notice',
        'price',
        'regular_price',
        'sale_price',
        'quantity',
        'sku_code',
        'is_flash_sale',
        'is_new_arrival',
        'is_hot_deal',
        'is_for_you',
        'category_id',
        'created_by',
        'updated_by',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });

        static::updating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product', 'order_id', 'product_id');
    }
}
