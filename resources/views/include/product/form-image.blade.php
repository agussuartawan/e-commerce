{!! Form::open([
    'route' => ['product.image-form', $product],
    'method' => 'POST',
    'id' => 'form-image',
    'class' => 'dropzone',
]) !!}

<input type="file" name="file" />

{!! Form::close() !!}
