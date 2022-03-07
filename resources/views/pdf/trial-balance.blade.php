@extends('layouts.pdf')
@section('title', 'Laporan Neraca Saldo')
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
        <h3 class="text-center" style="margin-bottom: 5px">Laporan Neraca Saldo</h3>
        <span class="text-center text">Periode : {{ \Carbon\Carbon::parse($date)->isoFormat('MMMM Y') }}</span>

        <table class="table" style="margin-top: 5px">
            <thead>
                <tr>
                    <th>NO REF</th>
                    <th>AKUN</th>
                    <th>DEBET</th>
                    <th>KREDIT</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($trialBalances->account as $account)
                    <tr>
                        <td class="text-center">{{ $account->account_number }}</td>
                        <td>{{ $account->name }}</td>
                        <td style="text-align: left">Rp. {{ rupiah($account->pivot->debit) }}</td>
                        <td style="text-align: left">Rp. {{ rupiah($account->pivot->credit) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">JUMLAH</th>
                    <th style="text-align: left">Rp. {{ rupiah($trialBalances->account->sum('debit')) }}</th>
                    <th style="text-align: left">Rp. {{ rupiah($trialBalances->account->sum('credit')) }}</th>
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
