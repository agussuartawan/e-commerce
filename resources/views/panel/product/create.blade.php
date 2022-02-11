@extends('layouts.panel')
@section('title', 'Tambah Produk')
@push('css')
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endpush
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Produk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produk</a>
                        </li>
                        <li class="breadcrumb-item active">Tambah Produk</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Produk</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            {!! Form::open([
    'route' => 'categories.store',
    'method' => 'POST',
    'id' => 'form-product',
    'files' => true,
]) !!}

                            <div class="row mb-3">
                                <div class="col">
                                    <label for="photo">Foto</label>
                                    <img class="rounded mb-3 col-sm-5" id="preview">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="form-control" id="photo" name="photo"
                                                onchange="previewImage()">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="code">Kode</label>
                                        {!! Form::text('code', null, ['class' => 'form-control', 'id' => 'code']) !!}
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Nama Produk</label>
                                        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
                                    </div>

                                    <div class="form-group">
                                        <label for="selling_price">Harga Jual</label>
                                        {!! Form::text('selling_price', null, ['class' => 'form-control', 'id' => 'selling_price']) !!}
                                    </div>

                                    <div class="form-group">
                                        <label for="stock">Stok</label>
                                        {!! Form::number('stock', null, ['class' => 'form-control', 'id' => 'stock']) !!}
                                    </div>

                                    <div class="form-group">
                                        <label for="size">Ukuran</label>
                                        {!! Form::number('size', null, ['class' => 'form-control', 'id' => 'size']) !!}
                                    </div>

                                    <div class="form-group">
                                        <label for="size">Deskripsi</label>
                                        {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'size', 'rows' => 2]) !!}
                                    </div>
                                </div>

                                <div class="col">
                                    <label for="category_id">Kategori</label>
                                    <div class="form group mb-3">
                                        <div class="input-group">
                                            {!! Form::select('category_id', [], null, ['class' => 'form-control custom-select', 'id' => 'category_id']) !!}
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button">Tambah</button>
                                            </div>
                                        </div>
                                    </div>

                                    <label for="product_color_id">Warna</label>
                                    <div class="input-group mb-3">
                                        {!! Form::select('product_color_id', [], null, ['class' => 'form-control custom-select', 'id' => 'product_color_id']) !!}
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button">Tambah</button>
                                        </div>
                                    </div>

                                    <label for="product_fragrance_id">Aroma</label>
                                    <div class="input-group mb-3">
                                        {!! Form::select('product_fragrance_id', [], null, ['class' => 'form-control custom-select', 'id' => 'product_fragrance_id']) !!}
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button">Tambah</button>
                                        </div>
                                    </div>

                                    <label for="product_unit_id">Unit</label>
                                    <div class="input-group">
                                        {!! Form::select('product_unit_id', [], null, ['class' => 'form-control custom-select', 'id' => 'product_unit_id']) !!}
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button">Tambah</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {!! Form::close() !!}
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer d-flex justify-content-center">
                            <a href="{{ route('products.index') }}" class="btn btn-danger">Batal</a>
                            <button class="btn btn-primary ml-2">Simpan</button>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>

@endsection
@push('js')
    <script src="/plugins/select2/js/select2.full.min.js"></script>
    <script src="/dist/js/product/create.js"></script>
@endpush
