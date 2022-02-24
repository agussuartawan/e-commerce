@extends('layouts.general')
@section('title', 'Detail Produk')
@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col d-flex justify-content-end">
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
                @if ($product->photo)
                    <img src="{{ asset('storage/' . $product->photo) }}" alt="..." class="img-thumbnail">
                @else
                    <img src="{{ asset('') }}/img/no-image.jpg" alt="..." class="img-thumbnail">
                @endif
            </div>
            <div class="col-md-6">
                <h4>{{ $product->product_name }}</h4>
                <h6>Harga Rp. {{ rupiah($product->selling_price) }} / {{ $product->size }}
                    {{ $product->product_unit->name }}</h6>
                <h6>Sisa stok {{ $product->stock }}</h6>

                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                <span class="col-form-label text-md-end">Aroma Tersedia</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                @foreach ($product->product_fragrance as $fragrance)
                                    <span class="badge badge-info mr-2" title="Aroma">{{ $fragrance->name }}</span>
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

                        <div class="row">
                            <div class="col">
                                @foreach ($product->product_color as $color)
                                    <span class="badge mr-2"
                                        style="background-color: {{ $color->hex_color }}!important;"
                                        title="Warna">{{ $color->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('order.create', $product) }}" class="btn btn-primary mt-4">Beli Produk Ini</a>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
                <h6>Deskripsi produk</h6>
                <p>{{ $product->description }}</p>
            </div>
        </div>
    </div>
@endsection
