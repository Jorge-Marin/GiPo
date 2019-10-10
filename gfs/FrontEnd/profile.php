<?php
    require_once(__DIR__.'/../BackEnd/ajax/FirestoreDB/FirestoreCompanies.php');
    require_once(__DIR__.'/../BackEnd/ajax/Usuarios/Class/User.php');
    
    if(!Usuario::verificarAutenticacion()){
        header('Location: login-client.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/special.css">
    <link rel="stylesheet" href="css-animation/wait-reply.css">
    <link rel="stylesheet" href="css/company-registration.css">
    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="icons/favicon.ico">
</head>
<body>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 bg-white border-bottom box-shadow">
            <img src="icons/Logotype-Black.svg" width="80px;" style="padding-top: 5.6px;">
        <h5 class="my-0 mr-md-auto font-weight-normal" style="font-size: 2rem">GiPo</h5>
        <nav class="my-2 my-md-0 mr-md-3">
            <a class="p-2 text-dark" href="http://localhost/gfs/FrontEnd/index.html">GiPo </a>
            <a class="p-2 text-dark" href="http://localhost/gfs/FrontEnd/perfil-compa%c3%b1ia.php">Mi Cuenta</a>
            <a class="p-2 text-dark" href="#">Curosear Empresas</a>
        </nav>
        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="
        background-color: black; margin-right: 5px" >Sign In as</button>
        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="
        background-color: black;">Log In as</button>

        </div>
    <div id="container-loader">
        <div class="loader">
            <span></span>
            <span></span>
            <span></span>
            <span></span> 
        </div> 
    </div>
    <div id="container-all">
        <div id="carousel-banners" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carousel-banners" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-banners" data-slide-to="1"></li>
                <li data-target="#carousel-banners" data-slide-to="2"></li>
            </ol>
            <div id="carousel-items" class="carousel-inner">
            </div>
            <a class="carousel-control-prev" href="#carousel-banners" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel-banners" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: #101010 !important; padding-left: 27px;">
        <div id="here-logotype" class="box container-logotype rounded-circle" onclick="getImageProfile()">
            <img id="image-profile" src="">    
        </div>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active name-company" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"></a>
                <a class="nav-item nav-link" id="nav-promotions-tab" data-toggle="tab" href="#nav-promotions" role="tab" aria-controls="nav-promotions" aria-selected="false" onclick='getPromotions()'>Promociones</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div id="container-left" class="container-fluid" style="padding-top: 2%; padding-top: 4%;">
                            <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                <div id="container-loader" style="display: block;">
                                <div id="spinner-loader" class="spinner-border spinner-profile" role="status" style="display: block; left: 47.1% !important;">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                </div>
                                <div id="profile-content" class="container-fluid profile-container">
                                <div class="container-fluid box container-logotype  image-principal-profile">
                                    <img id="img-profile-principal" src="img/naruto.jpg" class="bd-placeholder-img rounded-circle" width="160px" alt="">
                                </div>
                                <div class="container-fluid text-center">
                                    <label id="name-company-label" class="name-company-p" style="font-size: 2rem;"></label><br>
                                    <label id="email-label" class="email-direction"></label>
                                </div>
                                <div class="container-fliud" id="information-profile">
                                        <div class="container-fluid history">
                                            <div class="row icons-show-information">
                                                <div class="col-xl-4">
                                                        <span class="icons-presentation">
                                                            <i class="fas fa-rocket"></i>
                                                        </span>
                                                        <span>
                                                            <p class="down-icons-description">Mision</p>
                                                        </span>
                                                        <span>
                                                            <p id="mision" class="container-information">
                                                            </p>
                                                        </span>
                                                </div>
                                                <div class="col-xl-4">
                                                    <span class="icons-presentation">
                                                        <i class="fas fa-glasses"></i>
                                                    </span>
                                                    <span>
                                                        <p class="down-icons-description">Vision</p>
                                                    </span>
                                                    <span>
                                                        <p id="vision"  class="container-information">
                                                        </p>
                                                    </span>
                                                </div>
                                                <div class="col-xl-4">
                                                    <span class="icons-presentation">
                                                        <i class="far fa-address-book"></i>
                                                    </span>
                                                    <span>
                                                        <p class="down-icons-description">Contactanos</p>
                                                    </span>
                                                    <span>
                                                        <p id="phones-numbers" class="container-information">
                                                            <span></span>
                                                            <span></span>
                                                            <span></span>
                                                        </p>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container-fluid ubication" style="background-color: #ffdf01">
                                            <div class="row">
                                                <div class="col-xl-5">
                                                    <h1 class="big-title" style="color: white; padding: 3% 0% 0% 3%">Ubicacion</h1>
                                                    <div class="direction" style="color: white">
                                                        <h5>Direccion</h5>
                                                        <p id="direction-description">
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-xl-7" style="padding: 2% 4.3% 2% 4.3%;">
                                                    <div id="map" style="height: 450px; position: relative; overflow: hidden;"><div style="height: 100%; width: 100%; position: absolute; top: 0px; left: 0px; background-color: rgb(229, 227, 223);"><div class="gm-err-container"><div class="gm-err-content"><div class="gm-err-icon"><img src="https://maps.gstatic.com/mapfiles/api-3/images/icon_error.png" draggable="false" style="user-select: none;"></div><div class="gm-err-title">Se ha producido un error.</div><div class="gm-err-message">Esta página no ha cargado Google Maps correctamente. Descubre los detalles técnicos del problema en la consola de JavaScript.</div></div></div></div></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container-fluid" style="background-color:white;">
                                            <div class="row">
                                                <div class="col-xl-12" style="padding-left: 5%;">
                                                    <h2 class="big-title" style="color: black; padding-top: 5.6%;
                                                    font-size: 4rem;">Oferta Destacada</h2>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="description">
                                                        <div class="rounded-circle desconunt-circle">
                                                            25%
                                                        </div>
                                                        <h4 class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit.</h4>
                                                        <hr>
                                                        <p class="text-center" style="margin-bottom: 0px">Precio de Oferta : <strong>L. 8095.62</strong></p>
                                                        <p class="text-center" style="margin-bottom: 0px">Precio de Original: <strong><del> 1095.62</del></strong></p>
                                                        <button type="button" class="rounded-pill">Ver Detalles de Compra</button>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6" style="padding: 100px 0px 0px 0px;">
                                                    <img src="img/new/1.jpg" width="400px" alt="">
                                                    <div class="more-pictures">
                                                        <div class="pictures active"><img src="img/new/1.jpg" alt=""></div>
                                                        <div class="pictures"><img src="img/new/2.jpg" alt=""></div>
                                                        <div class="pictures"><img src="img/new/3.jpg" alt=""></div>
                                                        <div class="pictures"><img src="img/new/4.jpg" alt=""></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                
            </div>
            <div class="tab-pane fade" id="nav-promotions" role="tabpanel" aria-labelledby="nav-promotions-tab">
                <div class="container" style="margin-top: 50px;">
                    <div id="container-products-register">
                        <div class="row">
                            <h3 style="margin-top:25px;  margin-bottom: 0px">Productos En Promocion</h3>
                        </div>
                        <hr style="width: 95%; margin-top: 0px; background-color: #495057">
                            <div class="row" id='products-in-promotions'>
                            </div>
                        </div>
                        <div class="modal fade" id="promotional-sheet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                                </div>
                                <div class="modal-body">
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
            </div>
            

<!--Modal ImageProfile View-->
<div class="modal fade" id="image-profile-view" tabindex="-1" role="dialog" aria-labelledby="image-profile-viewTitle" aria-hidden="true">
  <div id="modal-dialog-imgprofile" class="modal-dialog" role="document">
    <div id="modal-content-imgprofile" class="modal-content">
      <input type="file" id="new-image-upload" style="width: 0px;">
      <div id="header-buttonsProfile-actions" class="modal-header">
      </div>  
      <div id="body-modal-viewprofile" class="modal-body">       
      </div>
      <div id="modal-footer-profile" class="modal-footer" style="width: 100%; border-top: none;">
      </div>
    </div>
  </div>
</div>


<            
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCxvGODTgLbBAiG5XQR-M886o1XsIHJmFo&callback=initMap" async defer></script>
    <script src="js/bootstrap.min.js"></script>  
    <script src="js/visit-profile-company.js"></script>
</body>
</html>
