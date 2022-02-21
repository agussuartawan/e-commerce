@if($trialBalance)
    @foreach($trialBalance->account as $account)
        <tr>
            <td>{{ $account->account_number }}</td>
            <td>{{ $account->name }}</td>
            <td>Rp. {{ rupiah($account->pivot->debit) }}</td>
            <td>Rp. {{ rupiah($account->pivot->credit) }}</td>
        </tr>
    @endforeach
    @if(count($trialBalance->account) != 0)
        <tr>
            <td colspan="2" class="text-bold text-center">Jumlah</td>
            <td class="text-bold">Rp. {{ $trialBalance->account->sum('debit') }}</td>
            <td class="text-bold">Rp. {{ $trialBalance->account->sum('credit') }}</td>
        </tr>   
    @endif
@else
    <tr>
        <td colspan="5" class="text-center">Data tidak ditemukan.</td>
    </tr>
@endif