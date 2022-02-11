<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\ProductColor;
use Illuminate\Http\Request;

class ProductColorController extends Controller
{
    public function searchColor(Request $request)
    {
        $search = $request->search;
        return ProductColor::where('name', 'LIKE', "%$search%")->select('id', 'name')->get();
    }
}
