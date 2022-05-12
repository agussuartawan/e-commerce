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
                            <h3 class="card-title">Laporan Penjualan</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="d-flex d-flex justify-content-center">
                                <div class="input-group mb-3 col-md-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Cari</span>
                                    </div>
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
                        <div class="card-header">
                            <h5 class="text-center">Produk Terlaris</h5>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <div class="card-header">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active nav-for-provinces" href="#provinces"
                                            data-toggle="tab">Grafik</a></li>
                                    <li class="nav-item"><a class="nav-link nav-for-cities" href="#best-seller-table"
                                            data-toggle="tab">Rincian</a></li>
                                </ul>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="provinces">
                                        <div class="tab-content p-0">
                                            <!-- Morris chart - Sales -->
                                            <div class="chart tab-pane active" id="revenue-chart"
                                                 style="position: relative; height: 300px;">
                                                <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                                             </div>
                                            <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                                              <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                                            </div>
                                          </div>
                                    </div>
    
                                    <div class="tab-pane" id="best-seller-table">
                                        <table class="table table-striped" style="min-width: 50rem">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Kode</th>
                                                    <th>Nama Produk</th>
                                                    <th>Harga Jual</th>
                                                    <th>Harga Produksi</th>
                                                    <th>Qty Terjual</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($best_seller_product as $key => $p)
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>
                                                        <td>{{ $p->code }}</td>
                                                        <td>{{ $p->product_name }}</td>
                                                        <td>{{ rupiah($p->selling_price) }}</td>
                                                        <td>{{ rupiah($p->production_price) }}</td>
                                                        <td>{{ rupiah($p->sale->sum('qty')) }}</td>
                                                    </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">Tidak ada data.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
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
    <script src="{{ asset('') }}/plugins/chart.js/Chart.min.js"></script>

    <script src="{{ asset('') }}/dist/js/report/sale/index.js"></script>
    <script>
            $(document).ready(function () {
            const chartData = JSON.parse(`{!! $best_seller_chart !!}`);
            var bestSellerChart = document.getElementById('revenue-chart-canvas').getContext('2d')
            var bestSellerChartData = {
                labels: chartData.labels,
                datasets: [
                {
                    label: 'Jumlah Terjual',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: true,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: chartData.data
                },
                ]
            }
            
            var bestSellerChartOption = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                display: true
                },
                scales: {
                xAxes: [{
                    gridLines: {
                    display: false
                    }
                }],
                yAxes: [{
                    gridLines: {
                    display: true
                    },
                    ticks: {
                    beginAtZero: true,
                    precision: 0,
                    callback: function(value, index, values){
                        return rupiah(value);
                    },
                    }
                }]
                }
            }
            
            // This will get the first returned node in the jQuery collection.
            // eslint-disable-next-line no-unused-vars
            var salesChart = new Chart(bestSellerChart, { // lgtm[js/unused-local-variable]
                type: 'bar',
                data: bestSellerChartData,
                options: bestSellerChartOption
            })
        });

        rupiah = (bilangan) => {
            var number_string = bilangan.toString(),
                sisa = number_string.length % 3,
                rupiah = number_string.substr(0, sisa),
                ribuan = number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            // Cetak hasil
            return rupiah;
        };
    </script>
@endpush
