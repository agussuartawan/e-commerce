<div class="row">
    <div class="col">
        <div class="row">
            <div class="col">
                <label class="col-form-label text-md-end">Aroma Tersedia</label>
            </div>
        </div>

        <div class="row fragrance-row">
            <div class="col">
                @foreach ($product->product_fragrance as $key => $fragrance)
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="product_fragrance_id{{ $key }}"
                            name="product_fragrance_id" class="custom-control-input"
                            value="{{ $fragrance->id }}" @if($fragrance->id === $sale->product_fragrance_id) checked="true" @endif>
                        <label class="custom-control-label"
                            for="product_fragrance_id{{ $key }}" style="font-weight: normal!important">{{ $fragrance->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="row">
            <div class="col">
                <label class="col-form-label text-md-end">Warna Tersedia</label>
            </div>
        </div>

        <div class="row color-row">
            <div class="col">
                @foreach ($product->product_color as $key => $color)
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="product_color_id{{ $key }}"
                            name="product_color_id" class="custom-control-input"
                            value="{{ $color->id }}" @if($color->id === $sale->product_color_id) checked="true" @endif>
                        <label class="custom-control-label"
                            for="product_color_id{{ $key }}" style="font-weight: normal!important">{{ $color->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>