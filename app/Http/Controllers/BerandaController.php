<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function beranda()
    {
        return view('beranda.index');
    }

    public function productShow(Product $product)
    {
        return view('beranda.product-show', compact('product'));
    }
}
