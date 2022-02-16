{!! Form::model($sale,[
    'route' => ['sales.update', $sale],
    'method' => 'PUT',
    'id' => 'form-order',
]) !!}
        <input type="hidden" id="sale_id" value="{{ $sale->id }}">
        <input type="hidden" id="price" value="{{ $sale->product->selling_price }}">

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="customer_id">Nama Pelanggan</label>
                    {!! Form::select('customer_id', $customers, null, ['class' =>'form-control', 'id' => 'customer_id']) !!}
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="date">Tanggal</label>
                    {!! Form::date('date', \Carbon\Carbon::parse($sale->date)->format('Y-m-d'), ['class' =>'form-control', 'id' => 'date']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="product_id">Nama Produk</label>
                    {!! Form::select('product_id', $products, null, ['class' =>'form-control', 'id' => 'product_id']) !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="qty">Jumlah Barang</label>
                    <div class="input-group" id="input-qty">
                        <div class="input-group-btn">
                            <button class="btn btn-default btn-number" data-type="minus" data-field="qty">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control input-number" name="qty" id="qty" value="1"
                            min="1" max="1000">
                        <div class="input-group-btn">
                            <button class="btn btn-default btn-number" data-type="plus" data-field="qty">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="load-variant-here"></div>

        <div class="row mt-3">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="province">Provinsi</label>
                    {!! Form::select('province_id', $provinces, null, ['class' => 'form-control custom-select', 'id' => 'province_id']) !!}
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="city">Kota</label>
                    {!! Form::select('city_id', $cities, null, ['class' => 'form-control custom-select', 'id' => 'city_id']) !!}
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    @php
                        if ($sale->payment_status == 'lunas' || $sale->payment_status == 'menunggu konfirmasi') {
                            $disable = true;
                        } else {
                            $disable = false;
                        }
                    @endphp
                    <label for="bank">Bank Tujuan</label>
                    {!! Form::select('bank_id', $banks, null, ['class' => 'form-control custom-select', 'id' => 'bank_id', 'disabled' => $disable]) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="address">Tujuan Pengiriman</label>
                    {!! Form::textarea('address', null, ['class' => 'form-control', 'rows' => 2, 'id' => 'address']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
            </div>
            <div class="col text-right">
                <h4>Total (Rp)</h4>
            </div>
            <div class="d-flex flex-column text-right pr-3">
                <h4 id="grand_total">0</h4>
            </div>
        </div>
{!! Form::close() !!}