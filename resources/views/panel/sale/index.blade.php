@extends('layouts.panel')
@section('title', 'Penjualan')

@push('css')
    <link rel="stylesheet" href="{{ asset('') }}/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet"
        href="{{ asset('') }}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

    <link rel="stylesheet" href="{{ asset('') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('') }}/plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endpush

@section('content')



    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Penjualan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Penjualan</li>
                    </ol>
                </div>
            </div>
            @if ($newSale != 0)
                <div class="row">
                    <div class="col">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <h6>Ada <b>{{ $newSale }}</b> pesanan baru, mohon periksa segera!</h6>
                            <button type="button" class="close"
                                onclick="document.getElementById('form-close').submit()" data-dismiss="alert"
                                aria-label="Close">
                                <h6 aria-hidden="true">&times;</h6>
                            </button>
                            <form action="{{ url('sale/notification-close') }}" class="d-none" id="form-close"
                                method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Data Penjualan</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="sale-table" class="table table-bordered table-striped">
                                    <thead class="text-center">
                                        <tr>
                                            <th>No Penjualan</th>
                                            <th>Pelanggan</th>
                                            <th>Produk</th>
                                            <th>Tgl</th>
                                            <th>Total</th>
                                            <th>Status Gudang</th>
                                            @if (auth()->user()->can('akses penjualan aksi'))
                                                <th>Status Pengiriman</th>
                                            @else
                                                <th></th>
                                            @endif
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody><input type="hidden" value="{{ $now }}" id="daterange"></tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    @include('include.modal')

@endsection

@push('js')
    <script src="{{ asset('') }}/plugins/moment/moment.min.js"></script>
    <script src="{{ asset('') }}/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="{{ asset('') }}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

    <script src="{{ asset('') }}/plugins/select2/js/select2.full.min.js"></script>
    <script src="{{ asset('') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ asset('') }}/dist/js/sale/index.js"></script>
@endpush
