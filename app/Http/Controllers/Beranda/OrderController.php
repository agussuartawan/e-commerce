<?php

namespace App\Http\Controllers\Beranda;

use App\Models\Bank;
use App\Models\City;
use App\Models\Product;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function create(Product $product)
    {
        $banks = Bank::pluck('name', 'id'); 
        $provinces = Province::pluck('name', 'id'); 
        $cities = City::pluck('name', 'id'); 

        return view('beranda.create', compact('product', 'banks', 'provinces', 'cities'));
    }
}
