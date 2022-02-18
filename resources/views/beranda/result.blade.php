@extends('layouts.general')
@section('title', 'Pemesanan Berhasil')
@section('content')
    <div class="container py-2">
        <div class="card">
            <div class="card-header">
                <span>Pemesanan Berhasil</span>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="text-center">Segera selesaikan pembayaran anda sebelum batas waktu habis.</h5>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col">
                        <div class="card">
                            <input type="hidden" value="{{ $due }}" id="input_due">
                            <h6 class="text-center mt-2">Sisa waktu pembayaran anda.</h6>
                            <h1 class="text-center" id="countdown"></h1>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6>Transfer pembayaran ke nomor rekening:</h6>
                        <h6>{{ $sale->bank->name }} <strong>{{ $sale->bank->account_number }}</strong> a/n
                            {{ $sale->bank->account_name }}</h6>
                        <h6 class="mt-5">Jumlah yang harus dibayarkan</h6>
                        <input type="text" value="Rp. {{ rupiah($sale->grand_total) }}" class="form-control col-sm-5"
                            readonly>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-center">
                <a href="{{ route('payment.create', $sale) }}" class="btn btn-primary">Kirim Pembayaran</a>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="/dist/js/order/result.js"></script>
@endpush
