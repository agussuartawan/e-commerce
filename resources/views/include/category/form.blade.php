{!! Form::model($category, [
    'route' => $category->exists ? ['categories.update', $category->id] : 'categories.store',
    'method' => $category->exists ? 'PUT' : 'POST',
    'id' => 'form-category',
]) !!}

<div class="form-group">
    <label for="name">{{ __('Nama Kategori') }}</label>
    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
</div>


{!! Form::close() !!}
