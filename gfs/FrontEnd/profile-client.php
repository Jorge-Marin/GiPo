<?php
    require_once(__DIR__.'/../BackEnd/ajax/FirestoreDB/Firestore.php');
    require_once(__DIR__.'/../BackEnd/ajax/Usuarios/Class/User.php');
    if(!Usuario::verificarAutenticacion()){
      echo  Usuario::verificarAutenticacion();
    }
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title id="name-client"></title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/special.css">
    <link rel="stylesheet" href="css-animation/wait-reply.css">
    <link rel="stylesheet" href="css/company-registration.css">
    <link rel="stylesheet" href="css/profile-client.css">
    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="icons/favicon.ico">
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
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 bg-white border-bottom box-shadow">
        <img href="index.html" src="icons/Logotype-Black.svg" width="80px;" style="padding-top: 5.6px;">
      <h5 class="my-0 mr-md-auto font-weight-normal" style="font-size: 2rem">GiPo</h5>
      <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="GiPoHome.html">GiPo </a>
        <a class="p-2 text-dark" href="http://localhost/gfs/FrontEnd/perfil-compa%c3%b1ia.php">Mi Cuenta</a>
        <a class="p-2 text-dark" href="#">Curosear Empresas</a>
      </nav>
      <div class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" style='color:black; font-weight:lighter;' href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Crear una Cuenta</a>
          <div class="dropdown-menu" aria-labelledby="dropdown01">
            <a class="dropdown-item" href="client-resgistry.html">Cliente</a>
            <a class="dropdown-item" href="company-registry.html">Empresas</a>
          </div>
        </div>
      <div class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" style='color:black; font-weight:lighter;' href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Iniciar Sesion</a>
          <div class="dropdown-menu" aria-labelledby="dropdown01">
            <a class="dropdown-item" href="login-client.php">Cliente</a>
            <a class="dropdown-item" href="login-company.php">Empresa</a>
          </div>
        </div>
    </div>
        <div id="carousel-banners" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carousel-banners" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-banners" data-slide-to="1"></li>
                <li data-target="#carousel-banners" data-slide-to="2"></li>
            </ol>
            <div id="carousel-items" class="carousel-inner">
                <button class="buttons-simple-cools" id='banner-call-modal' onclick="queryGetBanners()">Cambiar Banners</button>
                <div class="carousel-item active">
                    <div  class="container-fluid backgrounds-divs box">
                        <img id="first-caoursel-item" src="" alt="">
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="container-fluid backgrounds-divs box">
                        <img id="second-caoursel-item"  src="" alt="">
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="container-fluid backgrounds-divs box">
                        <img id="third-caoursel-item" src="" alt="">
                    </div>
                </div>
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
                <a class="nav-item nav-link" id="nav-publications-tab" data-toggle="tab" href="#nav-publications" role="tab" aria-controls="nav-publications" aria-selected="true" onclick="getProfileInformation()">Perfil</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="container">
                    <div class="row" style="padding-left: 15px;
                        margin-top: 25px;">
                            <div class="col-xl-12 save-promotions">
                                <div class="row">
                                    <label class="title-promotions">Promociones Guardadas</label>
                                </div>
                                <hr style="margin: 1%;">
                                <div class="row">
                                    <div class="col-xl-2 text-center">
                                        <span><img src="icons/close-simple-black.svg" class='delete-item' alt=""></span>
                                        <span><img src="img/naruto.jpg" class="rounded-circle promotions-saves" alt=""></span><br>
                                        <span class="descount-promotion">25%</span><br>
                                        <small class="text-muted align-time">20:05:52</small>
                                        
                                    </div>
                                    <div class="col-xl-2 text-center">
                                        <span><img src="icons/close-simple-black.svg" class='delete-item' alt=""></span>
                                        <span><img src="img/goku.png" class="rounded-circle promotions-saves" alt=""></span><br>
                                        <span class="descount-promotion">25%</span><br>
                                        <small class="text-muted align-time">20:05:52</small>
                                        
                                    </div>
                                    <div class="col-xl-2 text-center">
                                        <span><img src="icons/close-simple-black.svg" class='delete-item' alt=""></span>
                                        <span><img src="img/sasuke.png" class="rounded-circle promotions-saves" alt=""></span><br>
                                        <span class="descount-promotion">25%</span><br>
                                        <small class="text-muted align-time">20:05:52</small>
                                        
                                    </div>
                                    <div class="col-xl-2 text-center">
                                        <span><img src="icons/close-simple-black.svg" class='delete-item' alt=""></span>
                                        <span><img src="img/luffy.jpg" class="rounded-circle promotions-saves" alt=""></span><br>
                                        <span class="descount-promotion">25%</span><br>
                                        <small class="text-muted align-time">20:05:52</small>
                                        
                                    </div>
                                    <div class="col-xl-2 text-center">
                                        <span><img src="icons/close-simple-black.svg" class='delete-item' alt=""></span>
                                        <span><img src="img/naruto.jpg" class="rounded-circle promotions-saves" alt=""></span><br>
                                        <span class="descount-promotion">25%</span><br>
                                        <small class="text-muted align-time">20:05:52</small>
                                    </div>
                                    <div class="col-xl-2 text-center">
                                        <span><img src="icons/close-simple-black.svg" class='delete-item' alt=""></span>
                                        <span><img src="img/naruto.jpg" class="rounded-circle promotions-saves" alt=""></span><br>
                                        <span class="descount-promotion">25%</span><br>
                                        <small class="text-muted align-time">20:05:52</small>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <a href="#" class="view-all">Ver Todas</a>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding-left: 15px;
                        margin-top: 25px;">
                        <div class="col-xl-12 save-promotions">
                            <div class="row">
                                <label class="title-promotions">Compañias Que Me Gustan</label>
                            </div>
                            <hr style="margin: 1%;">
                            <div class="row">
                                <div class="col-xl-2 text-center">
                                    <span><img src="icons/close-simple-black.svg" class='delete-item' alt=""></span>
                                    <span><img src="img/naruto.jpg" class="rounded-circle promotions-saves" alt=""></span><br>
                                    <span class="name-like-company">Name Company</span><br>
                                    
                                </div>
                                <div class="col-xl-2 text-center">
                                    <span><img src="icons/close-simple-black.svg" class='delete-item' alt=""></span>
                                    <span><img src="img/goku.png" class="rounded-circle promotions-saves" alt=""></span><br>
                                    <span class="name-like-company">Name Company</span><br>
                                    
                                </div>
                                <div class="col-xl-2 text-center">
                                    <span><img src="icons/close-simple-black.svg" class='delete-item' alt=""></span>
                                    <span><img src="img/sasuke.png" class="rounded-circle promotions-saves" alt=""></span><br>
                                    <span class="name-like-company">Name Company</span><br>
                                    
                                </div>
                                <div class="col-xl-2 text-center">
                                    <span><img src="icons/close-simple-black.svg" class='delete-item' alt=""></span>
                                    <span><img src="img/luffy.jpg" class="rounded-circle promotions-saves" alt=""></span><br>
                                    <span class="name-like-company">Name Company</span><br>
                                    
                                </div>
                                <div class="col-xl-2 text-center">
                                    <span><img src="icons/close-simple-black.svg" class='delete-item' alt=""></span>
                                    <span><img src="img/naruto.jpg" class="rounded-circle promotions-saves" alt=""></span><br>
                                    <span class="name-like-company">Name Company</span><br>
                                </div>
                                <div class="col-xl-2 text-center">
                                    <span><img src="icons/close-simple-black.svg" class='delete-item' alt=""></span>
                                    <span><img src="img/naruto.jpg" class="rounded-circle promotions-saves" alt=""></span><br>
                                    <span class="name-like-company">Name Company</span><br>
                                </div>
                            </div>
                            <div class="row text-center">
                                <a href="#" class="view-all">Ver Todas</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="my-3 p-3 bg-white rounded shadow-sm">
                            <h6 class="border-bottom border-gray pb-2 mb-0">Recent updates</h6>
                            <div class="media text-muted pt-3">
                                <img src="img/new/x-3.jpg" class="img-transaction-product" alt="">
                                <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                <strong class="d-block text-gray-dark">Name of Product <small class="text-muthed date-buy" ">12 de marzo del 2019</small></strong>
                                Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.<br>
                                <strong style="float: right;">Precio del Compra: L. 5824.00</strong><br>
                                <strong>Compañia Distribuidora: <a href="#">Company Name</a></strong>
                                </p>
                            </div>
                            <div class="media text-muted pt-3">
                                <img src="img/new/x-2.jpg" class="img-transaction-product" alt="">
                                <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                <strong class="d-block text-gray-dark">Name of Product <small class="text-muthed date-buy" ">12 de marzo del 2019</small></strong>
                                Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.<br>
                                <strong style="float: right;">Precio del Compra: L. 5824.00</strong><br>
                                <strong>Compañia Distribuidora: <a href="#">Company Name</a></strong>
                                </p>
                            </div>
                            <div class="media text-muted pt-3">
                                <img src="img/new/x-1.jpg" class="img-transaction-product" alt="">
                                <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                <strong class="d-block text-gray-dark">Name of Product <small class="text-muthed date-buy" ">12 de marzo del 2019</small></strong>
                                Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.<br>
                                <strong style="float: right;">Precio del Compra: L. 5824.00</strong><br>
                                <strong>Compañia Distribuidora: <a href="#">Company Name</a></strong>
                                </p>
                            </div>
                            <small class="d-block text-right mt-3">
                                <a href="#">Eliminar todas las Transacciones</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-publications" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div id="container-left" class="container-fluid" style="padding-top: 2%; padding-top: 4%;">
                </div>
            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="promotional-sheet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
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

<!--Modal Banner Gestor-->
<div class="modal fade" id="banners-gestor-view" tabindex="-1" role="dialog" aria-labelledby="image-profile-viewTitle" aria-hidden="true">
    <div id="modal-dialog-banners" class="modal-dialog" role="document" style="max-width:960px;">
        <div id="modal-content-banners" class="modal-content" style="width:1080px">
            <input type="file" id="new-banner-upload" style="width: 0px;" multiple>
        <div id="header-buttonsbanners-actions" class="modal-header">
            <label class="buttons-simple-cools" for="new-banner-upload">Subir Nuevos Banners</label>
            <button class="buttons-simple-cools" onclick="deleteBannersQuery()">Eliminar Banner</button>
            <button class="buttons-simple-cools" onclick="$('#banners-gestor-view').modal('hide')">Cerrar Ventana</button>
        </div>  
        <div id="body-modal-viewbanners" class="modal-body" style="width:100%;">       
        <div class="container">
            <div class="row" style="min-height:430px">
                <div id="spinner-loader-banner" class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="container">
                    <div class="col-xl-12 labels-active-banners" style="display:none;">
                        <div style="margin-bottom: 3%;">
                            <h3 style="width: 50%;color: white">Estado: Activo</h3>
                            <small class="text-muted">Un Maximo de un Banner</small>
                        </div>
                    </div>
                    <div id="container-banners-active" class="row" style="display:none;"> 
                    </div>
                </div>
                <div class="container">
                    <div class="col-xl-12 labels-active-banners" style="display:none;">
                        <div style="margin-bottom: 3%;">
                            <h3 style="width: 50%;color: white">Estado: Inactivos</h3>
                            <small class="text-muted">Use los Slider para Seleccionar</small>
                        </div>
                    </div>
                    <div id="container-banners-for-select" class="row" style="display:none;">
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div id="modal-footer-banners" class="modal-footer" style="width: 100%; border-top: none;">
            <button id="btn-active-banners" onclick="activeThisBanners()" type="button" class="btn btn-light">Activar Banners Seleccionados</button>
        </div>
        </div>
    </div>
</div>

<!--Eliminar la Cuenta Modal-->
<div class="modal fade show" id="delete-count-modal" tabindex="-1" role="dialog" aria-labelledby="image-profile-viewTitle" aria-modal="true">
  <div id="modal-dialog-acount" class="modal-dialog" role="document" style="max-width: 780px;">
    <div id="modal-content-acount" class="modal-content">
      <div id="body-modal-acount" class="modal-body" style="width: 80%;">
        <div class="container" style="color: white;">
            <div class="row">
    	        <div class="col-xl-3">
                    <i class="material-icons dp48" style="font-size: 7.6rem; margin-top: 8.7px;">report_problem</i>
                </div>
                <div class="col-xl-9">
                    <h3>Advertencia</h3>
                    <p class="card-text">
                        Esta a punto de Eliminar Su Cuenta, Si la elimina se borrara con ella todos sus productos,
                        y sus promociones, Para confirmar por favor ingrese su Contraseña
                    </p>
                </div>
            </div>
            <div class="row"><label style="padding: 25px 0px 0px 5px;">Contraseña</label>
                <input id="password-verify-account" class="form-control products rounded-input-text" onkeyup="activeDeleteAcountButton()" type="password" placeholder="Contraseña">
            </div>
            <div class="row">
                <button  type="button" class="btn btn-light" onclick="$('#delete-count-modal').modal('hide');" style="margin-right: 7px;">Cancelar</button>
                <button id="btn-delete-account" type="button" class="btn btn-light" onclick="queryDeleteAcount()" disabled>Confirmar</button>
            </div>
        </div>
    </div>
    </div>
  </div>
  </div>
</div>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCxvGODTgLbBAiG5XQR-M886o1XsIHJmFo&callback=initMap" async defer></script>
    <script src="js/bootstrap.min.js"></script>  
    <script src="js/dashboard.js"></script>
    <script src="js/queryClient.js"></script>
</body>
</html>

