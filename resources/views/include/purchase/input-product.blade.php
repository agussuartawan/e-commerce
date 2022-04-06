<tr>
    <td>
        {!! Form::select('', [], null, ['class' => 'form-control product-select', 'id' => 'product_id_' . $row, 'data-last-select' => 'true']) !!}
        <input id='hidden_{{ $row }}' type='hidden' name='product_id[]'>
    </td>
    <td>
        {!! Form::number('qty[]', null, ['class' => 'form-control qty', 'id' => 'qty_' . $row]) !!}
    </td>
    <td>
        {!! Form::text('production_price[]', null, ['class' => 'form-control money', 'id' => 'production_price_' . $row]) !!}
    </td>
    <td>
        @if ($row != 1)
            <a href="" class="btn-removes" id="btn-remove-'.{{ $row }}.'"><i
                    class="ik ik-trash-2 f-16 mr-15 text-danger"></i></a>
        @endif
    </td>
</tr>
