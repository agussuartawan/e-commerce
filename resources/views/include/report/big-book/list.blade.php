@forelse($accounts as $account)
    @if($account->general_journal)
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <h3 class="card-title">{{ $account->name }}</h3>
                            </div>

                            <div class="col d-flex justify-content-end">
                                <h3 class="card-title">{{ $account->account_number }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered" style="min-width: 50rem" id="big-book-report">
                            <thead class="text-center">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Akun</th>
                                    <th>No Ref</th>
                                    <th>Debit</th>
                                    <th>Kredit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($account->general_journal->whereBetween('date', $date) as $journal)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($journal->date)->isoFormat('DD MMMM Y') }}</td>
                                        <td>{{ $account->name }}</td>
                                        <td>{{ $account->account_number }}</td>
                                        <td>Rp. {{ rupiah($journal->debit) }}</td>
                                        <td>Rp. {{ rupiah($journal->credit) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data.</td>
                                    </tr>
                                @endforelse
                                @if(count($account->general_journal) != 0)
                                    <tr>
                                        <td colspan="3" class="text-center text-bold">Jumlah</td>
                                        <td class="text-bold">Rp. {{ rupiah($account->general_journal->whereBetween('date', $date)->sum('debit')) }}</td>
                                        <td class="text-bold">Rp. {{ rupiah($account->general_journal->whereBetween('date', $date)->sum('credit')) }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
@empty
    <div class="card card-outline card-info" style="position: relative;">
        <div class="card-body">
            <p>Data tidak ditemukan.</p>
        </div>
    </div>
@endforelse