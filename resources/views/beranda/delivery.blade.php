@extends('layouts.general')
@section('title', 'Order')
@push('css')
    <link rel="stylesheet" href="/plugins/sweetalert2/sweetalert2.min.css">
@endpush
@section('content')
    <div class="container py-2">
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil</strong> {{ Session::get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
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
                                        @if ($sale->is_cancel == 1)
                                            <span class="font-italic text-danger">(Dibatalkan)</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($sale->date)->isoFormat('DD MMMM Y') }}</td>
                                    <td>{{ rupiah($sale->grand_total) }}</td>
                                    <td>
                                        @if ($sale->delivery_status_id == \App\Models\DeliveryStatus::MENUNGGU)
                                            <span class="badge badge-secondary">{{ $sale->delivery_status->name }}</span>
                                        @elseif($sale->delivery_status_id == \App\Models\DeliveryStatus::DALAM_PENGIRIMAN)
                                            {!! Form::open([
    'route' => ['delivery.received', $sale->id],
    'method' => 'PUT',
    'class' => 'd-none form-confirm' . $sale->id,
]) !!}

                                            {!! Form::close() !!}
                                            <a href="#" class="btn btn-block btn-sm btn-outline-primary btn-confirm"
                                                data-id="form-confirm{{ $sale->id }}">Terima
                                                Barang</a>
                                        @elseif($sale->delivery_status_id == \App\Models\DeliveryStatus::DIKIRIM)
                                            <span class=" badge badge-success">{{ $sale->delivery_status->name }}</span>
                                        @elseif($sale->delivery_status_id == \App\Models\DeliveryStatus::DIBATALKAN)
                                            <span class="font-italic text-danger">(Dibatalkan)</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($sale->payment_status_id == \App\Models\PaymentStatus::LUNAS)
                                            <span class="badge badge-success">{{ $sale->payment_status->name }}</span>
                                        @elseif($sale->payment_status_id == \App\Models\PaymentStatus::MENUNGGU_PEMBAYARAN)
                                            <a href="{{ route('payment.create', $sale) }}"
                                                class="btn btn-block btn-sm btn-outline-primary">Kirim Pembayaran</a>
                                        @elseif($sale->payment_status_id == \App\Models\PaymentStatus::MENUNGGU_KONFIRMASI)
                                            <span class="badge badge-warning">{{ $sale->payment_status->name }}</span>
                                        @elseif($sale->is_cancel == 1)
                                            <span class="font-italic text-danger">(Dibatalkan)</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($sale->is_cancel != 1)
                                            <a href="{{ route('order.show', $sale) }}"
                                                class="btn btn-sm btn-outline-info btn-block btn-show">Detail</a>
                                        @endif
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
    <script src="/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="/dist/js/delivery/index.js"></script>
@endpush
