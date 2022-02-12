<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function beranda()
    {
        $categories = Category::all();
        $products = Product::get();
        return view('beranda.index', compact('categories', 'products'));
    }

    public function productShow(Product $product)
    {
        $categories = Category::all();
        return view('beranda.product-show', compact('categories', 'product'));
    }
}
