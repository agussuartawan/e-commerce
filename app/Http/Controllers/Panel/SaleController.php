<?php

namespace App\Http\Controllers\Panel;

use Carbon\Carbon;
use App\Models\Bank;
use App\Models\City;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Province;
use App\Events\SaleUpdated;
use App\Events\SaleUpdating;
use Illuminate\Http\Request;
use App\Models\PaymentStatus;
use App\Models\DeliveryStatus;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Events\PaymentConfirmed;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\DeliveryEmailNotification;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $from = Carbon::now()->startOfDay()->format('d-m-Y');
        $to = Carbon::now()->endOfDay()->format('d-m-Y');
        $now = $from . ' s/d ' . $to;
        $newSale = Sale::where('is_new', 1)->count();
        return view('panel.sale.index', compact('now', 'newSale'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        if (auth()->user()->can('akses penjualan aksi')) {
            return view('include.sale.show', compact('sale'));
        }
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        if ($sale->is_cancel == 1 && !auth()->user()->can('akses penjualan aksi')) {
            abort(403);
        }
        $provinces = Province::pluck('name', 'id');
        $cities = City::pluck('name', 'id');
        $banks = Bank::pluck('name', 'id');
        $customers = Customer::pluck('fullname', 'id');
        $products = Product::pluck('product_name', 'id');
        return view('include.sale.edit', compact('customers', 'sale', 'provinces', 'cities', 'banks', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        if ($sale->is_cancel == 1 && !auth()->user()->can('akses penjualan aksi')) {
            abort(403);
        }
        // validasi input
        $messages = [
            'qty.required' => 'Qty tidak boleh kosong!',
            'qty.integer' => 'Qty harus angka!',
            'address.required' => 'Tujuan Pengiriman tidak boleh kosong!',
            'province_id.required' => 'Provinsi tidak boleh kosong!',
            'city_id.required' => 'Kota tidak boleh kosong!',
            'product_color_id.required' => 'Mohon pilih warna produk!',
            'product_fragrance_id.required' => 'Mohon pilih aroma product!',
            'customer_id.required' => 'Pelanggan tidak boleh kosong!',
            'product_id.required' => 'Produk tidak boleh kosong!',
            'date.required' => 'Waktu Penjualan tidak boleh kosong!'
        ];
        $validated = $request->validate([
            'product_id' => ['required'],
            'customer_id' => ['required'],
            'province_id' => ['required'],
            'city_id' => ['required'],
            'product_color_id' => ['required'],
            'product_fragrance_id' => ['required'],
            'qty' => ['required', 'integer'],
            'address' => ['required'],
            'date' => ['required'],
        ], $messages);

        // balikin stok produk ke semula
        $product = Product::findOrFail($request->product_id);
        event(new SaleUpdating($sale, $product));

        if ($product->stock < $validated['qty']) { // cek apakah stok mencukupi
            $product->decrement('stock', $sale->qty);

            // return error jika stok tidak mencukupi
            return response()->json([
                'errors' => ['qty' => [0 => 'Stok tidak mencukupi!']]
            ], 422);
        }

        DB::transaction(function () use ($sale, $product, $validated) {
            //hitung grand total
            $price = $product->selling_price;
            $grand_total = $price * $validated['qty'];

            // hitung tanggal jatuh tempo
            $date = Carbon::parse($validated['date']);
            $due_date = $date->addDay();

            // cari user id berdasarkan data customer
            $customer = Customer::findOrFail($validated['customer_id']);
            $user_id = $customer->user->id;

            // update variable validated
            $validated['user_id'] = $user_id;
            $validated['grand_total'] = $grand_total;
            $validated['due_date'] = $due_date;

            // update tabel penjualan
            $sale->update($validated);

            //potong stok di table products
            event(new SaleUpdated($sale, $validated));

            return $sale;
        });
    }

    public function getSaleList(Request $request)
    {
        $data  = Sale::query();

        return DataTables::of($data)
            ->addColumn('grand_total', function ($data) {
                return 'Rp. ' . rupiah($data->grand_total);
            })
            ->addColumn('customer', function ($data) {
                return $data->customer->fullname;
            })
            ->addColumn('product', function ($data) {
                return $data->product->product_name;
            })
            ->addColumn('date', function ($data) {
                return Carbon::parse($data->date)->format('d/m/Y');
            })
            ->addColumn('delivery_status', function ($data) {
                if (auth()->user()->can('akses penjualan aksi')) {
                    if ($data->delivery_status_id == DeliveryStatus::DIKIRIM) {
                        return '<span class="badge badge-success">' . $data->delivery_status->name . '</span>';
                    } else if ($data->delivery_status_id == DeliveryStatus::DALAM_PENGIRIMAN) {
                        return '<span class="badge badge-warning">' . $data->delivery_status->name . '</span>';
                    } else if ($data->payment_status_id == PaymentStatus::MENUNGGU_PEMBAYARAN) {
                        return '<span class="badge badge-secondary">' . $data->payment_status->name . '</span>';
                    } else if ($data->payment_status_id == PaymentStatus::MENUNGGU_KONFIRMASI) {
                        return '<span class="badge badge-secondary">' . $data->payment_status->name . '</span>';
                    } else if ($data->is_cancel == 1 || $data->payment_status_id == PaymentStatus::DIBATALKAN || $data->delivery_status_id == DeliveryStatus::DIBATALKAN) {
                        return '<span class="badge badge-danger">dibatalkan</span>';
                    } else if ($data->is_validated_warehouse == 0) {
                        return '<span class="badge badge-secondary">menunggu</span>';
                    }

                    $confirm = '<form action="/sale/' . $data->id . '/confirm" method="POST" class="d-none form-send' . $data->id . '">';
                    $confirm .= '<input type="hidden" value="' . csrf_token() . '" name="_token">';
                    $confirm .= '<input type="hidden" value="PUT" name="_method">';
                    $confirm .= '</form>';
                    $confirm .= '<a href="#" class="btn btn-sm btn-outline-info btn-block btn-confirm" data-id="form-send' . $data->id . '">Kirim</a>';

                    return $confirm;
                }
                return '';
            })
            ->addColumn('warehouse_status', function ($data) {
                if (auth()->user()->can('akses penjualan aksi')) {
                    if ($data->is_validated_warehouse == 1) {
                        return '<span class="badge badge-success">Siap</span>';
                    }
                    if ($data->is_cancel == 1) {
                        return '<span class="badge badge-danger">dibatalkan</span>';
                    } else {
                        return '<span class="badge badge-secondary">Belum Siap</span>';
                    }
                } else {
                    if ($data->is_validated_warehouse == 1) {
                        return '<span class="badge badge-success">Siap</span>';
                    }
                    if ($data->is_cancel == 1) {
                        return '<span class="badge badge-danger">dibatalkan</span>';
                    }
                    if ($data->is_validated_warehouse == 0) {
                        if ($data->payment_status_id == PaymentStatus::MENUNGGU_KONFIRMASI || $data->payment_status_id == PaymentStatus::MENUNGGU_PEMBAYARAN) {
                            return '<span class="badge badge-secondary">' . $data->payment_status->name . '</span>';
                        }
                        $confirm = '<form action="/sale/' . $data->id . '/confirm-warehouse" method="POST" class="d-none form-send' . $data->id . '">';
                        $confirm .= '<input type="hidden" value="' . csrf_token() . '" name="_token">';
                        $confirm .= '<input type="hidden" value="PUT" name="_method">';
                        $confirm .= '</form>';
                        $confirm .= '<a href="#" class="btn btn-sm btn-outline-info btn-block btn-confirm-warehouse" data-id="form-send' . $data->id . '">Konfirm</a>';
                        return $confirm;
                    }
                }
            })
            ->addColumn('action', function ($data) {
                if (auth()->user()->can('akses penjualan aksi')) {
                    $buttons = '<div class="row">';

                    $buttons .= '<div class="col">';
                    $buttons .= '<a href="/sales/' . $data->id . '" class="btn btn-sm btn-outline-success btn-block btn-show" title="Detail ' . $data->sale_number . '" data-id="' . $data->id . '">Detail</a>';
                    $buttons .= '</div>';

                    if ($data->is_cancel != 1) {
                        $buttons .= '<div class="col">';
                        $buttons .= '<a href="/sales/' . $data->id . '/edit" class="btn btn-sm btn-outline-info btn-block modal-edit" title="Edit ' . $data->sale_number . '">Edit</a>';
                        $buttons .= '</div>';
                    }

                    $buttons .= '</div>';
                } else {
                    if ($data->is_cancel == 1) {
                        return '<span class="badge badge-danger">dibatalkan</span>';
                    } else {
                        $buttons = '<a href="/sale/form-order/' . $data->id . '" target="_blanc" class="btn btn-outline-primary btn-block btn-sm print-fo">Cetak Form Order</a>';
                    }
                }

                return $buttons;
            })
            ->filter(function ($instance) use ($request) {
                if ($request->dateFilter) {
                    $from = explode(" s/d ", $request->dateFilter)[0];
                    $to = explode(" s/d ", $request->dateFilter)[1];

                    $date['from'] = Carbon::parse($from)->startOfDay()->format('Y-m-d H:i:s');
                    $date['to'] = Carbon::parse($to)->endOfDay()->format('Y-m-d H:i:s');
                    $instance->whereBetween('date', $date);
                }
                if (!empty($request->search)) {
                    $instance->join('customers', 'customers.id', '=', 'sales.customer_id')
                        ->join('products', 'products.id', '=', 'sales.product_id')
                        ->where(function ($w) use ($request) {
                            $search = $request->search;
                            $w->orWhere('sale_number', 'LIKE', "%$search%")
                                ->orWhere('customers.fullname', 'LIKE', "%$search%")
                                ->orWhere('grand_total', 'LIKE', "%$search%")
                                ->orWhere('products.product_name', 'LIKE', "%$search%");
                        });
                }

                return $instance;
            })
            ->rawColumns(['action', ' customer', 'product', 'date', 'grand_total', 'delivery_status', 'warehouse_status'])
            ->make(true);
    }

    public function deliveryConfirm(Sale $sale)
    {
        DB::transaction(function () use ($sale) {
            $sale->delivery_status_id = DeliveryStatus::DALAM_PENGIRIMAN;
            $sale->save();
            event(new PaymentConfirmed($sale));

            $now = Carbon::now();
            $delivery_estimation = $now->isoFormat('DD MMMM Y') . ' - ' . $now->addDays(2)->isoFormat('DD MMMM Y');
            Mail::to($sale->customer->user->email)->send(new DeliveryEmailNotification($sale, $delivery_estimation));
        });

        return $sale;
    }

    public function getVariantList(Product $product, Sale $sale)
    {
        return view('include.sale.variant', compact('product', 'sale'));
    }

    public function formOrder(Sale $sale)
    {
        $pdf = PDF::loadView('pdf.form-order', compact('sale'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream('form-order.pdf');
    }

    public function warehouseConfirm(Sale $sale)
    {
        DB::transaction(function () use ($sale) {
            $sale->is_validated_warehouse = 1;
            $sale->save();
        });

        return $sale;
    }

    public function notificationClose()
    {
        Sale::where('is_new', '1')->update(['is_new' => 0]);
        return redirect()->route('sales.index');
    }
}
