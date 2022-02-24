@extends('layouts.pdf')
@section('title', 'Laporan Buku Besar')
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
        <h3 class="text-center" style="margin-bottom: 5px">Laporan Buku Besar</h3>
        <span class="text-center text">Periode : {{ \Carbon\Carbon::parse($date['from'])->isoFormat('DD MMMM Y') }} - {{ \Carbon\Carbon::parse($date['to'])->isoFormat('DD MMMM Y') }}</span>
        @forelse ($accounts as $account)
            <div class="inline" style="margin-bottom: 5px">
                <span class="text">Akun : {{ $account->name }}</span>
                <span class="text" style="float: right">No Ref : {{ $account->account_number }}</span>
            </div>
    
            <table class="table" style="margin-top: 5px; margin-bottom: 15px">
                <thead>
                    <tr>
                        <th>TANGGAL</th>
                        <th>AKUN</th>
                        <th>NO REF</th>
                        <th>DEBET</th>
                        <th>KREDIT</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($account->general_journal->whereBetween('date', $date) as $journal)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($journal->date)->isoFormat('DD MMMM Y') }}</td>
                            <td>{{ $journal->account->name }}</td>
                            <td class="text-center">{{ $journal->account->account_number }}</td>
                            <td class="text-center">Rp. {{ rupiah($journal->debit) }}</td>
                            <td class="text-center">Rp. {{ rupiah($journal->credit) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
                @if($account->general_journal->whereBetween('date', $date)->count() > 0)
                <tfoot>
                    <tr>
                        <th colspan="3">JUMLAH</th>
                        <th>Rp. {{ rupiah($account->general_journal->whereBetween('date', $date)->sum('debit')) }}</th>
                        <th>Rp. {{ rupiah($account->general_journal->whereBetween('date', $date)->sum('credit')) }}</th>
                    </tr>
                </tfoot>
                @endif
            </table>
        @empty
            <table class="table" style="margin-top: 5px">
                <thead>
                    <tr>
                        <th>TANGGAL</th>
                        <th>AKUN</th>
                        <th>NO REF</th>
                        <th>DEBET</th>
                        <th>KREDIT</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data.</td>
                    </tr>
                </tbody>
            </table>
        @endforelse
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