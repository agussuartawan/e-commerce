{!! Form::model($user, [
    'route' => ['users.update', $user],
    'method' => 'PUT',
    'id' => 'form-user',
]) !!}

<div class="form-group">
    <label for="name">{{ __('Nama User') }}</label>
    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
</div>

<div class="form-group">
    <label for="email">{{ __('Email') }}</label>
    {!! Form::text('email', null, ['class' => 'form-control', 'id' => 'email']) !!}
</div>

<div class="form-group">
    <label for="role">{{ __('Hak akses') }}</label>
    {!! Form::select('role', $roles, $user->roles()->pluck('role_id'), ['class' => 'form-control', 'id' => 'role']) !!}
</div>


{!! Form::close() !!}
