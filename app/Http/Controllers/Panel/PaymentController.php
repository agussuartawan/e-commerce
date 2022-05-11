<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentStatus;
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
        $now = $from . ' s/d ' . $to;
        return view('panel.payment.index', compact('now'));
    }

    public function paymentConfirm(Sale $sale)
    {
        $sale = \DB::transaction(function() use($sale) {
            $sale->payment_status_id = PaymentStatus::LUNAS;
            $sale->save();

            return $sale;
        });

        return $sale;
    }

    public function show(Payment $payment)
    {
        return view('include.payment.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        return view('include.payment.edit', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        $messages = [
            'destination_bank.required' => 'Bank tujuan tidak boleh kosong!',
            'destination_bank.max' => 'Bank tujuan tidak boleh lebih dari 255 huruf!',
            'sender_bank.required' => 'Bank pengirim tidak boleh kosong!',
            'sender_bank.max' => 'Bank pengirim tidak boleh lebih dari 255 huruf!',
            'sender_account_number.required' => 'Rekening pengirim tidak boleh kosong!',
            'sender_account_number.max' => 'Rekening pengirim tidak boleh lebih dari 255 huruf!',
            'sender_account_name.required' => 'Nama pengirim tidak boleh kosong!',
            'sender_account_name.max' => 'Nama pengirim tidak boleh lebih dari 255 huruf!',
            'date.required' => 'Tanggal transfer tidak boleh kosong!',
            'date.date' => 'Tanggal transfer tidak valid!',
        ];

        $validated = $request->validate([
            'destination_bank' => ['required', 'max:255'],
            'sender_bank' => ['required', 'max:255'],
            'sender_account_name' => ['required', 'max:255'],
            'sender_account_number' => ['required', 'max:255'],
            'date' => ['required', 'date'],
        ], $messages);

        return $payment->update($validated);
    }

    public function getPaymentList(Request $request)
    {
        $data  = Payment::query();

        return DataTables::of($data)
            ->addColumn('sale_number', function ($data) {
                return $data->getSaleNumber();
            })
            ->addColumn('date', function ($data) {
                $date = Carbon::parse($data->date)->isoFormat('DD MMMM Y');
                return $date;
            })
            ->addColumn('transfer_proof', function ($data) {    
                $action = view('include.payment.btn-transfer-proof', compact('data'))->render();            
                return $action;
            })
            ->addColumn('payment_status', function ($data) {  
                if($data->sale->payment_status_id == PaymentStatus::LUNAS){
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
                $action = view('include.payment.btn-action', compact('data'))->render();            
                return $action;
            })
            ->filter(function ($instance) use ($request) {
                if ($request->dateFilter) {
                    $from = explode(" s/d ", $request->dateFilter)[0];
                    $to = explode(" s/d ", $request->dateFilter)[1];

                    $date['from'] = Carbon::parse($from)->startOfDay()->format('Y-m-d H:i:s');
                    $date['to'] = Carbon::parse($to)->endOfDay()->format('Y-m-d H:i:s');
                    $instance->whereBetween('payments.date', $date);
                }
                if ($request->payment_status) {
                    $instance->whereHas('sale', function($query) use ($request){
                        $payment_status = $request->payment_status;
                        $query->where('payment_status_id', '=', $payment_status);
                    })
                    ->with(['sale' => function($query) use ($request){
                        $payment_status = $request->payment_status;
                        $query->where('payment_status_id', '=', $payment_status);
                    }]);
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
            ->rawColumns(['sale_number', 'action',' customer', 'date', 'transfer_proof', 'payment_status'])
            ->make(true);
    }
}
