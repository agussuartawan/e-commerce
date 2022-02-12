@extends('layouts.general')
@section('title', 'Detail Produk')
@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-end">
                <form class="form-inline">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <select name="" id="" class="form-control mr-sm-2 custom-select my-2">
                        <option value="0">Semua</option>
                        @foreach ($categories as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-success my-sm-0" type="submit">Cari</button>
                </form>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6 py-2">
                @if($product->photo)
                <img src="{{ asset('storage/' . $product->photo) }}" alt="..." class="img-thumbnail">
                @else
                <img src="/img/no-image.jpg" alt="..." class="img-thumbnail">
                @endif
            </div>
            <div class="col-md-6">
                <h5>{{ $product->product_name }}</h5>
                <p>Harga  Rp. {{ rupiah($product->selling_price) }} / {{ $product->size}} {{$product->product_unit->name }}</p>

                <a href="#" class="btn btn-primary">Beli</a>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <h6>Deskripsi produk</h6>
                <p>{{ $product->description }}</p>
            </div>
        </div>
    </div>
@endsection
