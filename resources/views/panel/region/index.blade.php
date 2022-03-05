@extends('layouts.panel')
@section('title', 'Wilayah')

@push('css')
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
                    <h1>Wilayah</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Wilayah</li>
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
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active nav-for-provinces" href="#provinces"
                                        data-toggle="tab">Data Provinsi</a></li>
                                <li class="nav-item"><a class="nav-link nav-for-cities" href="#cities"
                                        data-toggle="tab">Data
                                        Kota</a></li>
                            </ul>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="provinces">
                                    <div class="table-responsive">
                                        <table id="provinces-table" class="table table-bordered table-striped">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Nama Provinsi</th>
                                                    <th width="15%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane" id="cities">
                                    <div class="table-responsive">
                                        <table id="cities-table" class="table table-bordered table-striped">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Nama Kota</th>
                                                    <th>Provinsi</th>
                                                    <th width="15%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
    <script src="{{ asset('') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ asset('') }}/dist/js/region/index.js"></script>
@endpush
