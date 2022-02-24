<!DOCTYPE html>
<html>

<head>
    <title>Laporan Produk Bundel</title>
</head>

<body>
    <style type="text/css">
        * {
            font-family: sans-serif;
        }

        h3 {
            font-weight: bold;
        }

        table {
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
            vertical-align: top;
            padding: 3px 3px;
            border: 1px solid #000000;
        }

        .text-center {
            text-align: center;
        }

        .ml-4 {
            margin-left: 4px;
        }

        img {
            width: 100px;
            float: left;
        }

        .heading {
            margin-bottom: 70px;
        }

    </style>
    <div class="heading">
        <img src="{{ asset('img/logo.png') }}" alt="Logo">
        <span style="margin-top: 5px">CV. Murni Sejati</span><br>
        <span>Jl. Raya Dalung Utara No. 99 ( belakang Gong Cafe ), Abianbase, Badung - Bali, Dalung, Kuta Utara, Dalung,
            Kec. Kuta Utara, Kabupaten Badung, Bali 80361</span><br>
        <span>0818-367-057</span>
    </div>
    <hr>
    <div class="title">
        <h3>Form Order Barang</h3>
        <p class="text">No : {{ $sale->sale_number }}</p>
        <p class="text">Tanggal : {{ Carbon\Carbon::parse($sale->date)->isoFormat('DD MMMM Y') }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Item Barang</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">
                    <p>1</p>
                </td>
                <td class="ml-4">
                    <p>{{ $sale->customer->fullname }}</p>
                </td>
                <td class="ml-4">
                    <p>{{ $sale->product->product_name }}</p>
                </td>
                <td class="ml-4 text-center">
                    <p>{{ $sale->qty }} {{ $sale->product->product_unit->name }}</p>
                </td>
            </tr>
        </tbody>
    </table>

    <table style="margin-top: 10px; text-align: center">
        <tbody>
            <tr>
                <td>Diterima Oleh</td>
                <td>Diperiksa Oleh</td>
                <td>Diorder Oleh</td>
            </tr>
            <tr>
                <td colspan="3">
                    <p></p>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <p></p>
                </td>
            </tr>
            <tr>
                <td>(............................)</td>
                <td>(............................)</td>
                <td>(............................)</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
