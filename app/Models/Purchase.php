<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ['purchase_number', 'date'];

    public function product()
    {
        return $this->belongsToMany(Product::class, 'purchase_product')->withPivot('qty', 'production_price');
    }
}
