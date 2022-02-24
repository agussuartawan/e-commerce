@extends('layouts.panel')
@section('title', 'Laporan Penjualan')
@push('css')
    <link rel="stylesheet" href="{{ asset('') }}/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet"
        href="{{ asset('') }}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
@endpush
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Laporan Penjualan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Laporan Penjualan</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-info" style="position: relative;">
                        @include('include.preloader')
                        <div class="card-header">
                            <h3 class="card-title">Cari Laporan Penjualan</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="d-flex d-flex justify-content-center">
                                <div class="input-group mb-3 col-md-6">
                                    <input type="text" name="dateFilter" class="form-control" id="dateFilter">

                                    <div class="input-group-append">
                                        <button class="btn btn-default" id="btn-search">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center" id="btn-action">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-info" style="position: relative;">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-bordered" style="min-width: 50rem" id="sale-report">
                                <thead class="text-center">
                                    <tr>
                                        <th>No Penjualan</th>
                                        <th>Pelanggan</th>
                                        <th>Produk</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                        <th>Tgl</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script src="{{ asset('') }}/plugins/moment/moment.min.js"></script>
    <script src="{{ asset('') }}/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="{{ asset('') }}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

    <script src="{{ asset('') }}/dist/js/report/sale/index.js"></script>
@endpush
