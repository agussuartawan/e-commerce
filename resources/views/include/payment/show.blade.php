<div class="row mb-3">
    <div class="col">
        <h6>
            <strong>No. Pesanan : {{ $payment->sale->sale_number }}</strong>
            &ensp;
            @if ($payment->sale->payment_status_id == \App\Models\PaymentStatus::LUNAS)
                <span class="badge badge-success">{{ $payment->sale->payment_status->name }}</span>
            @elseif($payment->sale->payment_status_id == \App\Models\PaymentStatus::MENUNGGU_PEMBAYARAN)
                <span class="badge badge-warning">{{ $payment->sale->payment_status->name }}</span>
            @elseif($payment->sale->payment_status_id == \App\Models\PaymentStatus::MENUNGGU_KONFIRMASI)
                <span class="badge badge-warning">{{ $payment->sale->payment_status->name }}</span>
            @elseif($payment->sale->is_cancle == 1)
                <span class="text-italic text-danger">(Dibatalkan)</span>
            @endif
        </h6>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <h6>Total Pembayaran</h6>
        <h6><strong>Rp. {{ rupiah($payment->sale->grand_total) }}</strong></h6>
    </div>

    <div class="col-md-6">
        <h6>Waktu Pembayaran</h6>
        <h6><strong>{{ \Carbon\Carbon::parse($payment->date)->isoFormat('DD MMMM Y') }}</strong></h6>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-3">
        <h6>Nama Pengirim</h6>
        <h6><strong>{{ $payment->sender_account_name }}</strong></h6>
    </div>

    <div class="col-md-3">
        <h6>Bank Pengirim</h6>
        <h6><strong>{{ $payment->sender_bank }}</strong></h6>
    </div>

    <div class="col-md-3">
        <h6>Bank Tujuan</h6>
        <h6><strong>{{ $payment->destination_bank }}</strong></h6>
    </div>

    <div class="col-md-3">
        <h6>No Rekening Pengirim</h6>
        <h6><strong>{{ $payment->sender_account_number }}</strong></h6>
    </div>
</div>
