@extends('layouts.general')
@section('title', 'Pembayaran')
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
                <h6>Data Pembayaran Anda</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" style="min-width: 60rem">
                        <thead class="text-center">
                            <tr>
                                <th>No Pesanan</th>
                                <th>Tgl Bayar</th>
                                <th>Nama Pengirim</th>
                                <th>Bank</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Bukti Transfer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $payment)
                                <tr>
                                    <td>{{ $payment->sale->sale_number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($payment->date)->isoFormat('DD MMMM Y') }}</td>
                                    <td>{{ $payment->sender_account_name }}</td>
                                    <td class="text-center">{{ $payment->sender_bank }}<i class="fas fa-arrow-right mx-3"></i>{{ $payment->destination_bank }}</td>
                                    <td>{{ rupiah($payment->sale->grand_total) }}</td>
                                    <td>
                                        @if ($payment->sale->payment_status_id == \App\Models\PaymentStatus::MENUNGGU_PEMBAYARAN)
                                            <span class="badge badge-secondary">{{ $payment->sale->payment_status->name }}</span>
                                        @elseif($payment->sale->payment_status_id == \App\Models\PaymentStatus::LUNAS)
                                            <span class=" badge badge-success">{{ $payment->sale->payment_status->name }}</span>
                                        @elseif($payment->sale->payment_status_id == \App\Models\PaymentStatus::MENUNGGU_KONFIRMASI)
                                            <span class="text-italic text-warning">{{ $payment->sale->payment_status->name }}</span>
                                        @elseif($payment->sale->payment_status_id == \App\Models\PaymentStatus::DIBATALKAN)
                                            <span class="text-italic text-danger">(Dibatalkan)</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ asset('storage/' . $payment->transfer_proof) }}"
                                            class="btn btn-sm btn-outline-primary btn-block" target="_blanc">Lihat</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Anda belum melakukan pembayaran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="/dist/js/delivery/index.js"></script>
@endpush
