<?php

namespace App\Http\Controllers\Beranda;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function beranda(Request $request)
    {
        $products = Product::orderBy('product_name', 'ASC');

        $search = $request->search;
        $category_id = $request->category_id;

        if(!empty($search)){
            $products->where('product_name', 'like', "%$search%");
        }
        if($category_id > 0){
            $products->where('category_id', $category_id);
        }

        $categories = Category::get();
        $products = $products->get();

        return view('beranda.index', compact('categories', 'products', 'search', 'category_id'));
    }

    public function productShow(Product $product)
    {
        $categories = Category::all();
        return view('beranda.product-show', compact('categories', 'product'));
    }
}
