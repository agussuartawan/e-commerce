{!! Form::model($product_fragrance, [
    'route' => 'fragrance.store',
    'method' => 'POST',
    'id' => 'form-product-fragrance',
]) !!}

<div class="form-group">
    <label for="name">{{ __('Nama Aroma') }}</label>
    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
</div>


{!! Form::close() !!}
