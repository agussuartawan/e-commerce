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

    public function create(Request $request)
    {
        $product_color = new ProductColor();
        return view('panel.product-color.create', compact('product_color'));
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Nama tidak boleh kosong!',
            'name.string' => 'Nama tidak boleh mengandung simbol!',
            'name.string' => 'Nama tidak boleh melebihi 255 huruf!',
            'hex_color.required' => 'Mohon pilih warna!'
        ];

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'hex_color' => ['required']
        ], $messages);
        
        $color = ProductColor::create($request->all());

        return $color;
    }
}
