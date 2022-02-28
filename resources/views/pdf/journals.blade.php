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
        <h3 class="text-center" style="margin-bottom: 5px">Laporan Jurnal Umum</h3>
        <span class="text-center text">Periode : {{ \Carbon\Carbon::parse($date['from'])->isoFormat('DD MMMM Y') }} - {{ \Carbon\Carbon::parse($date['to'])->isoFormat('DD MMMM Y') }}</span>
  
        <table class="table" style="margin-top: 5px">
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>TANGGAL</th>
                    <th>AKUN</th>
                    <th>NO REF</th>
                    <th>DEBET</th>
                    <th>KREDIT</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($journals as $key => $journal)
                    <tr>
                        <td class="text-center">{{ $key+1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($journal->date)->isoFormat('DD MMMM Y') }}</td>
                        <td>
                            @if($journal->account->balance_type == 'Kredit')
                                &nbsp;&nbsp;{{ $journal->account->name }}
                            @else
                                {{ $journal->account->name }}
                            @endif
                        </td>
                        <td class="text-center">{{ $journal->account->account_number }}</td>
                        <td class="text-center">Rp. {{ rupiah($journal->debit) }}</td>
                        <td class="text-center">Rp. {{ rupiah($journal->credit) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">JUMLAH</th>
                    <th>Rp. {{ rupiah($journals->sum('debit')) }}</th>
                    <th>Rp. {{ rupiah($journals->sum('credit')) }}</th>
                </tr>
            </tfoot>
        </table>

        <table style="width: 100%; margin-top: 20px">
            <tr>
                <td class="text" style="text-align: right">Badung, {{\Carbon\Carbon::now()->isoFormat('DD MMMM Y')}}</td>
            </tr>
            <tr><td style="height: 40px"></td></tr>
            <tr>
                <td class="text" style="text-align: right">(...................)</td>
            </tr>
        </table>
    </div>

@endsection