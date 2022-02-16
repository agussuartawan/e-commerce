<div class="row mb-3">
    <div class="col">
        <h6>
            <strong>No. Pesanan : {{ $sale->sale_number }}</strong>
            &ensp;
            @if ($sale->delivery_status == 'dikirim')
                <span class="badge badge-success">{{ $sale->delivery_status }}</span>
            @elseif($sale->delivery_status == 'dalam pengiriman')
                <span class="badge badge-warning">{{ $sale->delivery_status }}</span>
            @elseif($sale->payment_status == 'menunggu pembayaran')
                <span class="badge badge-secondary">{{ $sale->payment_status }}</span>
            @endif
        </h6>
    </div>
</div>

<div class="row mb-3">
    <div class="col">
        <h6>Nama Pelanggan</h6>
        <h6><strong>{{ $sale->customer->fullname }}</strong></h6>
    </div>
</div>
<hr>
<div class="row mb-3">
    <div class="col-md-4">
        <h6>Total Pembayaran</h6>
        <h6><strong>
                @if ($sale->payment)
                    Rp. {{ rupiah($sale->grand_total) }}
                @else
                    -
                @endif
            </strong></h6>
    </div>

    <div class="col-md-4">
        <h6>Waktu Pembayaran</h6>
        <h6><strong>
                @if ($sale->payment)
                    {{ \Carbon\Carbon::parse($sale->payment->date)->isoFormat('DD MMMM Y') }}
                @else
                    -
                @endif
            </strong></h6>
    </div>

    <div class="col-md-4">
        <h6>Metode Pembayaran</h6>
        <h6>
            @if ($sale->payment)
                <strong>Transfer ke {{ $sale->bank->name }} {{ $sale->bank->account_number }}</strong>
            @else
                -
            @endif
        </h6>
    </div>
</div>
<hr>
<div class="row mb-3">
    <div class="col">
        <h6>Rincian Pengiriman</h6>
        <h6>{{ $sale->address }}, {{ $sale->city->name }}, {{ $sale->province->name }}</h6>
    </div>
</div>
<hr>
<div class="row mb-2">
    <div class="col">
        <h6><strong>Rincian Pesanan</strong></h6>
        <h6>{{ $sale->product->product_name }}
            {{ $sale->product->size }}{{ $sale->product->product_unit->name }} &emsp;&emsp; Rp.
            {{ rupiah($sale->product->selling_price) }} x {{ $sale->qty }}</h6>
        <small>&emsp;(Variasi : {{ $sale->product_color->name }},
            {{ $sale->product_fragrance->name }})</small>
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <h6>Catatan</h6>
        @if ($sale->note)
            <small>&emsp;{{ $sale->note }}</small>
        @else
            <small>&emsp;-</small>
        @endif
    </div>
</div>
<hr>
<div class="row">
    <div class="col-sm-6">
        <span>Subtotal untuk Produk</span>
    </div>
    <div class="col">
        <span>Rp. {{ rupiah($sale->grand_total) }}</span>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <h6><strong>Total</strong></h6>
    </div>
    <div class="col">
        <h6><strong>Rp. {{ rupiah($sale->grand_total) }}</strong></h6>
    </div>
</div>
