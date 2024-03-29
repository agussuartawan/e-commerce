@extends('layouts.pdf')
@section('title', 'Laporan Penjualan')
@section('content')
    @push('css')
        <style>
            h1 {
                font-weight: bold;
                font-size: 20pt;
                text-align: center;
            }

            .table {
                border-collapse: collapse;
                width: 100%;
                font-size: 10pt;
            }

            .table th {
                padding: 8px 8px;
                border: 1px solid #000000;
                text-align: center;
            }

            .table td {
                padding: 3px 3px;
                border: 1px solid #000000;
            }

            .text {
                font-size: 10pt;
            }

            .text-center {
                text-align: center;
            }

        </style>
    @endpush

    <div class="container">
        <h3 class="text-center" style="margin-bottom: 5px">Produk Terlaris</h3>
        <table class="table" style="margin-top: 5px; margin-bottom: 15px">
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>KODE</th>
                    <th>NAMA PRODUK</th>
                    <th>HARGA JUAL</th>
                    <th>HARGA PRODUKSI</th>
                    <th>QTY TERJUAL</th>
                </tr>
            </thead>
            <tbody>
                @forelse($best_seller_product as $key => $p)
                    <tr>
                        <td class="text-center">{{ $key+1 }}</td>
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

            <h3 class="text-center" style="margin-bottom: 5px; margin-top: 5px">Laporan Penjualan</h3>
            <span class="text-center text">Periode : {{ \Carbon\Carbon::parse($date['from'])->isoFormat('DD MMMM Y') }} -
                {{ \Carbon\Carbon::parse($date['to'])->isoFormat('DD MMMM Y') }}</span>

            <table class="table" style="margin-top: 5px">
                <thead>
                    <tr>
                        <th>NO.</th>
                        <th>TANGGAL</th>
                        <th>NO INVOICE</th>
                        <th>NAMA PELANGGAN</th>
                        <th>ITEM BARANG</th>
                        <th>JUMLAH</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sales as $key => $sale)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($sale->date)->isoFormat('DD MMMM Y') }}</td>
                            <td>{{ $sale->sale_number }}</td>
                            <td>{{ $sale->customer->fullname }}</td>
                            <td>{{ $sale->product->product_name }}</td>
                            <td style="text-align: left">{{ $sale->qty }} {{ $sale->product->product_unit->name }}</td>
                            <td style="text-align: left">Rp. {{ rupiah($sale->grand_total) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5">JUMLAH</th>
                        <th style="text-align: left">{{ $sales->sum('qty') }}</th>
                        <th style="text-align: left">Rp. {{ rupiah($sales->sum('grand_total')) }}</th>
                    </tr>
                </tfoot>
            </table>

            <table style="width: 100%; margin-top: 20px">
                <tr>
                    <td class="text" style="text-align: right">Badung,
                        {{ \Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}</td>
                </tr>
                <tr>
                    <td style="height: 40px"></td>
                </tr>
                <tr>
                    <td class="text" style="text-align: right">(...................)</td>
                </tr>
            </table>
    </div>

@endsection
