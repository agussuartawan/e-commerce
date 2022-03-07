{!! Form::model($city, [
    'id' => 'form-city',
    'route' => $city->exists ? ['cities.update', $city->id] : 'cities.store',
    'method' => $city->exists ? 'PUT' : 'POST',
]) !!}

<div class="form-group">
    <label for="province_id">Provinsi</label>
    {!! Form::select('province_id', $provinces, null, ['class' => 'form-control custom-select', 'id' => 'province_id']) !!}
</div>

<div class="form-group">
    <label for="name">Nama Kota</label>
    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
</div>

{!! Form::close() !!}
