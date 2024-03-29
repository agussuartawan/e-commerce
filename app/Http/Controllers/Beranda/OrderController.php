<?php

namespace App\Http\Controllers\Beranda;

use DB;
use Carbon\Carbon;
use App\Models\Bank;
use App\Models\City;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Province;
use App\Events\SaleCreated;
use Illuminate\Http\Request;
use App\Models\PaymentStatus;
use App\Models\DeliveryStatus;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

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
        if ($product->stock >= $request->qty) {
            $result = '';
            DB::transaction(function () use ($request, $product, &$result) {
                // membuat nomor penjualan otomatis
                $now = Carbon::now();
                $year_month = $now->year . $now->month;
                $sale_count = Sale::count();
                if ($sale_count == 0) {
                    $number = 10001;
                    $fullnumber = 'CVMS' . $year_month . $number;
                } else {
                    $number = Sale::all()->last();
                    $number_plus = (int)substr($number->sale_number, -5) + 1;
                    $fullnumber = 'CVMS' . $year_month . $number_plus;
                }

                // validasi input
                $messages = [
                    'qty.required' => 'Qty tidak boleh kosong!',
                    'qty.integer' => 'Qty harus angka!',
                    'address.required' => 'Tujuan Pengiriman tidak boleh kosong!',
                    'province_id.required' => 'Provinsi tidak boleh kosong!',
                    'city_id.required' => 'Kota tidak boleh kosong!',
                    'bank_id.required' => 'Bank tidak boleh kosong!',
                    'product_color_id.required' => 'Mohon pilih warna produk!',
                    'product_fragrance_id.required' => 'Mohon pilih aroma product!',
                ];

                $validated = $request->validate([
                    'qty' => ['required', 'integer'],
                    'address' => ['required'],
                    'province_id' => ['required'],
                    'city_id' => ['required'],
                    'bank_id' => ['required'],
                    'product_color_id' => ['required'],
                    'product_fragrance_id' => ['required'],
                ], $messages);

                //hitung grand total
                $price = $product->selling_price;
                $sub_total = (int)$price * (int)$validated['qty'];
                if ($validated['province_id'] != 1) {
                    $ongkir = Sale::ONGKIR;
                }
                if ($validated['province_id'] == 1) {
                    $ongkir = 0;
                }
                $grand_total = $sub_total + $ongkir;

                // hitung tanggal jatuh tempo
                $due_date = $now->addDay();

                //insert ke table sales
                $sale = Sale::create([
                    'sale_number' => $fullnumber,
                    'date' => Carbon::now(),
                    'qty' => $validated['qty'],
                    'note' => $request->note,
                    'address' => $validated['address'],
                    'payment_status_id' => PaymentStatus::MENUNGGU_PEMBAYARAN,
                    'delivery_status_id' => DeliveryStatus::MENUNGGU,
                    'grand_total' => $grand_total,
                    'customer_id' => auth()->user()->customer->id,
                    'product_id' => $product->id,
                    'user_id' => auth()->user()->id,
                    'province_id' => $validated['province_id'],
                    'city_id' => $validated['city_id'],
                    'bank_id' => $validated['bank_id'],
                    'product_color_id' => $validated['product_color_id'],
                    'product_fragrance_id' => $validated['product_fragrance_id'],
                    'due_date' => $due_date
                ]);

                $result = '/order/' . $sale->id . '/result';
                return $result;
            });

            return $result;
        } else {
            return response()->json([
                'errors' => ['qty' => [0 => 'Stok tidak mencukupi!']]
            ], 404);
        }
    }

    public function result(Sale $sale)
    {
        if ($sale->user_id != Auth::user()->id) {
            abort(404);
        } else if ($sale->payment_status_id == PaymentStatus::LUNAS || $sale->payment_status_id == PaymentStatus::MENUNGGU_KONFIRMASI) {
            return redirect()->route('order.show', $sale);
        } else if ($sale->payment_status_id == PaymentStatus::DIBATALKAN) {
            return redirect()->route('beranda');
        }

        $due = Carbon::parse($sale->due_date);

        return view('beranda.result', compact('sale', 'due'));
    }

    public function searchProvince(Request $request)
    {
        $search = $request->search;
        return Province::where('name', 'LIKE', "%$search%")->select('id', 'name')->get();
    }

    public function searchCity(Request $request)
    {
        $search = $request->search;
        return City::where('name', 'LIKE', "%$search%")->where('province_id', $request->province_id)->select('id', 'name')->get();
    }

    public function show(Sale $sale)
    {
        if ($sale->payment_status_id == PaymentStatus::MENUNGGU_PEMBAYARAN) {
            return redirect()->route('order.result', $sale);
        } elseif ($sale->is_cancel == 1) {
            return redirect()->route('delivery.index');
        }
        return view('beranda.order.show', compact('sale'));
    }

    public function invoice(Sale $sale)
    {
        if (auth()->user()->can('akses beranda') || auth()->user()->can('akses penjualan')) {
            $pdf = PDF::loadView('pdf.invoice', compact('sale'));
            $pdf->setPaper('A4', 'potrait');
            return $pdf->stream('invoice-penjualan.pdf');
        }
        return abort(403);
    }
}
