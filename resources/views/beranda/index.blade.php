@extends('layouts.general')
@section('title', 'Beranda')
@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-end">
                <div class="form-inline">
                    <input class="form-control mr-sm-2" type="search" value="{{ $search }}" name="search"
                        placeholder="Search" aria-label="Search" id="search">
                    <select name="category_id" id="category_id" class="form-control mr-sm-2 custom-select my-2">
                        <option value="0">Semua</option>
                        @foreach ($categories as $item)
                            <option value="{{ $item->id }}" @if ($category_id == $item->id) selected @endif>
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-success my-sm-0" id="btn-search">Cari</button>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            @forelse ($products as $product)
                <div class="col d-flex justify-content-center py-2">
                    <div class="card" style="width: 18rem;">
                        @if ($product->photo)
                            <img class="card-img-top" src="{{ asset('storage/' . $product->photo) }}"
                                alt="Card image cap">
                        @else
                            <img class="card-img-top" src="{{ asset('') }}/img/no-image.jpg" alt="Card image cap">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->product_name }}</h5>
                            <h6>Rp. {{ rupiah($product->selling_price) }}</h6>
                            <hr>
                            <p class="card-text">{{ $product->description }}</p>
                            <a href="{{ route('product.show', $product) }}" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col py-2">
                    <div class="card p-2">
                        <h3 class="text-center">Hello Esty..</h3>
                        <p>&emsp;Selamat udah sampe tahap Skripsi, semangat ngerjainnya ya, do your best :)</p>
                        <p>&emsp;Emmm... ada yang mau aku sampein. Mungkin suatu saat kita bakalan lost contact, entah
                            karena kesibukan masing-masing atau alasan lain. Jadi mumpung sekarang masih bisa komunikasi,
                            aku mau bilang kalo kali ini yang aku rasain ga main-main :).</p>
                        <p>&emsp;Mungkin dikesempatan sebelumnya aku keliatan ga serius, iya karena aku gatau mau ku apa.
                            Tapi sekarang aku udah belajar, aku udah punya tujuan.</p>
                        <p>&emsp;Kamu pernah ga sih mikirin orang, setiap hari, dan tiap keinget dia rasanya seneng aja
                            gitu. Padahal orang itu bukan siapa-siapa, bukan artis, bukan orang yang punya jasa dihidup
                            kamu, tapi kok bisa kalo keinget dia malah bikin seneng. Iya, karena orang itu udah ada dihati
                            kamu. Kalo kamu pernah ngerasain hal ini, artinya orang itu beruntung banget :).</p>
                        <p>&emsp;Aku gatau sekarang hati kamu milik siapa, tapi aku sangat amat berharap bukan milik
                            siapa-siapa hehehe</p>
                        <p>&emsp;Aku pengen bisa komunikasi tiap hari sama kamu, pengen denger ceritamu, pengen tau hari
                            hari mu, pengen dengerin keluh kesah mu, pengen selalu tau kabarmu dan masih banyak lagi.</p>
                        <p>Kalo kamu tanya kenapa? ya karna aku suka kamu :)</p>
                        <p class="mt-3">&emsp;Tenang, nanti pesan ini bakalan hilang kok kalo kamu udah nambah
                            data produk hehehe. Mungkin banyak hal yang ga sesuai sama yang kamu pengen tapi jangan lupa
                            selalu tersenyum ya, senyum mu indah banget soalnya :)</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('') }}/dist/js/beranda/index.js"></script>
@endpush
