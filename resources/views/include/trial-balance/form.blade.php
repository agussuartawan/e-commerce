@php  
    $key = 1;
@endphp
@foreach($accounts as $account)
<tr>
    <input type="hidden" name="account_id[]" value="{{ $account->id }}">
    <td>
        {{ $account->account_number }}
    </td>
    <td>
        {{ $account->name }}
    </td>
    <td>
        {!! Form::text('debit[]', 0,['class' => 'form-control form-control-sm input-debit', 'id' => 'debit-' . $key]) !!}
    </td>
    <td>
        {!! Form::text('credit[]', 0,['class' => 'form-control form-control-sm input-credit', 'id' => 'credit-' . $key]) !!}
    </td>
</tr>
@php  
    $key++;
@endphp
@endforeach
