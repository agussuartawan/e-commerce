<img @if ($product->photo)
src="{{ asset('storage/' . $product->photo) }}"
@else
src="/img/no-image.jpg"
@endif
class="rounded mx-auto d-block col-sm-4">

<div class="d-flex justify-content-center mt-2">
    <h5><span class="badge badge-secondary mr-2">{{ $product->category->name }}</span></h5>
    <h5><span class="badge badge-secondary mr-2">{{ $product->product_fragrance->name }}</span></h5>
    <h5><span class="badge badge-secondary mr-2">{{ $product->product_unit->name }}</span></h5>
    <h5><span class="badge badge-secondary">{{ $product->product_color->name }}</span></h5>
</div>

<div class="row">
    <span class="col-md-2 col-form-label text-md-end">Kode</span>

    <div class="col-md-6">
        <p>{{ $product->code }}</p>
    </div>
</div>

<div class="row">
    <span class="col-md-2 col-form-label text-md-end">Nama Produk</span>

    <div class="col-md-6">
        <p>{{ $product->product_name }}</p>
    </div>
</div>

<div class="row">
    <span class="col-md-2 col-form-label text-md-end">Harga Jual</span>

    <div class="col-md-6">
        <p>{{ rupiah($product->selling_price) }}</p>
    </div>
</div>

<div class="row">
    <span class="col-md-2 col-form-label text-md-end">Sisa Stok</span>

    <div class="col-md-6">
        <p>{{ rupiah($product->stock) }}</p>
    </div>
</div>

<div class="row">
    <span class="col-md-2 col-form-label text-md-end">Deskripsi</span>

    <div class="col-md-6">
        <p>{{ $product->description }}</p>
    </div>
</div>
