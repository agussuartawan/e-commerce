@extends('layouts.general')
@section('title', 'Beranda')
@push('css')
    <style>
        .module {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            /* number of lines to show */
            line-clamp: 3;
            -webkit-box-orient: vertical;
        }

    </style>
@endpush
@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-end">
                <div class="form-inline">
                    <input class="form-control mr-sm-2" type="search" value="{{ $search }}" name="search"
                        placeholder="Search" aria-label="Search" id="search">
                    <select name="category_id" id="category_id" class="form-control mr-sm-2 custom-select my-2">
                        <option value="0">Semua</option>
                        @foreach ($categories as $item)
                            <option value="{{ $item->id }}" @if ($category_id == $item->id) selected @endif>
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-success my-sm-0" id="btn-search">Cari</button>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            @forelse ($products as $product)
                <div class="col d-flex justify-content-center py-2">
                    <div class="card" style="width: 21rem;">
                        @if ($product->image()->exists())
                            <img class="card-img-top" src="{{ asset('storage/' . $product->image()->first()->path) }}"
                                alt="Card image cap">
                        @else
                            <img class="card-img-top" src="{{ asset('') }}/img/no-image.jpg" alt="Card image cap">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->product_name }}</h5>
                            <h6>Sisa stok : {{ $product->stock }}</h6>
                            <h6>Rp. {{ rupiah($product->selling_price) }}</h6>
                            <h6>Terjual : {{ $product->sale()->sum('qty') }}</h6>
                            <hr>
                            <div class="module">
                                {{ $product->description }}
                            </div>
                            <a href="{{ route('product.show', $product) }}" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col py-2">
                    <p class="text-center">Tidak ada data.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('') }}/dist/js/beranda/index.js"></script>
    <script>
        $("body").on("click", "#btn-search", function(event) {
            event.preventDefault();
            const search = $("#search").val();
            const category_id = $("#category_id").val();
            window.location.href = `/beranda?search=${search}&category_id=${category_id}`;
        });
    </script>
@endpush
