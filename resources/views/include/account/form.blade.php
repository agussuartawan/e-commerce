{!! Form::model($account, [
    'route' => $account->exists ? ['accounts.update', $account->id] : 'accounts.store',
    'method' => $account->exists ? 'PUT' : 'POST',
    'id' => 'form-account'
]) !!}

    <div class="form-group">
        <label for="account_type_id">Akun Tipe</label>
        {!! Form::select('account_type_id', $account_types, null, ['class' => 'form-control', 'id' => 'account_type_id']) !!}
    </div>

    @if($account->exists)
        <div class="form-group">
            <label for="account_number">No Ref</label>
            {!! Form::text('account_number', null, ['class' => 'form-control', 'id' => 'account_number']) !!}
        </div>
    @else
        <label for="account_number">No Ref</label>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="account_type_number">1 -</span>
            </div>
            {!! Form::text('account_number', null, ['class' => 'form-control', 'id' => 'account_number']) !!}
        </div>
    @endif

    <div class="form-group">
        <label for="name">Nama Akun</label>
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
    </div>

    <div class="form-group">
        <label for="description">Keterangan</label>
        {!! Form::text('description', null, ['class' => 'form-control', 'id' => 'description']) !!}
    </div>

{!! Form::close() !!}