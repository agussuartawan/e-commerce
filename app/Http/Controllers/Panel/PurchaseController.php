<?php

namespace App\Http\Controllers\Panel;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
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
        return view('panel.purchase.index', compact('now'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $purchase = new Purchase();
        $row = 1;
        return view('include.purchase.form', compact('purchase', 'row'));
    }

    public function showInputProduct(Request $request)
    {
        $purchase = Purchase::find($request->id);
        $is_edit_form = $request->is_edit;
        $row = $request->row;
        return view('include.purchase.input-product', compact('purchase', 'is_edit_form', 'row'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseRequest $request)
    {
        DB::transaction(function () use ($request) {
            // hapus nilai product_id yang kosong pada form
            $product['product_id'] = $request->product_id;
            $product['qty'] = $request->qty;
            $product['production_price'] = $request->production_price;
            foreach ($product['product_id'] as $key => $value) {
                if ($value == null) {
                    unset($product['product_id'][$key]);
                    unset($product['qty'][$key]);
                    unset($product['production_price'][$key]);
                }
            }

            // insert ke table purchase
            $purchase_count = Purchase::count();
            if($purchase_count == 0){
                $number = 10001;
                $fullnumber = 'BM' . $number;
            } else {
                $number = Purchase::all()->last();
                $number_plus = (int)substr($number->purchase_number, -5) + 1;
                $fullnumber = 'BM' . $number_plus;
            }

            $purchase = Purchase::create([
                'date' => $request->date,
                'purchase_number' => $fullnumber,
            ]);

            foreach ($product['product_id'] as $key => $value) {
                // insert to product_purchase
                $purchase->product()->attach($product['product_id'][$key], [
                    'qty' => $product['qty'][$key],
                    'production_price' => str_replace(".", "", $product['production_price'][$key]),
                ]);

                // update in_stock di tabel product warehouse
                Product::find($product['product_id'][$key])->increment('stock', $product['qty'][$key]);
            }

            return $purchase;
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        return view('include.purchase.show', compact('purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        $row = $purchase->product->count() + 1;
        return view('include.purchase.form', compact('purchase', 'row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(PurchaseRequest $request, Purchase $purchase)
    {
        DB::transaction(function () use ($request, $purchase) {
            foreach($purchase->product as $p){
                $purchase->product()->detach($p->id, [
                    'qty' => $p->pivot->qty, 
                    'production_price' => str_replace(".", "", $p->pivot->production_price)
                ]);
                $p->decrement('stock', $p->pivot->qty);
            }
            
            // hapus nilai product_id yang kosong pada form
            $product['product_id'] = $request->product_id;
            $product['qty'] = $request->qty;
            $product['production_price'] = $request->production_price;
            foreach ($product['product_id'] as $key => $value) {
                if ($value == null) {
                    unset($product['product_id'][$key]);
                    unset($product['qty'][$key]);
                    unset($product['production_price'][$key]);
                }
            }

            $purchase->update([
                'date' => $request->date,
            ]);
            
            // insert to product_purchase
            foreach ($product['product_id'] as $key => $value) {
                $product_id = $product['product_id'][$key];
                $qty = $product['qty'][$key];
                $production_price = str_replace(".", "", $product['production_price'][$key]);

                $purchase->product()->attach($product_id, [
                    'qty' => $qty, 
                    'production_price' => $production_price
                ]);

                // update in_stock di tabel product warehouse
                Product::find($product_id)->increment('stock', $qty);
            }

            return $purchase;
        });
    }

    public function getPurchaseList(Request $request)
    {
        $data  = Purchase::query();

        return DataTables::of($data)
            ->addColumn('date', function ($data) {
                return Carbon::parse($data->date)->format('d/m/Y');
            })
            ->addColumn('total_qty', function ($data) {
                return $data->product->sum('pivot.qty');
            })
            ->addColumn('action', function ($data) {
                $action = view('include.purchase.btn-action', compact('data'))->render();           
                return $action;
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
                    $instance->where(function ($w) use ($request) {
                        $search = $request->search;
                        $w->orWhere('purchase_number', 'LIKE', "%$search%");
                    });
                }

                return $instance;
            })
            ->rawColumns(['action', 'date', 'total_qty'])
            ->make(true);
    }
}
