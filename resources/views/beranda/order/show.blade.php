@extends('layouts.general')
@section('title', 'Detail Pemesanan')
@section('content')
    <div class="container py-2">
        <div class="row d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h6>Detail Pemesanan</h6>
                    </div>

                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col">
                                <h6><strong>No. Pesanan : {{ $sale->sale_number }}</strong></h6>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6>Total Pembayaran</h6>
                                <h6><strong>
                                        @if ($sale->payment)
                                            Rp. {{ rupiah($sale->grand_total) }}
                                        @else
                                            Belum melakukan pembayaran
                                        @endif
                                    </strong></h6>
                            </div>

                            <div class="col-md-6">
                                <h6>Waktu Pembayaran</h6>
                                <h6><strong>
                                        @if ($sale->payment)
                                            {{ \Carbon\Carbon::parse($sale->payment->date)->isoFormat('DD MM YYYY') }}
                                        @else
                                            Belum melakukan pembayaran
                                        @endif
                                    </strong></h6>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6>Rincian Pengiriman</h6>
                                <h6>{{ $sale->address }}, {{ $sale->city->name }}, {{ $sale->province->name }}</h6>
                            </div>

                            <div class="col-md-6">
                                <h6>Metode Pembayaran</h6>
                                <h6>
                                    @if ($sale->payment)
                                        Transfer ke {{ $sale->bank->name }} {{ $sale->bank->account_number }}
                                    @else
                                        Belum melakukan pembayaran
                                    @endif
                                </h6>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <div class="col">
                                <h6><strong>Rincian Pesanan</strong></h6>
                                <h6>{{ $sale->product->product_name }}
                                    {{ $sale->product->size }}{{ $sale->product->product_unit_name }} &emsp;&emsp; Rp.
                                    {{ rupiah($sale->product->selling_price) }} x {{ $sale->qty }}</h6>
                                <small>(Variasi : {{ $sale->product_color->name }},
                                    {{ $sale->product_fragrance->name }})</small>
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
                    </div>

                    <div class="card-footer d-flex justify-content-center">
                        <a href="{{ route('delivery.index') }}" class="btn btn-danger mr-2">Kembali</a>
                        <a href="{{ route('order.invoice', $sale) }}" class="btn btn-primary" target="_blanc">Cetak Nota
                            Pembelian</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
