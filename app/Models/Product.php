<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 
        'product_unit_id',
        'code',
        'product_name',
        'stock',
        'selling_price',
        'size',
        'photo',
        'description'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function product_color()
    {
        return $this->belongsToMany(ProductColor::class, 'color_products');
    }

    public function product_fragrance()
    {
        return $this->belongsToMany(ProductFragrance::class, 'fragrance_products');
    }

    public function product_unit()
    {
        return $this->belongsTo(ProductUnit::class);
    }
}
