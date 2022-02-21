@forelse($journals as $journal)
    <tr>
        <td>{{ \Carbon\Carbon::parse($journal->date)->isoFormat('DD MMMM Y') }}</td>
        <td>
            @if($journal->account->balance_type == 'Kredit')
                &emsp;{{ $journal->account->name }}
            @else
                {{ $journal->account->name }}
            @endif
        </td>
        <td>{{ $journal->account->account_number }}</td>
        <td>Rp. {{ rupiah($journal->debit) }}</td>
        <td>Rp. {{ rupiah($journal->credit) }}</td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center">Data tidak ditemukan.</td>
    </tr>
@endforelse

@if(count($journals) != 0)
    <tr>
        <td colspan="3" class="text-bold text-center">Jumlah</td>
        <td class="text-bold">Rp. {{ $debitSum }}</td>
        <td class="text-bold">Rp. {{ $creditSum }}</td>
    </tr>   
@endif