<div class="btn-group" role="group">
    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        Pilih Aksi
    </button>
    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
        <a class='dropdown-item btn-show' href='{{ route('products.show', $data) }}'
            title='Detail {{ $data->product_name }}'>Detail</a>
        <a class='dropdown-item modal-edit' href='{{ route('products.edit', $data) }}'
            title='Edit data {{ $data->product_name }}'>Edit</a>
        @if (!$data->sale()->exists())
            <a class='dropdown-item btn-delete' href='{{ route('products.destroy', $data) }}'
                title='Hapus data {{ $data->product_name }}'>Hapus</a>
        @endif
        <a class='dropdown-item btn-image' href='{{ route('product.image-form', $data) }}'
            title='Gambar {{ $data->product_name }}'>Kelola Gambar</a>
    </div>
</div>
