@extends('layouts.panel')
@section('title', 'Laporan Neraca Saldo')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Laporan Neraca Saldo</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Laporan Neraca Saldo</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        @if ($trialBalanceExists)
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline card-info" style="position: relative;">
                            @include('include.preloader')
                            <div class="card-header">
                                <h3 class="card-title">Laporan Neraca Saldo</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="d-flex d-flex justify-content-center">
                                    <div class="input-group mb-3 col-md-6">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Cari</span>
                                        </div>
                                        {!! Form::select('month', $months, date('m'), ['class' => 'form-control custom-select', 'id' => 'month']) !!}
                                        {!! Form::select('year', $years, date('Y'), ['class' => 'form-control custom-select', 'id' => 'year']) !!}
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
                                <table class="table table-bordered" style="min-width: 50rem" id="trial-balance-report">
                                    <thead class="text-center">
                                        <tr>
                                            <th rowspan="2" class="align-middle">No Ref</th>
                                            <th rowspan="2" class="align-middle">Akun</th>
                                            <th colspan="2" class="text-center">Saldo</th>
                                        </tr>
                                        <tr>
                                            <th>Debet</th>
                                            <th>Kredit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada data.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline card-danger">
                            <div class="card-body">
                                <p class="text-center">Anda belum mengatur <strong>Neraca Saldo Awal</strong>, silahkan
                                    atur terlebih dahulu melalui <a href="{{ route('trial-balance.first-create') }}">link
                                        ini</a>!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>
@endsection
@push('js')
    <script src="{{ asset('') }}/dist/js/report/trial-balance/index.js"></script>
@endpush
