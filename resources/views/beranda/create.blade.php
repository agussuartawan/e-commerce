@extends('layouts.general')
@section('title', 'Order')
@section('content')
<div class="container py-2">
    {!! Form::open([
        'route' => ['order.store', $product->id],
        'method' => 'POST',
        'id' => 'form-order'
    ]) !!}

    <div class="card">
        <div class="card-header">
            <span>Pemesanan</span>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h4>{{ $product->product_name }}</h4>
                    <h5>Rp. {{ rupiah($product->selling_price) }} / {{ $product->product_unit->name }}</h5>
                </div>
                <div class="col text-right">
                    <h4>Total (Rp)</h4>
                </div>
                <div class="d-flex flex-column text-right pr-3">
                    <h4 id="discount_total">120.000.000</h4>
                </div>
            </div>
        
            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="qty">Jumlah Barang</label>
                    <div class="input-group">
                        <div class="input-group-btn">
                            <button class="btn btn-default btn-number" data-type="minus" data-field="qty">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control input-number" name="qty" id="qty" value="1" min="1" max="1000">
                        <div class="input-group-btn">
                            <button class="btn btn-default btn-number" data-type="plus" data-field="qty">
                                <i class="fas fa-plus"></i>
                            </button>
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
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="address">Tujuan Pengiriman</label>
                        {!! Form::textarea('address', auth()->user()->customer->address, ['class' => 'form-control', 'rows' => 2, 'id' => 'address']) !!}
                    </div>
                </div>
            </div>
        
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="province">Provinsi</label>
                        {!! Form::select('province_id', ['Bali'], null, ['class' => 'form-control custom-select', 'id' => 'province']) !!}
                    </div>
                </div>
        
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="city">Kota</label>
                        {!! Form::select('city_id', ['Denpasar', 'Badung'], null, ['class' => 'form-control custom-select', 'id' => 'city']) !!}
                    </div>
                </div>
        
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="bank">Bank Tujuan</label>
                        {!! Form::select('bank_id', ['BCA', 'Mandiri'], null, ['class' => 'form-control custom-select', 'id' => 'bank']) !!}
                    </div>
                </div>
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
    <script src="/dist/js/order/create.js"></script>
@endpush