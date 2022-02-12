{!! Form::model($customers, [
    'route' => 'customers.store',
    'method' => 'POST',
    'id' => 'form-customer',
]) !!}

<div class="form-group">
    <label for="fullname">{{ __('Nama Lengkap') }}</label>
    {!! Form::text('fullname', null, ['class' => 'form-control', 'id' => 'fullname']) !!}
</div>

<div class="form-group">
    <label for="email">{{ __('Email') }}</label>
    {!! Form::text('email', null, ['class' => 'form-control', 'id' => 'email']) !!}
</div>

<div class="form-group">
    <label for="phone">{{ __('No Telpon') }}</label>
    {!! Form::text('phone', null, ['class' => 'form-control', 'id' => 'phone']) !!}
</div>

<div class="form-group">
    <label for="address">{{ __('Alamat') }}</label>
    {!! Form::textarea('address', null, ['class' => 'form-control', 'id' => 'address', 'rows' => 2]) !!}
</div>


{!! Form::close() !!}
