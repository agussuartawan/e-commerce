@extends('layouts.pdf')
@section('title', 'Laporan Arus Barang')
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

            .page-break {
                padding-top: 20px;
                page-break-before: always;
            }

        </style>
    @endpush

    <div class="container">
        <h3 class="text-center" style="margin-bottom: 5px">Laporan Arus Barang</h3>
        <span class="text-center text">Periode : {{ \Carbon\Carbon::parse($date['from'])->isoFormat('DD MMMM Y') }} -
            {{ \Carbon\Carbon::parse($date['to'])->isoFormat('DD MMMM Y') }}</span>
        
        <table class="table" style="margin-top: 5px">
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>NO BARANG MASUK</th>
                    <th>TANGGAL</th>
                    <th>JUMLAH</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($incomes as $key => $income)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td>{{ $income->purchase_number }}</td>
                        <td>{{ \Carbon\Carbon::parse($income->date)->isoFormat('DD MMMM Y') }}</td>
                        <td class="text-center">{{ $income->product->sum('pivot.qty') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">TOTAL BARANG MASUK</th>
                    <th class="text-center">{{ rupiah($sum_income) }}</th>
                </tr>
            </tfoot>
        </table>

        <div class="page-break">
                <table class="table" style="margin-top: 5px;">
                    <thead>
                        <tr>
                            <th>NO.</th>
                            <th>NO BARANG KELUAR</th>
                            <th>TANGGAL</th>
                            <th>JUMLAH</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sales as $key => $sale)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>{{ $sale->sale_number }}</td>
                                <td>{{ \Carbon\Carbon::parse($sale->date)->isoFormat('DD MMMM Y') }}</td>
                                <td class="text-center">{{ $sale->qty }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">TOTAL BARANG KELUAR</th>
                            <th class="text-center">{{ $sales->sum('qty') }}</th>
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

    </div>

@endsection
