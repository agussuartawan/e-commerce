<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\ProductFragrance;
use Illuminate\Http\Request;

class ProductFragranceController extends Controller
{
    public function searchFragrance(Request $request)
    {
        $search = $request->search;
        return ProductFragrance::where('name', 'LIKE', "%$search%")->select('id', 'name')->get();
    }
}
