{!! Form::model($journal, [
    'route' => ['journals.update', $journal],
    'method' => 'PUT',
    'id' => 'form-journal',
]) !!}

<div class="form-group">
    <label for="date">Tanggal</label>
    {!! Form::date('date', null, ['class' => 'form-control', 'id' => 'date']) !!}
</div>

<div class="form-group">
    <label for="account_id">Akun</label>
    {!! Form::select('account_id', $accounts, null, ['class' => 'form-control', 'id' => 'account_id']) !!}
</div>

<div class="form-group">
    <label for="debit">Debit</label>
    {!! Form::text('debit', null, ['class' => 'form-control', 'id' => 'debit']) !!}
</div>

<div class="form-group">
    <label for="credit">Kredit</label>
    {!! Form::text('credit', null, ['class' => 'form-control', 'id' => 'credit']) !!}
</div>

{!! Form::close() !!}
