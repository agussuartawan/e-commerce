@extends('layouts.pdf')
@section('title', 'Form Order')
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

            .text-center {
                text-align: center;
            }

        </style>
    @endpush

    <div class="container">
        <h3 class="text-center" style="margin-bottom: 5px">Form Order Barang</h3>
        <div class="inline" style="margin-bottom: 5px">
            <span>No : {{ $sale->sale_number }}</span>
            <span style="float: right">Tanggal : {{ \Carbon\Carbon::parse($sale->date)->isoFormat('DD MMMM Y') }}</span>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>NAMA PELANGGAN</th>
                    <th>ITEM BARANG</th>
                    <th>JUMLAH</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td>{{ $sale->customer->fullname }}</td>
                    <td>{{ $sale->product->product_name }}</td>
                    <td>{{ $sale->qty }} {{ $sale->product->product_unit->name }}</td>
                </tr>
            </tbody>
        </table>

        <table style="width: 100%; margin-top: 20px">
            <tr class="text-center">
                <td>Diterima Oleh</td>
                <td>Diperiksa Oleh</td>
                <td>Dipesan Oleh</td>
            </tr>
            <tr>
                <td class="text-center"><img src="{{ asset('img/ttd-admin.png') }}" alt=""></td>
                <td class="text-center"><img src="{{ asset('img/ttd-gudang.png') }}" alt=""></td>
            </tr>
            <tr class="text-center">
                <td>(...................)</td>
                <td>(...................)</td>
                <td>(...................)</td>
            </tr>
        </table>
    </div>

@endsection
