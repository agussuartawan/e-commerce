<?php

namespace App\Http\Controllers\Beranda;

use App\Models\Sale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    public function index()
    {
        $sales = Sale::with('product')->where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(10);
        return view('beranda.delivery', compact('sales'));
    }
}
