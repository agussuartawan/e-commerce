{!! Form::model($purchase, [
    'route' => $purchase->exists ? ['purchases.update', $purchase->id] : 'purchases.store',
    'method' => $purchase->exists ? 'PUT' : 'POST',
    'id' => 'form-purchase',
]) !!}

<div class="form-group">
    <label for="date">Tanggal</label>
    {!! Form::date('date', date('Y-m-d'), ['class' => 'form-control', 'id' => 'date', 'required' => true]) !!}
</div>

<div class="table-responsive">
    <table class="table" id="purchase-create-table" style="min-width: 40rem">
        <thead>
            <tr>
                <th width="40%">Produk<span class="text-red">*</span></th>
                <th>Qty</th>
                <th>Harga Produksi</th>
                <th></th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

{!! Form::close() !!}
