<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('panel.purchase.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $purchase = new Purchase();
        return view('include.purchase.form', compact('purchase'));
    }

    public function showInputProduct(Request $request)
    {
        $row = $request->row;
        return view('include.purchase.input-product', compact('row'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    public function getPurchaseList(Request $request)
    {
        $data  = Purchase::query();

        return DataTables::of($data)
            ->addColumn('date', function ($data) {
                return Carbon::parse($data->date)->format('d/m/Y');
            })
            ->addColumn('action', function ($data) {
                $buttons = '<div class="row">';

                $buttons .= '<div class="col">';
                $buttons .= '<a href="/purchases/'. $data->id .'" class="btn btn-sm btn-outline-success btn-block btn-show" title="Detail '.$data->purchase_number.'" data-id="'.$data->id.'">Detail</a>';
                $buttons .= '</div>';
                
                if($data->is_cancel != 1){
                    $buttons .= '<div class="col">';
                    $buttons .= '<a href="/purchases/'. $data->id .'/edit" class="btn btn-sm btn-outline-info btn-block modal-edit" title="Edit '.$data->purchase_number.'">Edit</a>';
                    $buttons .= '</div>';
                }

                $buttons .= '</div>';       

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
                    $instance->where(function ($w) use ($request) {
                        $search = $request->search;
                        $w->orWhere('purchase_number', 'LIKE', "%$search%");
                    });
                }

                return $instance;
            })
            ->rawColumns(['action', 'date'])
            ->make(true);
    }
}
