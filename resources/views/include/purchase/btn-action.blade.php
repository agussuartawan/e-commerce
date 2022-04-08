<div class="row">
    <div class="col">
        <a href="{{ route('purchases.show', $data) }}" class="btn btn-sm btn-outline-success btn-block btn-show"
            title="Detail {{ $data->purchase_number }}">Detail</a>
    </div>
    <div class="col">
        <a href="{{ route('purchases.edit', $data) }}" class="btn btn-sm btn-outline-info btn-block modal-edit"
            title="Edit {{ $data->purchase_number }}" data-id="{{ $data->id }}">Edit</a>
    </div>
</div>
