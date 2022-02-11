{!! Form::model($product_color, [
    'route' => 'color.store',
    'method' => 'POST',
    'id' => 'form-product-color',
]) !!}

<div class="form-group">
    <label for="name">{{ __('Nama Warna') }}</label>
    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
</div>

<div class="form-group">
    <label for="hex_color">{{ __('Pilih Warna') }}</label>
    {!! Form::text('hex_color', null, ['class' => 'form-control color-picker', 'id' => 'hex_color']) !!}
</div>


{!! Form::close() !!}
