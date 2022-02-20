@extends('layouts.panel')
@section('title', 'Akun')
@push('css')
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
@endpush
@section('content')

     <!-- Content Header (Page header) -->
     <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Akun</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Akun</li>
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
                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Berhasil </strong><br>
                            <span>{{ Session::get('success') }}</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="card card-outline card-info" style="position: relative;">
                        @include('include.preloader')
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md">
                                    <h3 class="card-title">Data Akun</h3>
                                </div>
                                <div class="col-md">
                                    <div class="card-tools">
                                        <div class="input-group input-group-sm">
                                            <input type="search" name="search" class="form-control float-right" placeholder="Cari nama akun, no ref, keterangan">
                        
                                            <div class="input-group-append">
                                                <button class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md d-flex justify-content-end">
                                    <a href="{{route('accounts.create')}}" class="btn btn-sm btn-primary" id="btn-add-account" title="Tambah Akun">
                                        <i class="fas fa-plus mr-1"></i>
                                        Tambah Akun
                                    </a>
                                    @if(!$trial_balance_exists)
                                        <a href="{{ route('trial-balance.first-create') }}" class="btn btn-sm btn-primary ml-2">
                                            <i class="fas fa-book mr-1"></i>
                                            Atur Saldo Awal
                                        </a>
                                    @endif
                                </div>
                            </div>
            
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="max-height: 25rem;">
                            <table class="table table-head-fixed text-nowrap table-hover" id="account-table">
                              <thead>
                                <tr>
                                  <th width="15%">No Ref</th>
                                  <th width="25%">Nama Akun</th>
                                  <th>Keterangan</th>
                                  <th width="20%"></th>
                                </tr>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
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
    <script src="/plugins/select2/js/select2.full.min.js"></script>
    <script src="/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="/dist/js/account/index.js"></script>
@endpush