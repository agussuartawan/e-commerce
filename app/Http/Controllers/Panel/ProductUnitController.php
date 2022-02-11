<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\ProductUnit;
use Illuminate\Http\Request;

class ProductUnitController extends Controller
{
    public function searchUnit(Request $request)
    {
        $search = $request->search;
        return ProductUnit::where('name', 'LIKE', "%$search%")->select('id', 'name')->get();
    }
}
