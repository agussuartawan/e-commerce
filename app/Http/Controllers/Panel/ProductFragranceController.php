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

    public function create(Request $request)
    {
        $product_fragrance = new ProductFragrance();
        return view('panel.product-fragrance.create', compact('product_fragrance'));
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
        
        $fragrance = ProductFragrance::create($request->all());

        return $fragrance;
    }
}
