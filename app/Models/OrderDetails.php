<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'pizza_name',
        'pizza_size',
        'pizza_price',
    ];

    public function orders()
    {
        return $this->belongsTo(Order::class);
    }
}
