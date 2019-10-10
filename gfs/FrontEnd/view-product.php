<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <link rel="shortcut icon" type="image/png" href="icons/favicon.ico">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/pricing.css" rel="stylesheet">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css-animation/wait-reply.css">
    <link rel="stylesheet" href="css/view-product.css">
  </head>
  <body>
  <div id="container-loader">
        <div class="loader">
            <span></span>
            <span></span>
            <span></span>
            <span></span> 
        </div> 
    </div>
    <div id="container-all">
  <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
          <img src="icons/Logotype-Black.svg" width="80px;" style="padding-top: 5.6px;">
          <h5 class="my-0 mr-md-auto font-weight-normal" style="font-size: 2rem">GiPo</h5>
          <nav class="my-2 my-md-0 mr-md-3">
          <a class="p-2 text-dark" href="GiPoHome.html">GiPo </a>
          <a class="p-2 text-dark" href="http://localhost/gfs/FrontEnd/perfil-compa%c3%b1ia.php">Mi Cuenta</a>
          <a class="p-2 text-dark" href="#">Curosear Empresas</a>
          </nav>
          <div class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Crear una Cuenta</a>
              <div class="dropdown-menu" aria-labelledby="dropdown01">
              <a class="dropdown-item" href="client-resgistry.html">Cliente</a>
              <a class="dropdown-item" href="company-registry.html">Empresas</a>
              </div>
          </div>
          <div class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Iniciar Sesion</a>
              <div class="dropdown-menu" aria-labelledby="dropdown01">
              <a class="dropdown-item" href="login-client.php">Cliente</a>
              <a class="dropdown-item" href="login-company.php">Empresa</a>
              </div>
          </div>
      </div>

    <div class="container" style="max-width: 1180px;">
        <div class="container">
        <h1 id="head">Esta Promocion Finaliza En:</h1>
        <ul>
            <li><span id="days"></span>Dias</li>
            <li><span id="hours"></span>Horas</li>
            <li><span id="minutes"></span>Minutos</li>
            <li><span id="seconds"></span>Segundos</li>
        </ul>
    </div>

    <div class="container" style="max-width:1200px;">
        <div class="row" >
            <div class="col-12">
                <h4 class="text-muted">Vendedor</h4>
                <div class="">
                    <img src="img/goku.png" alt="" class="rounded-circle" width="80px;">
                </div>
                <a id="email-container" style="text-decoration: underline;" href="">SkullCandyOfficialHN@gmail.com</a>
            </div>
            <div class="col-md-1 col-xl-1 my-2">
                <div class="row" id='colum-vertical'>
                </div>
            </div>
            <div class="col-md-11 col-xl-11 my-2" >
                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                    <div class="box">
                        <img id="picture-principal" class="card-img-right flex-auto d-none d-md-block" src="" alt="Card image cap">
                    </div>
                    <div class="card-body d-flex flex-column align-items-start">
                        <strong class="d-inline-block mb-2" id="price-descount" style="font-size: 3.5rem;"></strong>
                        <h4 class="text-muted" id="before-descount"></h4>
                    <h3 class="mb-0">
                        <a class="text-dark" id="title-promo" style="font-size: 1.2rem"></a>
                    </h3>
                    <div class="mb-1 text-muted" id="subtitle-promo"></div>
                    <p class="card-text mb-auto" id='description'></p>
                    <button type="button" class="btn btn-link" style="font-size: 1.2rem; color: black;">Comprar Producto</button>
                    </div> 
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4 more-left" id="horizontal-pictures">
            </div>
        </div>
        <div class="row my-2">
             <h1 id="head" class="found-in">Lo Puedes Encontrar En:</h1>
            <div id="map" class="form-control"></div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                    <div class="my-3 p-3 bg-white rounded box-shadow">
                        <h6 class="border-bottom border-gray pb-2 mb-0">Comentarios</h6>
                        <div>
                            <div class="media text-muted pt-3">
                                <div class="" style="padding-left: 45.7%">
                                        <img src="img/goku.png" alt="" class="rounded-circle" width="80px;">
                                </div>
                            </div>
                            <div>
                                <strong class="d-block text-gray-dark">@username</strong>
                                <span>
                                    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                        Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
                                    </p>
                                </span>
                            </div>
                        </div>
                        <div>
                            <div class="media text-muted pt-3">
                                <div class="" style="padding-left: 45.7%">
                                        <img src="img/goku.png" alt="" class="rounded-circle" width="80px;">
                                </div>
                            </div>
                            <div>
                                <strong class="d-block text-gray-dark">@username</strong>
                                <span>
                                    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                        Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
                                    </p>
                                </span>
                            </div>
                        </div>
                        <div>
                            <div class="media text-muted pt-3">
                                <div class="" style="padding-left: 45.7%">
                                        <img src="img/goku.png" alt="" class="rounded-circle" width="80px;">
                                </div>
                            </div>
                            <div>
                                <strong class="d-block text-gray-dark">@username</strong>
                                <span>
                                    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                        Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
                                    </p>
                                </span>
                            </div>
                        </div>
                        <small class="d-block text-right mt-3">
                            <a href="#">Mas Comentarios</a>
                        </small>
                    </div>
            </div>
        </div>
    </div>
              
      <footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
          <div class="col-12 col-md">
            <small class="d-block mb-3 text-muted">&copy; II-Periodo 2019 Proyecto de POO, Jorge Arturo Reyes Marin</small>
          </div>
        </div>
      </footer>
    </div>
</div>
    


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCxvGODTgLbBAiG5XQR-M886o1XsIHJmFo&callback=initMap" async defer></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/view-product.js"></script>
    <script src="js/popper.min.js"></script>
  </body>
</html>
