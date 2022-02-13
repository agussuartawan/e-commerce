<?php

namespace App\Http\Controllers\Beranda;

use Carbon\Carbon;
use App\Models\Bank;
use App\Models\City;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class OrderController extends Controller
{
    public function create(Product $product)
    {
        $banks = Bank::pluck('name', 'id'); 
        $provinces = Province::pluck('name', 'id'); 
        $cities = City::pluck('name', 'id'); 

        return view('beranda.create', compact('product', 'banks', 'provinces', 'cities'));
    }

    public function store(Request $request, Product $product)
    {
        if($product->stock >= $request->qty){
            DB::transaction(function () use ($request, $product){
                // membuat nomor penjualan otomatis
                $now = Carbon::now();
                $year_month = $now->year . $now->month;
                $sale_count = Sale::count();
                if($sale_count == 0){
                    $number = 10000;
                    $fullnumber = 'CVMN' . $year_month . $number;
                } else {
                    $number = Sale::all()->last();
                    $number_plus = (int)substr($number->sale_number, -5) + 1;
                    $fullnumber = 'CVMN' . $year_month . $number_plus;
                }

                // validasi input
                $messages = [
                    'qty.required' => 'Qty tidak boleh kosong!',
                    'qty.integer' => 'Qty harus angka!',
                    'address.required' => 'Tujuan Pengiriman tidak boleh kosong!',
                    'province_id.required' => 'Provinsi tidak boleh kosong!',
                    'city_id.required' => 'Kota tidak boleh kosong!',
                    'bank_id.required' => 'Bank tidak boleh kosong!',
                ];

                $validated = $request->validate([
                    'qty' => ['required', 'integer'],
                    'address' => ['required'],
                    'province_id' => ['required'],
                    'city_id' => ['required'],
                    'bank_id' => ['required'],
                ], $messages);

                //hitung grand total
                $price = $product->selling_price;
                $grand_total = (int)$price * (int)$validated['qty'];

                //insert ke table sales
                $sale = Sale::create([
                    'sale_number' => $fullnumber,
                    'date' => $now,
                    'qty' => $validated['qty'],
                    'note' => $request->note,
                    'address' => $validated['address'],
                    'payment_status' => 'menunggu pembayaran',
                    'delivery_status' => 'menunggu',
                    'is_received' => 0,
                    'grand_total' => $grand_total,
                    'customer_id' => auth()->user()->customer->id,
                    'product_id' => $product->id,
                    'user_id' => auth()->user()->id,
                    'province_id' => $validated['province_id'],
                    'city_id' => $validated['city_id'],
                    'bank_id' => $validated['bank_id'],
                ]);

                //potong stok di table products
                $product->stock = (int)$product->stock - (int)$validated['qty'];
                $product->save();

                return response('/order/' . $sale->id . '/payment');
            });
        } else {
            return response()->json([
                'errors' => ['qty' => [0 => 'Stok tidak mencukupi!']]
            ], 404);
        }
    }

    public function searchProvince(Request $request)
    {
        $search = $request->search;
        return Province::where('name', 'LIKE', "%$search%")->select('id', 'name')->get();
    }

    public function searchBank(Request $request, $province_id)
    {
        $search = $request->search;
        return City::where('name', 'LIKE', "%$search%")->where('province_id', $request->province_id)->select('id', 'name')->get();
    }
}
