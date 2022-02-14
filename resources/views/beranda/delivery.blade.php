@extends('layouts.general')
@section('title', 'Order')
@push('css')
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endpush
@section('content')
    <div class="container py-2">
        <div class="card">
            <div class="card-header">
                <h6>Data Pesanan Anda</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" style="min-width: 60rem">
                        <thead class="text-center">
                            <tr>
                                <th>No Pesanan</th>
                                <th>Nama Barang</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status Pengiriman</th>
                                <th>Status Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sales as $sale)
                            <tr>
                                <td>{{ $sale->sale_number }}</td>
                                <td>
                                    {{ $sale->product->product_name }} 
                                    @if($sale->is_cancle == 1)
                                        <span class="text-italic text-danger">(Dibatalkan)</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($sale->date)->isoFormat('DD MMMM Y') }}</td>
                                <td>{{ rupiah($sale->grand_total) }}</td>
                                <td>
                                    @if($sale->delivery_status == 'menunggu')
                                        <span class="badge badge-secondary">{{ $sale->delivery_status }}</span>
                                    @elseif($sale->delivery_status == 'dalam pengiriman')
                                        <a href="#" class="btn btn-block btn-sm btn-outline-success">Terima Barang</a>
                                    @elseif($sale->delivery_status == 'dikirim')
                                        <span class="badge badge-success">{{ $sale->delivery_status }}</span>
                                    @elseif($sale->is_cancle == 1)
                                        <span class="text-italic text-danger">(Dibatalkan)</span>
                                    @endif
                                </td>
                                <td>
                                    @if($sale->payment_status == 'lunas')
                                        <span class="badge badge-success">{{ $sale->payment_status }}</span>
                                    @elseif($sale->payment_status == 'menunggu pembayaran')
                                        <a href="#" class="btn btn-block btn-sm btn-outline-success">Kirim Pembayaran</a>
                                    @elseif($sale->payment_status == 'menunggu konfirmasi')
                                        <span class="badge badge-warning">{{ $sale->payment_status }}</span>
                                    @elseif($sale->is_cancle == 1)
                                        <span class="text-italic text-danger">(Dibatalkan)</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('order.show', $sale) }}" class="btn btn-sm btn-outline-success btn-block btn-show">Detail</a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Anda belum melakukan pemesanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $sales->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="/plugins/select2/js/select2.full.min.js"></script>
    <script src="/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="/dist/js/order/create.js"></script>
@endpush
