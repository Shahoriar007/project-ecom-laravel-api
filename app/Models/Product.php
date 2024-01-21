<?php

namespace App\Models;

use App\Traits\CreatedBy;
use App\Traits\UpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use CreatedBy;
    use UpdatedBy;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
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

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product-images');
    }
}
