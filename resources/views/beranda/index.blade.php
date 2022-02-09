@extends('layouts.general')
@section('title', 'Beranda')
@section('content')
<div class="container mt-2">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-end">
            <form class="form-inline">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <select name="" id="" class="form-control mr-sm-2 custom-select my-2">
                    <option value="">Kategori 1</option>
                    <option value="">Kategori 2</option>
                </select>
                <button class="btn btn-outline-success my-sm-0" type="submit">Cari</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 py-2">
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" src="{{ asset('img/no-image.jpg') }}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Sabun cuci muka</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam facere, vitae, debitis voluptatum eveniet magni expedita eligendi laborum perspiciatis velit, quidem ex corrupti maxime alias consectetur? Optio delectus soluta pariatur?</p>
                    <a href="#" class="btn btn-primary">Detail</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 py-2">
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" src="{{ asset('img/no-image.jpg') }}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Pelembab Bibir</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste dolorem ab at porro cum molestias possimus? Placeat quaerat laudantium quod necessitatibus aspernatur, corrupti provident impedit, soluta odio quia nesciunt rerum?</p>
                    <a href="#" class="btn btn-primary">Detail</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 py-2">
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" src="{{ asset('img/no-image.jpg') }}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Sabun Cuci Muka</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus illo vero facilis quae, quos eaque aspernatur quas. Pariatur, sit, debitis fugit at omnis nulla eius alias hic, facere obcaecati tempora?</p>
                    <a href="#" class="btn btn-primary">Detail</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection