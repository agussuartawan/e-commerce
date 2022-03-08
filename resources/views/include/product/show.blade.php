{{-- //image album --}}
{{-- <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        @foreach ($product->image as $key => $image)
            <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}"
                @if ($key == 0) class="active" @endif></li>
        @endforeach
    </ol>
    <div class="carousel-inner" style="width:100%; height:400px !important;">
        @forelse ($product->image as $key => $image)
            <div class="carousel-item @if ($key == 0) active @endif">
                <img class="d-block w-100" src="{{ asset('storage/' . $image->path) }}" alt="Gambar Produk">
            </div>
        @empty
            <img src="{{ asset('') }}/img/no-image.jpg" class="rounded mx-auto d-block col-sm-4">
        @endforelse
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div> --}}
<div class="col-12">
    <div class="col-12">
        <img src="{{ asset('storage/' . $product->image()->first()->path) }}" class="product-image"
            alt="Product Image">
    </div>
    <div class="col-12 d-flex justify-content-center product-image-thumbs">
        @forelse ($product->image as $key => $image)
            <div class="product-image-thumb @if ($key == 0) active @endif"><img
                    src="{{ asset('storage/' . $image->path) }}" alt="Product Image"></div>
        @empty
            <img src="{{ asset('') }}/img/no-image.jpg" class="rounded mx-auto d-block col-sm-4">
        @endforelse
    </div>
</div>

<div class="d-flex justify-content-center mt-2">
    <h5><span class="badge badge-secondary mr-2" title="Kategori">{{ $product->category->name }}</span></h5>
    <h5><span class="badge badge-primary" title="Unit">{{ $product->product_unit->name }}</span></h5>
</div>

<div class="row">
    <div class="col-md-2">
        <span class="col-form-label text-md-end">Kode</span>
    </div>

    <div class="col-md-6">
        <p>{{ $product->code }}</p>
    </div>
</div>

<div class="row">
    <div class="col-md-2">
        <span class="col-form-label text-md-end">Nama Produk</span>
    </div>

    <div class="col-md-6">
        <p>{{ $product->product_name }}</p>
    </div>
</div>

<div class="row">
    <div class="col-md-2">
        <span class="col-form-label text-md-end">Harga Jual</span>
    </div>

    <div class="col-md-6">
        <p>{{ rupiah($product->selling_price) }}</p>
    </div>
</div>

<div class="row">
    <div class="col-md-2">
        <span class="col-form-label text-md-end">Sisa Stok</span>
    </div>

    <div class="col-md-6">
        <p>{{ rupiah($product->stock) }}</p>
    </div>
</div>

<div class="row">
    <div class="col-md-2">
        <span class="col-form-label text-md-end">Deskripsi</span>
    </div>

    <div class="col-md-6">
        <p>{{ $product->description }}</p>
    </div>
</div>

<div class="row text-center">
    <div class="col">
        <div class="row">
            <div class="col">
                <span class="col-form-label text-md-end">Aroma Tersedia</span>
            </div>
        </div>

        <div class="row">
            <div class="col">
                @if ($product->product_fragrance)
                    @foreach ($product->product_fragrance as $fragrance)
                        <span class="badge badge-info mr-2" title="Aroma">{{ $fragrance->name }}</span>
                    @endforeach
                @else
                    <p>-</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col">
        <div class="row">
            <div class="col">
                <span class="col-form-label text-md-end">Warna Tersedia</span>
            </div>
        </div>

        <div class="row">
            <div class="col">
                @if ($product->product_color)
                    @foreach ($product->product_color as $color)
                        <span class="badge mr-2" style="background-color: {{ $color->hex_color }}!important;"
                            title="Warna">{{ $color->name }}</span>
                    @endforeach
                @else
                    <p>-</p>
                @endif
            </div>
        </div>

    </div>

</div>
