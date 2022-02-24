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
                border:1px solid #000000;
                text-align: center;
            }
        
            .table td {
                padding: 3px 3px;
                border:1px solid #000000;
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
        <h3 class="text-center" style="margin-bottom: 5px">Laporan Penjualan</h3>
        <span class="text-center text">Periode : {{ \Carbon\Carbon::parse($date['from'])->isoFormat('DD MMMM Y') }} - {{ \Carbon\Carbon::parse($date['to'])->isoFormat('DD MMMM Y') }}</span>
  
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
                        <td class="text-center">{{ $key+1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($sale->date)->isoFormat('DD MMMM Y') }}</td>
                        <td>{{ $sale->sale_number }}</td>
                        <td>{{ $sale->customer->fullname }}</td>
                        <td>{{ $sale->product->product_name }}</td>
                        <td class="text-center">{{ $sale->qty }} {{ $sale->product->product_unit->name }}</td>
                        <td class="text-center">Rp. {{ rupiah($sale->grand_total) }}</td>
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
                    <th>{{ $sales->sum('qty') }}</th>
                    <th>Rp. {{ rupiah($sales->sum('grand_total')) }}</th>
                </tr>
            </tfoot>
        </table>

        <table style="width: 100%; margin-top: 20px">
            <tr>
                <td class="text" style="text-align: right">Dalung, {{\Carbon\Carbon::now()->isoFormat('DD MMMM Y')}}</td>
            </tr>
            <tr><td style="height: 40px"></td></tr>
            <tr>
                <td class="text" style="text-align: right">(...................)</td>
            </tr>
        </table>
    </div>

@endsection