<div id="appended">
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-info" style="position: relative;">
                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered" style="min-width: 50rem" id="income-report">
                        <thead class="text-center">
                            <tr>
                                <th width="40%">No Barang Masuk</th>
                                <th width="40%">Tgl</th>
                                <th width="20%">Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($incomes as $income)
                                <tr>
                                    <td>{{ $income->purchase_number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($income->date)->isoFormat('DD MMMM Y') }}</td>
                                    <td class="text-center">{{ $income->product->sum('pivot.qty') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Data tidak ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="text-center">
                            <tr>
                                <th colspan="2">Total Barang Masuk</th>
                                <th>{{ rupiah($sum_income) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-info" style="position: relative;">
                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered" style="min-width: 50rem" id="avenue-report">
                        <thead class="text-center">
                            <tr>
                                <th width="40%">No Penjualan</th>
                                <th width="40%">Tgl</th>
                                <th width="20%">Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($avenues as $avenue)
                                <tr>
                                    <td>{{ $avenue->sale_number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($avenue->date)->isoFormat('DD MMMM Y') }}</td>
                                    <td class="text-center">{{ $avenue->qty }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Data tidak ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="text-center">
                            <tr>
                                <th colspan="2">Total Barang Keluar</th>
                                <th>{{ rupiah($avenues->sum('qty')) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
