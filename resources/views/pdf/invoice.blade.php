@extends('layouts.pdf')
@section('title', 'Invoice')
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

            .row {
                margin-left: -5px;
                margin-right: -5px;
            }

            .column {
                float: left;
                width: 50%;
                padding: 5px;
            }

            /* Clearfix (clear floats) */
            .row::after {
                content: "";
                clear: both;
                display: table;
            }

            .text-right {
                text-align: right;
            }

            .padding-right {
                padding-right: 5px;
            }

        </style>
    @endpush

    <div class="container">
        <h3 class="text-center" style="margin-bottom: 5px">Nota Penjualan</h3>

        <div class="row">
            <div class="column">
                <table>
                    <tr>
                        <td class="padding-right">Kepada</td>
                        <td class="padding-right">:</td>
                        <td class="padding-right">{{ $sale->customer->fullname }}</td>
                    </tr>
                    <tr>
                        <td class="padding-right">Alamat</td>
                        <td class="padding-right">:</td>
                        <td class="padding-right">{{ $sale->address }}</td>
                    </tr>
                </table>
            </div>

            <div class="column" style="text-align: right">
                <table>
                    <tr>
                        <td class="padding-right">Tanggal</td>
                        <td class="padding-right">:</td>
                        <td class="padding-right">{{ \Carbon\Carbon::parse($sale->date)->isoFormat('DD MMMM Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="padding-right">No Nota</td>
                        <td class="padding-right">:</td>
                        <td class="padding-right">{{ $sale->sale_number }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>NO BARANG</th>
                    <th>ITEM BARANG</th>
                    <th>SIZE</th>
                    <th>JUMLAH</th>
                    <th>SUBTOTAL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">{{ $sale->product->code }}</td>
                    <td>
                        {{ $sale->product->product_name }}
                        (Variasi : {{ $sale->product_color->name }}, {{ $sale->product_fragrance->name }})
                    </td>
                    <td class="text-center" class="text-center">{{ $sale->product->size }}
                        {{ $sale->product->product_unit_name }}</td>
                    <td class="text-center" class="text-center">{{ $sale->qty }}</td>
                    <td class="text-center" class="text-center">Rp. {{ rupiah($sale->grand_total) }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">JUMLAH</th>
                    <th>{{ $sale->qty }}</th>
                    <th>Rp. {{ rupiah($sale->grand_total) }}</th>
                </tr>
            </tfoot>
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
