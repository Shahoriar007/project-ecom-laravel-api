<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'delivery_charge',
        'vat',
        'tax',
        'discount',
        'total_price',
        'company_name',
        'country_name',
        'city_name',
        'detail_address',
        'order_notes',
        'payment_method',
        'status',
        'order_from',
        'comment',

    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')->withPivot('quantity');
    }
}
