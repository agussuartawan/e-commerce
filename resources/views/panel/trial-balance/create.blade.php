@extends('layouts.panel')
@section('title', 'Saldo Awal')
@push('css')
    <link rel="stylesheet" href="{{ asset('') }}/plugins/sweetalert2/sweetalert2.min.css">
@endpush
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Saldo Awal</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('accounts.index') }}">Akun</a>
                        </li>
                        <li class="breadcrumb-item active">Saldo Awal</li>
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
                            <div class="row">
                                <div class="col-md">
                                    <h3 class="card-title">Atur Neraca Saldo Awal</h3>
                                </div>
                                <div class="col-md d-flex justify-content-end">
                                    <a href="{{ route('accounts.create') }}" class="btn btn-sm btn-primary"
                                        id="btn-add-account" title="Tambah Akun">
                                        <i class="fas fa-plus mr-1"></i>
                                        Tambah Akun
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="max-height: 25rem;">
                            {!! Form::open([
    'route' => 'trial-balance.first-store',
    'method' => 'POST',
    'id' => 'form-trial-balance',
]) !!}
                            <div class="form-group px-4">
                                <label for="date">Tanggal</label>
                                {!! Form::date('date', date('Y-m-d'), ['class' => 'form-control', 'id' => 'date', 'required' => true]) !!}
                            </div>


                            <table class="table table-head-fixed text-nowrap table-hover" id="trial-balance-table"
                                style="min-width: 50rem">
                                <thead>
                                    <tr>
                                        <th>No Ref</th>
                                        <th>Nama Akun</th>
                                        <th>Debet</th>
                                        <th>Kredit</th>
                                    </tr>
                                </thead>

                                <tbody>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="text-center">Jumlah</th>
                                        <th id="total-debit">0</th>
                                        <th id="total-credit">0</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <hr>
                        <div class="card-footer mx-auto p-0">
                            <a href="{{ route('accounts.index') }}" class="btn btn-sm btn-danger mr-1 mb-2">Batal</a>
                            <button class="btn btn-primary btn-sm mb-2" type="submit">Atur Saldo Awal</button>
                        </div>
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
    <!-- /.content -->

    @include('include.modal')

@endsection
@push('js')
    <script src="{{ asset('') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ asset('') }}/dist/js/trial-balance/first-create.js"></script>
@endpush
