<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductFragrance;
use App\Models\ProductUnit;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::create(['name' => 'Body Wash']);
        $color = ProductColor::create(['name' => 'Putih', 'hex_color' => '#ffffff']);
        $fragrance = ProductFragrance::create(['name' => 'Melati']);
        $unit = ProductUnit::create(['name' => 'gram']);

        $product = Product::create([
            'category_id' => $category->id,
            'product_unit_id' => $unit->id,
            'product_name' => 'Sabun Mandi',
            'stock' => 0,
            'selling_price' => 15000,
            'production_price' => 5000,
            'size' => 100,
            'description' => 'Sabun merupakan pembersih diri dari kotoran yang menempel di permukaan kulit. Hampir semua orang membutuhkan sabun karena fungsinya sangat penting, namun sabun juga dapat menjadikan kulit kering. Reaksi kulit terhadap sabun dipengaruhi oleh bahan pembuatnya. “Sabun alami” adalah sabun yang dibuat dari bahan-bahan alam',
            'code' => 'BRG10001'
        ]);

        $product->product_color()->attach($color->id);
        $product->product_fragrance()->attach($fragrance->id);
    }
}
