<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'previous_order_status',
        'current_order_status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}




