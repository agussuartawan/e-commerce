<div class="row">
    <div class="col">
        <h6>No : {{ $purchase->purchase_number }}</h6>
        <h6>Tanggal : {{ \Carbon\Carbon::parse($purchase->date)->format('d/m/Y') }}</h6>
    </div>
</div>
<div class="row">
    <div class="col">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Qty</th>
                    <th>Harga Produksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchase->product as $product)
                    <tr>
                        <td>{{ $product->code }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->pivot->qty }}</td>
                        <td>{{ rupiah($product->pivot->production_price) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
