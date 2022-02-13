<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'product_id', 
        'user_id',
        'province_id',
        'city_id',
        'bank_id',
        'sale_number',
        'qty',
        'grand_total',
        'date',
        'note',
        'address',
        'payment_status',
        'delivery_status',
        'is_received',
    ];
}
