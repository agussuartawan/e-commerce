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

    public function create(Request $request)
    {
        $product_unit = new ProductUnit();
        return view('panel.product-unit.create', compact('product_unit'));
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Nama tidak boleh kosong!',
            'name.string' => 'Nama tidak boleh mengandung simbol!',
            'name.string' => 'Nama tidak boleh melebihi 255 huruf!',
        ];

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ], $messages);
        
        $unit = ProductUnit::create($request->all());

        return $unit;
    }
}
