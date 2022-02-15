<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PaymentController extends Controller
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
        return view('panel.payment.index', compact('now'));
    }

    public function paymentConfirm(Sale $sale)
    {
        $sale->payment_status = 'lunas';
        $sale->save();

        return $sale;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function getPaymentList(Request $request)
    {

        $data  = Payment::query();

        return DataTables::of($data)
            ->addColumn('sale_number', function ($data) {
                return $data->sale->sale_number;
            })
            ->addColumn('date', function ($data) {
                return Carbon::parse($data->date)->format('d/m/Y');
            })
            ->addColumn('transfer_proof', function ($data) {           
                return '<a href="/storage/'. $data->transfer_proof .'" class="btn btn-sm btn-outline-primary btn-block" target=”_blank”>Lihat</a>';
            })
            ->addColumn('payment_status', function ($data) {  
                if($data->sale->payment_status == 'lunas'){
                    return '<span class="badge badge-success">selesai</span>';
                }         

                $confirm = '<form action="/payment/'.$data->sale->id.'/confirm" method="POST" class="d-none form-confirm'.$data->sale->id.'">';
                $confirm .= '<input type="hidden" value="'.csrf_token().'" name="_token">';
                $confirm .= '<input type="hidden" value="PUT" name="_method">';
                $confirm .= '</form>';                
                $confirm .= '<a href="#" class="btn btn-sm btn-outline-info btn-block btn-confirm" data-id="form-confirm'.$data->sale->id.'">Konfirmasi</a>';

                return $confirm;
            })
            ->addColumn('action', function ($data) {
                $buttons = '<div class="row"><div class="col">';
                $buttons .= '<a href="/payments/'. $data->id .'" class="btn btn-sm btn-outline-success btn-block btn-show">Detail</a>';
                $buttons .= '</div><div class="col">';
                $buttons .= '<a href="/payments/'. $data->id .'/edit" class="btn btn-sm btn-outline-info btn-block modal-edit">Edit</a>';
                $buttons .= '</div></div>';                

                return $buttons;
            })
            ->filter(function ($instance) use ($request) {
                if ($request->dateFilter) {
                    $from = explode(" / ", $request->dateFilter)[0];
                    $to = explode(" / ", $request->dateFilter)[1];

                    $date['from'] = Carbon::parse($from)->startOfDay()->format('Y-m-d H:i:s');
                    $date['to'] = Carbon::parse($to)->endOfDay()->format('Y-m-d H:i:s');
                    $instance->whereBetween('payments.date', $date);
                }
                if (!empty($request->search)) {
                    $instance->join('sales', 'sales.id', '=', 'payments.sale_id')
                                ->where(function ($w) use ($request) {
                                    $search = $request->search;
                                    $w->orWhere('sales.sale_number', 'LIKE', "%$search%")
                                        ->orWhere('sender_account_name', 'LIKE', "%$search%");
                                });
                }

                return $instance;
            })
            ->rawColumns(['action',' customer', 'date', 'sale_number', 'transfer_proof', 'payment_status'])
            ->make(true);
    }
}
