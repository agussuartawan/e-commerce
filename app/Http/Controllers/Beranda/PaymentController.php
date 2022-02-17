<?php

namespace App\Http\Controllers\Beranda;

use App\Models\Sale;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PaymentStatus;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function create(Sale $sale)
    {
        if($sale->user_id != Auth::user()->id){
            abort(404);
        } else if($sale->payment_status_id == PaymentStatus::LUNAS || $sale->payment_status_id == PaymentStatus::MENUNGGU_KONFIRMASI){
            return redirect()->route('order.show', $sale);
        } else if($sale->payment_status_id == PaymentStatus::DIBATALKAN){
            return redirect()->route('beranda');
        }

        return view('beranda.payment.create', compact('sale'));
    }

    public function store(Request $request, Sale $sale)
    {
        $result;
        DB::transaction(function () use ($request, $sale, &$result) {
            // validasi input
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
                'transfer_proof.required' => 'Bukti transfer tidak boleh kosong!',
                'transfer_proof.image' => 'Bukti transfer harus berupa gambar!',
                'transfer_proof.max' => 'Bukti tidak boleh melebihi 500kb!',
            ];

            $validated = $request->validate([
                'destination_bank' => ['required', 'max:255'],
                'sender_bank' => ['required', 'max:255'],
                'sender_account_name' => ['required', 'max:255'],
                'sender_account_number' => ['required', 'max:255'],
                'date' => ['required', 'date'],
                'transfer_proof' => ['required', 'image', 'file', 'max:512'],
            ], $messages);

            // ubah status pembayaran menjadi menunggu konfirmasi
            $sale->payment_status_id = PaymentStatus::MENUNGGU_KONFIRMASI;
            $sale->save();

            // upload foto bukti transfer
            if($request->file('transfer_proof')){
                $validated['transfer_proof'] = $request->file('transfer_proof')->store('transfer-proof');
            }

            // insert ke table payment
            $payment = Payment::create([
                'sale_id' => $sale->id,
                'user_id' => Auth::user()->id,
                'destination_bank' => $validated['destination_bank'], 
                'sender_bank' => $validated['sender_bank'], 
                'sender_account_name' => $validated['sender_account_name'], 
                'sender_account_number' => $validated['sender_account_number'], 
                'date' => $validated['date'], 
                'transfer_proof' => $validated['transfer_proof']
            ]);

            return $result = $payment;
        });

        return $result;
    }

    public function index()
    {
        $payments = Payment::with('sale')->where('user_id', Auth::user()->id)->paginate(10);
        return view('beranda.payment.index', compact('payments'));
    }
}
