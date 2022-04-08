@if ($is_edit_form == 1)
    @php
        $r = 1;
    @endphp
    @foreach ($purchase->product as $p)
        <tr>
            <td>
                {!! Form::select('', [$p->product_name], null, ['class' => 'form-control product-select', 'id' => 'product_id_' . $r]) !!}
                <input id='hidden_{{ $r }}' type='hidden' name='product_id[]' value="{{ $p->id }}">
            </td>
            <td>
                {!! Form::number('qty[]', $p->pivot->qty, ['class' => 'form-control qty', 'id' => 'qty_' . $r]) !!}
            </td>
            <td>
                {!! Form::text('production_price[]', round($p->pivot->production_price), ['class' => 'form-control money', 'id' => 'production_price_' . $r]) !!}
            </td>
            <td>
                <a href="javascript:void(0)" class="badge badge-danger btn-removes"
                    id="btn-remove-'.{{ $r }}.'">hapus</a>
            </td>
        </tr>
        @php
            $r++;
        @endphp
    @endforeach
    <tr>
        <td>
            {!! Form::select('', [], null, ['class' => 'form-control product-select', 'id' => 'product_id_' . $r, 'data-last-select' => 'true']) !!}
            <input id='hidden_{{ $r }}' type='hidden' name='product_id[]'>
        </td>
        <td>
            {!! Form::number('qty[]', 1, ['class' => 'form-control qty', 'id' => 'qty_' . $r]) !!}
        </td>
        <td>
            {!! Form::text('production_price[]', 0, ['class' => 'form-control money', 'id' => 'production_price_' . $r]) !!}
        </td>
        <td>
        </td>
    </tr>
@else
    <tr>
        <td>
            {!! Form::select('', [], null, ['class' => 'form-control product-select', 'id' => 'product_id_' . $row, 'data-last-select' => 'true']) !!}
            <input id='hidden_{{ $row }}' type='hidden' name='product_id[]'>
        </td>
        <td>
            {!! Form::number('qty[]', 1, ['class' => 'form-control qty', 'id' => 'qty_' . $row]) !!}
        </td>
        <td>
            {!! Form::text('production_price[]', 0, ['class' => 'form-control money', 'id' => 'production_price_' . $row]) !!}
        </td>
        <td>
            @if ($row != 1)
                <a href="javascript:void(0)" class="badge badge-danger btn-removes"
                    id="btn-remove-'.{{ $row }}.'">hapus</a>
            @endif
        </td>
    </tr>
@endif
