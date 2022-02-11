<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Nama tidak boleh kosong!',
            'name.string' => ' Nama tidak boleh mengandung simbol!',
            'name.string' => ' Nama tidak boleh melebihi 255 huruf!',
            'selling_price.required' => 'Harga tidak boleh kosong!',
            'category_id.required' => 'Kategori tidak boleh kosong!',
            'product_color_id.required' => 'Warna tidak boleh kosong!',
            'product_fragrance_id.required' => 'Aroma tidak boleh kosong!',
            'product_unit_id.required' => 'Unit tidak boleh kosong!',
        ];

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'selling_price' => ['required'],
            'category_id' => ['required'],
            'product_color_id' => ['required'],
            'product_fragrance_id' => ['required'],
            'product_unit_id' => ['required'],
        ], $messages);
        
        $product = Product::create($request->all());

        return $product;
    }

    public function show(Product $product)
    {
        return view('include.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('panel.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $messages = [
            'name.required' => 'Nama tidak boleh kosong!',
            'name.string' => ' Nama tidak boleh mengandung simbol!',
            'name.string' => ' Nama tidak boleh melebihi 255 huruf!',
            'selling_price.required' => 'Harga tidak boleh kosong!',
            'category_id.required' => 'Kategori tidak boleh kosong!',
            'product_color_id.required' => 'Warna tidak boleh kosong!',
            'product_fragrance_id.required' => 'Aroma tidak boleh kosong!',
            'product_unit_id.required' => 'Unit tidak boleh kosong!',
        ];

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'selling_price' => ['required'],
            'category_id' => ['required'],
            'product_color_id' => ['required'],
            'product_fragrance_id' => ['required'],
            'product_unit_id' => ['required'],
        ], $messages);
        
        $product->update($request->all());

        return $product;
    }
    
    public function getProductLists(Request $request)
    {
        $data  = Product::with('category');

        return DataTables::of($data)
            ->addColumn('category', function ($data) {
                return '<span class="badge badge-secondary"'.$data->category->name.'"</span>';
            })
            ->addColumn('action', function ($data) {
                $buttons = '';
                $buttons += '<a href="/products/'. $data->id .'/show" class="btn btn-sm btn-primary btn-show" title="Detail '.$data->name.'">Edit</a>';
                $buttons += '<a href="/products/'. $data->id .'/edit" class="btn btn-sm btn-info modal-edit" title="Edit '.$data->name.'">Edit</a>';

                return $buttons;
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->search)) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->search;
                        $w->orWhere('name', 'LIKE', "%$search%")
                            ->orwhere('stock', 'LIKE', "%$search%")
                            ->orwhere('size', 'LIKE', "%$search%")
                            ->orwhere('selling_price', 'LIKE', "%$search%");
                    });
                }

                return $instance;
            })
            ->rawColumns(['action', 'category'])
            ->make(true);
    }
}
