<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetailsSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'pizza_name',
        'pizza_size',
        'pizza_price',
    ];
}
