@forelse($account_types as $account_type)
    <tr class="bg-light">
        <td class="text-bold">{{ $account_type->account_number }}</td>
        <td class="text-bold">{{ $account_type->name }}</td>
        <td></td>
        <td></td>
    </tr>
    @foreach($account_type->account as $account)
        <tr>
            <td>
                &emsp;{{ $account->account_number }}
            </td>
            <td>
                &emsp;{{ $account->name }}
            </td>
            <td>
                {{ $account->description }}
            </td>
            <td>
                <a href="{{ route('accounts.edit', $account) }}" class="btn btn-sm btn-block btn-outline-info">Edit</a>
            </td>
        </tr>
    @endforeach
@empty
    <tr>
        <td colspan="4" class="text-center">Data tidak ditemukan.</td>
    </tr>
@endforelse