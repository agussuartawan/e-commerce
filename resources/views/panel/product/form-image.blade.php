@extends('layouts.panel')
@section('title', 'Tambah Produk')
@push('css')
    <link rel="stylesheet" href="{{ asset('') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('') }}/plugins/dropzone/min/dropzone.min.css"> --}}
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <style>
        .dropzone {
            border: dashed 2px rgb(134, 134, 134);
            border-radius: 20px;
        }

    </style>
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
    </section>
@endsection
@push('js')
    <script src="{{ asset('') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
        var image_id;
        Dropzone.options.image = {
            // camelized version of the `id`
            paramName: "image", // The name that will be used to transfer the file
            maxFilesize: 1, // MB
            dictDefaultMessage: "Seret & Jatuhkan gambar di sini atau klik untuk menelusuri",
            addRemoveLinks: true,
            // uploadMultiple: true,
            // parallelUploads: 10,
            acceptedMimeTypes: ".jpeg,.jpg,.png,.gif",
            init: function() {
                var thisDropzone = this;
                $.getJSON('{{ route('product.thumbnail', $product) }}', function(data) {
                    $.each(data, function(key, value) {
                        var mockFile = {
                            name: `Gambar Produk ${key+1}`,
                            size: value.size,
                            dataURL: value.path,
                            id: value.id
                        };

                        thisDropzone.files.push(mockFile);
                        thisDropzone.emit('addedfile', mockFile);
                        thisDropzone.createThumbnailFromUrl(mockFile,
                            thisDropzone.options.thumbnailWidth,
                            thisDropzone.options.thumbnailHeigth,
                            thisDropzone.options.thumbnailMethod, true,
                            function(thumbnail) {
                                thisDropzone.emit('thumbnail', mockFile, thumbnail)
                            }
                        );
                        thisDropzone.emit("complete", mockFile);
                    });
                });

                thisDropzone.on('success', function(file, serverFileName) {
                    image_id = serverFileName.id;
                });

                thisDropzone.on('removedfile', function(file) {
                    var data = 0;
                    var token = $('meta[name="csrf-token"]').attr("content");

                    if (image_id != undefined) {
                        data = image_id;
                    } else if (file.id != undefined) {
                        data = file.id;
                    }

                    if (data == 0) {
                        return;
                    }

                    $.ajax({
                        url: `/product/remove-image/${data}`,
                        type: "POST",
                        data: {
                            _method: "DELETE",
                            _token: token,
                        },
                        success: function(response) {
                            showSuccessToast("Gambar produk berhasil dihapus");
                        }
                    });
                });
            },
        };

        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
        });

        showSuccessToast = (message) => {
            Toast.fire({
                icon: "success",
                title: message,
            });
        }
    </script>
@endpush
