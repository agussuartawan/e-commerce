@extends('layouts.panel')
@section('title', 'Tambah Jurnal Umum')

@push('css')
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
                    <h1>Tambah Jurnal Umum</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('journals.index') }}">Jurnal Umum</i></a>
                        </li>
                        <li class="breadcrumb-item active">Tambah Jurnal Umum</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12" id="errorMessage">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Jurnal Baru</h3>
                        </div>
                        <!-- /.card-header -->
                        <form action="{{ route('journals.store') }}" id="journal-form" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="journal-create" class="table" style="min-width: 50rem">
                                        <thead class="text-center">
                                            <tr>
                                                <th width="20%">Tanggal</th>
                                                <th width="30%">Akun</th>
                                                <th width="20%">Debet</th>
                                                <th width="20%">Kredit</th>
                                                <th width="10%"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="form">
                                            <tr>
                                                <td>
                                                    <input type="date" name="date[]" id="date-1" class="form-control"
                                                        value="{{ date('Y-m-d') }}" required>
                                                </td>
                                                <td><select name="account_id[]" id="account_id-1"
                                                        class="form-control custom-select"></select></td>

                                                <td>
                                                    <input type="text" name="debit[]" id="debit-1" class="form-control"
                                                        value="0">
                                                </td>

                                                <td>
                                                    <input type="text" name="credit[]" id="credit-1" class="form-control"
                                                        value="0">
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="5"><button class="btn btn-sm btn-primary" id="btn-add">Tambah
                                                        Form</button></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer d-flex justify-content-center">
                                <a href="{{ route('journals.index') }}" class="btn btn-danger mr-2">Batal</a>
                                <button class="btn btn-primary" type="submit" id="btn-save">Simpan</button>
                            </div>
                        </form>
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
    <script src="{{ asset('') }}/plugins/select2/js/select2.full.min.js"></script>
    <script src="{{ asset('') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ asset('') }}/dist/js/journal/create.js"></script>
@endpush
