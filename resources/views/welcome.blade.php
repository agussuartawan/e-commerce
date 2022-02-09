<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
        <title>Hello, world!</title>
      </head>
      <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">CV. Murni Sejati</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
            
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Beranda <span class="sr-only">(current)</span></a> 
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Daftar</a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <select name="" id="" class="form-control mr-sm-2">
                        <option value="">Kategori 1</option>
                        <option value="">Kategori 2</option>
                    </select>
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Cari</button>
                </form>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="{{ asset('img/no-image.jpg') }}" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Sabun cuci muka</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam facere, vitae, debitis voluptatum eveniet magni expedita eligendi laborum perspiciatis velit, quidem ex corrupti maxime alias consectetur? Optio delectus soluta pariatur?</p>
                            <a href="#" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="{{ asset('img/no-image.jpg') }}" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Pelembab Bibir</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste dolorem ab at porro cum molestias possimus? Placeat quaerat laudantium quod necessitatibus aspernatur, corrupti provident impedit, soluta odio quia nesciunt rerum?</p>
                            <a href="#" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
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
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      </body>
</html>
