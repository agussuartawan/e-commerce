<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

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
        $now = $from . ' / ' . $to;
        return view('panel.sale.index', compact('now'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        return view('include.sale.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        return view('include.sale.edit', compact('sale'));
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
            'product_id' => ['required'],

            'qty' => ['required', 'integer'],
            'address' => ['required'],
            'province_id' => ['required'],
            'city_id' => ['required'],
            'bank_id' => ['required'],
            'product_color_id' => ['required'],
            'product_fragrance_id' => ['required'],
        ], $messages);

        // return $sale->update($validated);
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
                if($data->delivery_status == 'dikirim'){
                    return '<span class="badge badge-success">'.$data->delivery_status.'</span>';
                } else if($data->delivery_status == 'dalam pengiriman'){
                    return '<span class="badge badge-warning">'.$data->delivery_status.'</span>';
                } else if($data->payment_status == 'menunggu pembayaran'){
                    return '<span class="badge badge-secondary">'.$data->payment_status.'</span>';
                }         

                $confirm = '<form action="/sale/'.$data->id.'/confirm" method="POST" class="d-none form-send'.$data->id.'">';
                $confirm .= '<input type="hidden" value="'.csrf_token().'" name="_token">';
                $confirm .= '<input type="hidden" value="PUT" name="_method">';
                $confirm .= '</form>';                
                $confirm .= '<a href="#" class="btn btn-sm btn-outline-info btn-block btn-confirm" data-id="form-send'.$data->id.'">Kirim</a>';

                return $confirm;
            })
            ->addColumn('action', function ($data) {
                $buttons = '<div class="row"><div class="col">';
                $buttons .= '<a href="/sales/'. $data->id .'" class="btn btn-sm btn-outline-success btn-block btn-show" title="Detail '.$data->sale_number.'">Detail</a>';
                $buttons .= '</div><div class="col">';
                $buttons .= '<a href="/sales/'. $data->id .'/edit" class="btn btn-sm btn-outline-info btn-block modal-edit" title="Edit '.$data->sale_number.'">Edit</a>';
                $buttons .= '</div></div>';                

                return $buttons;
            })
            ->filter(function ($instance) use ($request) {
                if ($request->dateFilter) {
                    $from = explode(" / ", $request->dateFilter)[0];
                    $to = explode(" / ", $request->dateFilter)[1];

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
            ->rawColumns(['action',' customer', 'product', 'date', 'grand_total', 'delivery_status'])
            ->make(true);
    }

    public function deliveryConfirm(Sale $sale)
    {
        $sale->delivery_status = 'dalam pengiriman';
        $sale->save();

        return $sale;
    }
}
