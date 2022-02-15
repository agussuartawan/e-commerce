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
        'product_color_id',
        'product_fragrance_id',
        'due_date',
        'is_cancel',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function product_color()
    {
        return $this->belongsTo(ProductColor::class);
    }

    public function product_fragrance()
    {
        return $this->belongsTo(ProductFragrance::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
