@forelse($sales as $sale)
    <tr>
        <td>{{ $sale->sale_number }}</td>
        <td>{{ $sale->customer->fullname }}</td>
        <td>{{ $sale->product->product_name }}</td>
        <td>{{ $sale->qty }}</td>
        <td>Rp. {{ rupiah($sale->grand_total) }}</td>
        <td>{{ \Carbon\Carbon::parse($sale->date)->isoFormat('DD MMMM Y') }}</td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center">Data tidak ditemukan.</td>
    </tr>
@endforelse