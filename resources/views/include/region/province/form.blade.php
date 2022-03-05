{!! Form::model($province,[
    'id' => 'form-province',
    'route' => $province->exists ? ['provinces.update', $province->id] : 'provinces.store',
    'method' => $province->exists ? 'PUT' : 'POST',
]) !!}

    <label for="name">Nama Provinsi</label>
    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}

{!! Form::close() !!}