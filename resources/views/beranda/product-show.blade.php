@extends('layouts.general')
@section('title', 'Detail Produk')
@push('css')
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <style>
        .dot {
            height: 35px;
            width: 35px;
            border-radius: 50%;
            display: inline-block;
        }

    </style>
@endpush
@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col d-flex justify-content-end">
                <form class="form-inline">
                    <input class="form-control mr-sm-2" id="search" type="search" placeholder="Search" aria-label="Search">
                    <select name="category_id" id="category_id" class="form-control mr-sm-2 custom-select my-2">
                        <option value="0">Semua</option>
                        @foreach ($categories as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-success my-sm-0" type="submit" id="btn-search">Cari</button>
                </form>
            </div>
        </div>
        <hr>
        <div class="card card-solid mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-inline-block d-sm-none">{{ $product->product_name }}</h3>
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                @foreach ($product->image as $key => $image)
                                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}"
                                        class="@if ($key == 0) active @endif">
                                    </li>
                                @endforeach
                            </ol>
                            <div class="carousel-inner">
                                @forelse ($product->image as $key => $image)
                                    <div class="carousel-item @if ($key == 0) active @endif">
                                        <img class="d-block w-100" src="{{ asset('storage/' . $image->path) }}"
                                            alt="Gambar {{ $key + 1 }}">
                                    </div>
                                @empty
                                    <div class="carousel-item active">
                                        <img class="
                                        d-block w-100"
                                            src="{{ asset('') }}/img/no-image.jpg" alt="Tidak ada gambar">
                                    </div>
                                @endforelse
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                                data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <h3 class="my-3">{{ $product->product_name }}</h3>
                        <hr>
                        <h4>Warna Tersedia</h4>
                        @foreach ($product->product_color as $color)
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-default text-center active">
                                    <input type="radio" name="color_option" id="color_option_a1" autocomplete="off" checked>
                                    {{ $color->name }}
                                    <br>
                                    <span class="dot"
                                        style="background-color: {{ $color->hex_color }};"></span>
                                </label>
                            </div>
                        @endforeach

                        <h4 class="mt-3">Aroma Tersedia</h4>
                        @foreach ($product->product_fragrance as $item)
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-default text-center">
                                    <input type="radio" name="color_option" id="color_option_b1" autocomplete="off">
                                    <span>{{ $item->name }}</span>
                                </label>
                            </div>
                        @endforeach
                        <div class="bg-gray py-2 px-3 mt-4">
                            <h2 class="mb-0">
                                Rp. {{ rupiah($product->selling_price) }} / {{ $product->size }}
                                {{ $product->product_unit->name }}
                            </h2>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('order.create', $product) }}" class="btn btn-primary btn-lg btn-flat">
                                <i class="fas fa-cart-plus fa-lg mr-2"></i>
                                Beli Produk Ini
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <nav class="w-100">
                        <div class="nav nav-tabs" id="product-tab" role="tablist">
                            <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc"
                                role="tab" aria-controls="product-desc" aria-selected="true">Deskripsi</a>
                        </div>
                    </nav>
                    <div class="tab-content p-3" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="product-desc" role="tabpanel"
                            aria-labelledby="product-desc-tab">
                            {{ $product->description }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $("body").on("click", ".product-image-thumb", function() {
                var $image_element = $(this).find("img");
                $(".product-image").prop("src", $image_element.attr("src"));
                $(".product-image-thumb.active").removeClass("active");
                $(this).addClass("active");
            });
        })

        $("#btn-search").click(function(event) {
            event.preventDefault();
            search();
        });

        $('input[type="search"').unbind();
        $('input[type="search"').bind("keyup", function(e) {
            if (e.keyCode == 13) {
                search();
            }
        });

        search = () => {
            const search = $("#search").val();
            const category_id = $("#category_id").val();
            window.location.href = `/beranda?search=${search}&category_id=${category_id}`;
        }
    </script>
@endpush
