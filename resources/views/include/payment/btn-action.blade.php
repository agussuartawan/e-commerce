<div class="row">
    <div class="col">
        <a href="{{ route('payments.show', $data->id) }}" class="btn btn-sm btn-outline-success btn-block btn-show"
            title="Detail Pembayaran">Detail</a>
    </div>

    <div class="col">
        <a href="{{ route('payments.edit', $data->id) }}" class="btn btn-sm btn-outline-info btn-block modal-edit"
            title="Edit Pembayaran">Edit</a>
    </div>
</div>
