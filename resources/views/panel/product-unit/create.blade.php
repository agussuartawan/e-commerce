{!! Form::model($product_unit, [
    'route' => 'unit.store',
    'method' => 'POST',
    'id' => 'form-product-unit',
]) !!}

<div class="form-group">
    <label for="name">{{ __('Nama Unit') }}</label>
    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
</div>


{!! Form::close() !!}
