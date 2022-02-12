{!! Form::model($bank, [
    'route' => $bank->exists ? ['banks.update', $bank->id] : 'banks.store',
    'method' => $bank->exists ? 'PUT' : 'POST',
    'id' => 'form-bank',
]) !!}

<div class="form-group">
    <label for="name">{{ __('Nama Bank') }}</label>
    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
</div>

<div class="form-group">
    <label for="account_number">{{ __('No Rekening') }}</label>
    {!! Form::text('account_number', null, ['class' => 'form-control', 'id' => 'account_number']) !!}
</div>


{!! Form::close() !!}
