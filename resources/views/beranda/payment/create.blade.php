@extends('layouts.general')
@section('title', 'Kirim Bukti Pembayaran')
@push('css')
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/sweetalert2/sweetalert2.min.css">
@endpush
@section('content')
    <div class="container py-2">
        <div class="card">
            <div class="card-header">
                <span>Kirim Bukti Pembayaran</span>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h6 class="text-center">Silahkan isi data pembayaran dan upload bukti transfer anda, agar admin kami dapat melakukan validasi pada pesanan anda!</h6>
                        <hr>
                    </div>
                </div>

                <div class="row d-flex justify-content-center">
                    <div class="col-md-8">
                        {!! Form::open([
                            'route' => ['payment.store', $sale],
                            'method' => 'POST',
                            'id' => 'form-payment',
                            'files' => true,
                        ]) !!}

                        <div class="row mb-3">
                            <label for="invoice_number" class="col-md-4 col-form-label text-md-end">No Pemesanan</label>

                            <div class="col">
                                {!! Form::text('invoice_number', $sale->sale_number, ['class' => 'form-control', 'id' => 'invoice_number', 'disabled' => true]) !!}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="destination_bank" class="col-md-4 col-form-label text-md-end">Bank Tujuan</label>

                            <div class="col">
                                {!! Form::text('destination_bank', $sale->bank->name, ['class' => 'form-control', 'id' => 'destination_bank', 'readonly' => true]) !!}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="sender_bank" class="col-md-4 col-form-label text-md-end">Bank Pengirim</label>
                            <div class="col">
                                {!! Form::text('sender_bank', null, ['class' => 'form-control', 'id' => 'sender_bank']) !!}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="sender_account_number" class="col-md-4 col-form-label text-md-end">Rekening Pengirim</label>
                            <div class="col">
                                {!! Form::text('sender_account_number', null, ['class' => 'form-control', 'id' => 'sender_account_number']) !!}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="sender_account_name" class="col-md-4 col-form-label text-md-end">Nama Pengirim</label>
                            <div class="col">
                                {!! Form::text('sender_account_name', null, ['class' => 'form-control', 'id' => 'sender_account_name']) !!}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="date" class="col-md-4 col-form-label text-md-end">Tanggal Transfer</label>
                            <div class="col">
                                {!! Form::date('date', null, ['class' => 'form-control', 'id' => 'date']) !!}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="transfer_proof" class="col-md-4 col-form-label text-md-end">Upload Bukti Transfer</label>

                            <div class="col">
                                <div class="input-group" id="photos">
                                    <div class="custom-file">
                                        <input type="file" class="form-control" id="transfer_proof" name="transfer_proof"
                                        onchange="previewImage()">
                                    </div>
                                </div>
                                <img class="rounded mt-3 mx-auto d-block col-md-10" id="preview">
                            </div>
                        </div>
                    
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">Kirim Bukti Pembayaran</a>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
@push('js')
    <script src="/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="/dist/js/payment/create.js"></script>
@endpush
