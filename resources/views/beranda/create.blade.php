@extends('layouts.general')
@section('title', 'Order')
@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('') }}/plugins/sweetalert2/sweetalert2.min.css">
        <link rel="stylesheet" href="{{ asset('') }}/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="{{ asset('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    @endpush
    <div class="container py-2">
        {!! Form::open([
    'route' => ['order.store', $product->id],
    'method' => 'POST',
    'id' => 'form-order',
]) !!}

        <div class="card">
            <div class="card-header">
                <span>Pemesanan</span>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h4>{{ $product->product_name }}</h4>
                        <h5>Rp. {{ rupiah($product->selling_price) }} / {{ $product->product_unit->name }}</h5>
                        <input type="hidden" id="price" value="{{ $product->selling_price }}">
                    </div>
                </div>

                <div class="row py-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col">
                                <label for="qty">Jumlah Barang</label>
                                <div class="input-group" id="input-qty">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default btn-number" data-type="minus" data-field="qty">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control input-number" name="qty" id="qty" value="1"
                                        min="1" max="1000">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default btn-number" data-type="plus" data-field="qty">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <span class="col-form-label text-md-end">Aroma Tersedia</span>
                                    </div>
                                </div>

                                <div class="row fragrance-row">
                                    <div class="col">
                                        @foreach ($product->product_fragrance as $key => $fragrance)
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="product_fragrance_id{{ $key }}"
                                                    name="product_fragrance_id" class="custom-control-input"
                                                    value="{{ $fragrance->id }}">
                                                <label class="custom-control-label"
                                                    for="product_fragrance_id{{ $key }}">{{ $fragrance->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <span class="col-form-label text-md-end">Warna Tersedia</span>
                                    </div>
                                </div>

                                <div class="row color-row">
                                    <div class="col">
                                        @foreach ($product->product_color as $key => $color)
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="product_color_id{{ $key }}"
                                                    name="product_color_id" class="custom-control-input"
                                                    value="{{ $color->id }}">
                                                <label class="custom-control-label"
                                                    for="product_color_id{{ $key }}">{{ $color->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="note">Catatan</label>
                            {!! Form::textarea('note', null, ['class' => 'form-control', 'rows' => 2, 'id' => 'note']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="province">Provinsi</label>
                            {!! Form::select('province_id', [], null, ['class' => 'form-control custom-select', 'id' => 'province_id']) !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="city">Kota</label>
                            {!! Form::select('city_id', [], null, ['class' => 'form-control custom-select', 'id' => 'city_id']) !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="bank">Bank Tujuan</label>
                            {!! Form::select('bank_id', [], null, ['class' => 'form-control custom-select', 'id' => 'bank_id']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="address">Tujuan Pengiriman</label>
                            <br>
                            <small>Mohon cek kembali apakah alamat pengiriman anda sudah benar!</small>
                            {!! Form::textarea('address', auth()->user()->customer->address, ['class' => 'form-control', 'rows' => 2, 'id' => 'address']) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col text-right">
                    <h5>Subtotal (Rp)</h5>
                    <h5>Ongkir (Rp)</h5>
                    <h4>Total (Rp)</h4>
                </div>
                <div class="d-flex flex-column text-right pr-5">
                    <h5 id="sub_total">0</h5>
                    <h5 id="ongkir">0</h5>
                    <h4 id="grand_total">0</h4>
                    <input type="hidden" id="shipping" value="{{ \App\Models\Sale::ONGKIR }}">
                </div>
            </div>

            <div class="card-footer d-flex justify-content-center">
                <a href="{{ route('product.show', $product) }}" class="btn btn-danger mr-2">Batal</a>
                <button type="submit" class="btn btn-primary">Buat Pesanan</button>
            </div>
        </div>

        {!! Form::close() !!}
    </div>
@endsection
@push('js')
    <script src="{{ asset('') }}/plugins/select2/js/select2.full.min.js"></script>
    <script src="{{ asset('') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ asset('') }}/dist/js/order/create.js"></script>
@endpush
