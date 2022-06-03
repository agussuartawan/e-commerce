@extends('layouts.panel')
@section('title', 'Pembayaran')

@push('css')
    <link rel="stylesheet" href="{{ asset('') }}/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet"
        href="{{ asset('') }}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

    <link rel="stylesheet" href="{{ asset('') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('') }}/plugins/sweetalert2/sweetalert2.min.css">
@endpush

@section('content')



    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pembayaran</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Pembayaran</li>
                    </ol>
                </div>
            </div>
            @if ($newPayment != 0)
                <div class="row">
                    <div class="col">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <h6>Ada <b>{{ $newPayment }}</b> pembayaran baru, mohon periksa segera!</h6>
                            <button type="button" class="close"
                                onclick="document.getElementById('form-close').submit()" data-dismiss="alert"
                                aria-label="Close">
                                <h6 aria-hidden="true">&times;</h6>
                            </button>
                            <form action="{{ url('payment/notification-close') }}" class="d-none" id="form-close"
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
                            <h3 class="card-title">Data Pembayaran</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="payment-table" class="table table-bordered table-striped">
                                    <thead class="text-center">
                                        <tr>
                                            <th>No Penjualan</th>
                                            <th>Tgl Bayar</th>
                                            <th>Nama Pengirim</th>
                                            <th width="15%">Bukti Transfer</th>
                                            <th width="10%">Status</th>
                                            <th width="15%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input type="hidden" value="{{ $now }}" id="daterange">
                                        <input type="hidden" value="{{ \App\Models\PaymentStatus::MENUNGGU_KONFIRMASI }}"
                                            id="payment-status">
                                    </tbody>
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
    <input type="hidden" value="{{ \App\Models\PaymentStatus::LUNAS }}" id="lunas">
    <input type="hidden" value="{{ \App\Models\PaymentStatus::MENUNGGU_PEMBAYARAN }}" id="menunggu-pembayaran">
    <input type="hidden" value="{{ \App\Models\PaymentStatus::MENUNGGU_KONFIRMASI }}" id="menunggu-konfirmasi">
    <!-- /.content -->

    @include('include.modal')

@endsection

@push('js')
    <script src="{{ asset('') }}/plugins/moment/moment.min.js"></script>
    <script src="{{ asset('') }}/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="{{ asset('') }}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

    <script src="{{ asset('') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ asset('') }}/dist/js/payment/index.js"></script>
@endpush
