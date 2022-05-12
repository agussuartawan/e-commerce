@extends('layouts.panel')
@section('title', 'Dashboard')
@section('content')

  <div class="content-header">
    <div class="container-fluid">
        <div class="alert alert-info alert-dismissible fade show" role="alert">
          <h5>Selamat datang kembali <b>{{ auth()->user()->name }}</b></h5>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <h5 aria-hidden="true">&times;</h5>
          </button>
      </div>
    </div><!-- /.container-fluid -->
  </div>

     <!-- Main content -->
     <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          @can('akses penjualan')
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $new_order }}</h3>

                <p>Pesanan Baru</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="{{ route('sales.index') }}" class="small-box-footer">Lebih lanjut <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          @endcan
          <!-- ./col -->
          @can('akses pembayaran')
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $new_payment }}</sup></h3>

                <p>Pembayaran Baru</p>
              </div>
              <div class="icon">
                <i class="far fa-solid fa-credit-card"></i>
              </div>
              <a href="{{ route('payments.index') }}" class="small-box-footer">Lebih lanjut <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          @endcan
          <!-- ./col -->
          @can('akses user')
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $user }}</h3>

                <p>Registrasi User Baru</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{ route('users.index') }}" class="small-box-footer">Lebih lanjut <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          @endcan
          <!-- ./col -->
          @can('akses barang')
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $product }}</h3>

                <p>Total Produk</p>
              </div>
              <div class="icon">
                <i class="fa fa-info-circle"></i>
              </div>
              <a href="{{ route('products.index') }}" class="small-box-footer">Lebih lanjut <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          @endcan
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Grafik Pemesanan Tahun {{ $year ?? date('Y') }}
                </h3>
                <div class="card-tools form-inline">
                    <label for="year" class="font-weight-normal">Tahun</label>
                    {!! Form::select('year', $years, $year ?? date('Y'), ['class' => 'form-control custom-select ml-1', 'id' => 'year']) !!}
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
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
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </section>
          <!-- /.Left col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection
@push('js')
  <script src="{{ asset('') }}/plugins/chart.js/Chart.min.js"></script>
  <script>
      $(document).ready(function () {
          const chartData = JSON.parse(`{!! $salesChart !!}`);
          var salesChartCanvas = document.getElementById('revenue-chart-canvas').getContext('2d')
          var salesChartData = {
            labels: chartData.labels,
            datasets: [
              {
                label: 'Jumlah Pesanan',
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
        
          var salesChartOptions = {
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
                  display: false
                },
                ticks: {
                  beginAtZero: true,
                  precision: 0,
                  callback: function(value, index, values){
                    return 'Rp. ' + rupiah(value);
                  },
                }
              }]
            }
          }
        
          // This will get the first returned node in the jQuery collection.
          // eslint-disable-next-line no-unused-vars
          var salesChart = new Chart(salesChartCanvas, { // lgtm[js/unused-local-variable]
            type: 'line',
            data: salesChartData,
            options: salesChartOptions
          })
      });

      $('body').on('change', '#year', function(){
         const year = $(this).val();
         window.location.href = '/dashboard?year=' + year;
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