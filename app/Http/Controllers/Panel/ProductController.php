<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductFragrance;
use App\Models\ProductUnit;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Storage;

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
        // membuat nomor penjualan otomatis
        $product_count = Product::count();
        if($product_count == 0){
            $number = 10001;
            $fullnumber = 'BRG' . $number;
        } else {
            $number = Product::all()->last();
            $number_plus = (int)substr($number->code, -5) + 1;
            $fullnumber = 'BRG' . $number_plus;
        }
        return view('panel.product.create', compact('fullnumber'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product_count = Product::count();
        if($product_count == 0){
            $number = 10001;
            $fullnumber = 'BRG' . $number;
        } else {
            $number = Product::all()->last();
            $number_plus = (int)substr($number->code, -5) + 1;
            $fullnumber = 'BRG' . $number_plus;
        }

        $messages = [
            'product_name.required' => 'Nama tidak boleh kosong!',
            'product_name.string' => ' Nama tidak boleh mengandung simbol!',
            'product_name.max' => ' Nama tidak boleh melebihi 255 huruf!',
            'selling_price.required' => 'Harga tidak boleh kosong!',
            'category_id.required' => 'Kategori tidak boleh kosong!',
            'product_color_id.required' => 'Warna tidak boleh kosong!',
            'product_fragrance_id.required' => 'Aroma tidak boleh kosong!',
            'product_unit_id.required' => 'Unit tidak boleh kosong!',
        ];

        $validatedData = $request->validate([
            'product_name' => ['required', 'string', 'max:255'],
            'selling_price' => ['required', 'numeric'],
            'category_id' => ['required'],
            'product_color_id' => ['required'],
            'product_fragrance_id' => ['required'],
            'product_unit_id' => ['required'],
            'photo' => ['image','file', 'max:512'],
            'stock' => ['required', 'numeric']
        ], $messages);

        if($request->file('photo')){
            $validatedData['photo'] = $request->file('photo')->store('product-photo');
        }

        $validatedData['size'] = $request->size;
        $validatedData['description'] = $request->description;
        $validatedData['code'] = $fullnumber;
        
        $product = Product::create($validatedData);

        $product->product_color()->sync($validatedData['product_color_id']);
        $product->product_fragrance()->sync($validatedData['product_fragrance_id']);

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
        $categories = Category::pluck('name', 'id');
        $colors = ProductColor::pluck('name', 'id');
        $units = ProductUnit::pluck('name', 'id');
        $fragrances = ProductFragrance::pluck('name', 'id');
        return view('panel.product.edit', compact('product', 'colors', 'units', 'fragrances', 'categories'));
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
            'product_name.required' => 'Nama tidak boleh kosong!',
            'product_name.string' => ' Nama tidak boleh mengandung simbol!',
            'product_name.max' => ' Nama tidak boleh melebihi 255 huruf!',
            'selling_price.required' => 'Harga tidak boleh kosong!',
            'category_id.required' => 'Kategori tidak boleh kosong!',
            'product_color_id.required' => 'Warna tidak boleh kosong!',
            'product_fragrance_id.required' => 'Aroma tidak boleh kosong!',
            'product_unit_id.required' => 'Unit tidak boleh kosong!',
        ];

        $validatedData = $request->validate([
            'product_name' => ['required', 'string', 'max:255'],
            'selling_price' => ['required', 'numeric'],
            'category_id' => ['required'],
            'product_color_id' => ['required'],
            'product_fragrance_id' => ['required'],
            'product_unit_id' => ['required'],
            'photo' => ['image','file', 'max:512'],
            'stock' => ['required', 'numeric']
        ], $messages);

        if($request->file('photo')){
            if($product->photo){
                Storage::delete($product->photo);
            }
            $validatedData['photo'] = $request->file('photo')->store('product-photo');
        }

        $validatedData['size'] = $request->size;
        $validatedData['description'] = $request->description;
        $validatedData['code'] = $request->code;
        
        $product->update($validatedData);

        $product->product_color()->sync($validatedData['product_color_id']);
        $product->product_fragrance()->sync($validatedData['product_fragrance_id']);

        return $product;
    }

    public function destroy(Product $product)
    {
        \DB::transaction(function () use ($product) {
            $product->product_color()->detach();
            $product->product_fragrance()->detach();
            return $product->delete();
        });
    }
    
    public function getProductLists(Request $request)
    {
        $data  = Product::with('category');

        return DataTables::of($data)
            ->addColumn('category', function ($data) {
                return '<span class="badge badge-secondary">'.$data->category->name.'</span>';
            })
            ->addColumn('action', function ($data) {
                $buttons = '<div class="row"><div class="col">';
                $buttons .= '<a href="/products/'. $data->id .'" class="btn btn-sm btn-outline-success btn-block btn-show" title="Detail '.$data->product_name.'">Detail</a>';
                $buttons .= '</div><div class="col">';
                $buttons .= '<a href="/products/'. $data->id .'/edit" class="btn btn-sm btn-outline-info btn-block modal-edit" title="Edit '.$data->product_name.'">Edit</a>';
                if(!$data->sale()->exists()){
                    $buttons .= '</div><div class="col">';
                    $buttons .= '<a href="/products/'. $data->id .'" class="btn btn-sm btn-outline-danger btn-block btn-delete" title="Hapus '.$data->product_name.'">Hapus</a></div>';
                }
                $buttons .= '</div>';

                return $buttons;
            })
            ->addColumn('selling_price', function($data){
                return rupiah($data->selling_price);
            })
            ->addColumn('stock', function($data){
                return $data->stock . ' ' . $data->product_unit->name;
            })
            ->filter(function ($instance) use ($request) {
                if ($request->category_id) {
                    $instance->where('category_id', $request->category_id);
                }
                if (!empty($request->search)) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->search;
                        $w->orWhere('product_name', 'LIKE', "%$search%")
                            ->orwhere('stock', 'LIKE', "%$search%")
                            ->orwhere('size', 'LIKE', "%$search%")
                            ->orwhere('selling_price', 'LIKE', "%$search%");
                    });
                }

                return $instance;
            })
            ->rawColumns(['action', 'category', 'selling_price', 'stock'])
            ->make(true);
    }

    public function searchProduct(Request $request)
    {
        $search = $request->search;
        return Product::where('product_name', 'LIKE', "%$search%")->select('id', 'product_name', 'selling_price')->get();
    }
}
