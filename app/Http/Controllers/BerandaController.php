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
        return view('beranda.index', compact('categories'));
    }

    public function productShow(Product $product)
    {
        return view('beranda.product-show', compact('product'));
    }
}
