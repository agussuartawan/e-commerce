@extends('layouts.panel')
@section('title', 'Tambah Produk')
@push('css')
    <link rel="stylesheet" href="{{ asset('') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('') }}/plugins/dropzone/min/dropzone.min.css"> --}}
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
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
                        <li class="breadcrumb-item active">Kelola Gambar Produk</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Upload Gambar Produk</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            {!! Form::open([
    'route' => ['product.image-store', $product],
    'method' => 'POST',
    'class' => 'dropzone',
    'id' => 'image',
]) !!}

                            {!! Form::close() !!}
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Gambar Produk</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <img src="{{ asset('img/no-image.jpg') }}" class="img-responsive rounded mr-3" alt="..."
                                style="width: 175px">
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
    </section>
@endsection
@push('js')
    <script src="{{ asset('') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    {{-- <script src="{{ asset('') }}/plugins/dropzone/min/dropzone.min.js"></script> --}}
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
        Dropzone.options.image = {
            // camelized version of the `id`
            paramName: "image", // The name that will be used to transfer the file
            maxFilesize: 1, // MB
            dictDefaultMessage: "Pilih gambar",
            addRemoveLinks: true,
            uploadMultiple: true,
            parallelUploads: 10,
            acceptedMimeTypes: ".jpeg,.jpg,.png,.gif",
        };
    </script>
@endpush

{{-- // init: function() {
// var thisDropzone = this;
// var pageid = $("#pageid").val();
// $.getJSON('{{ route('') }}', function(data) {

// $.each(data, function(key, value) {

// var mockFile = {
// name: value.name,
// size: value.size
// };

// thisDropzone.options.addedfile.call(thisDropzone, mockFile);
// thisDropzone.options.thumbnail.call(thisDropzone, mockFile,
// "/admin/uploads/" + value.name);
// thisDropzone.emit("complete", mockFile);

// });
// });

// }, --}}
