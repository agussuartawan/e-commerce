@extends('layouts.general')
@section('title', 'Beranda')
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
            @foreach ($products as $product)
                <div class="col-md-4 d-flex justify-content-center py-2">
                    <div class="card" style="width: 18rem;">
                        @if ($product->photo)
                            <img class="card-img-top" src="{{ asset('storage/' . $product->photo) }}"
                                alt="Card image cap">
                        @else
                            <img class="card-img-top" src="/img/no-image.jpg" alt="Card image cap">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->product_name }}</h5>
                            <h6>Rp. {{ rupiah($product->selling_price) }}</h6>
                            <hr>
                            <p class="card-text">{{ $product->description }}</p>
                            <a href="{{ route('product.show', $product) }}" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
