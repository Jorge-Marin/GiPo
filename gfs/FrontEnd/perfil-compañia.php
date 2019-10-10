<?php
    require_once(__DIR__.'/../BackEnd/ajax/FirestoreDB/FirestoreCompanies.php');
    require_once(__DIR__.'/../BackEnd/ajax/Empresas/Companies.php');
    if(!Companies::verificarAutenticacion()){
        header('Location: client-company.php');
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
</head>
<body>
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
                <a class="nav-item nav-link" id="nav-publications-tab" data-toggle="tab" href="#nav-publications" role="tab" aria-controls="nav-publications" aria-selected="true">Perfil</a>
                <a class="nav-item nav-link" id="nav-products-tab" data-toggle="tab" href="#nav-products" role="tab" aria-controls="nav-products" aria-selected="false">Productos</a>
                <a class="nav-item nav-link" id="nav-promotions-tab" data-toggle="tab" href="#nav-promotions" role="tab" aria-controls="nav-promotions" aria-selected="false">Promociones</a>
                <a class="nav-item nav-link" id="nav-contact-tab" href='' data-toggle="tab" role="tab"  onclick='logout()'>Cerrar Sesion</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="container-fluid">
                    <div class="row">
                        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                        <div class="sidebar-sticky">
                            <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">
                                <span data-feather="home"></span>
                                    Mi Actividad <span class="sr-only">(current)</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                <span data-feather="shopping-cart"></span>
                                    Ventas Por Dias
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                <span data-feather="users"></span>
                                    Seguidores Por Mes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                <span data-feather="bar-chart-2"></span>
                                    Visitas a Su Perfil
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                <span data-feather="layers"></span>
                                    Fichas Promocionales Impresas
                                </a>
                            </li>
                            </ul>
                    
                            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Saved reports</span>
                            <a class="d-flex align-items-center text-muted" href="#">
                                <span data-feather="plus-circle"></span>
                            </a>
                            </h6>
                            <ul class="nav flex-column mb-2">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Current month
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Last quarter
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Social engagement
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Year-end sale
                                </a>
                            </li>
                            </ul>
                        </div>
                        </nav>
                    
                        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                            <h1 class="h2">Dashboard</h1>
                            <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group mr-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                                <span data-feather="calendar"></span>
                                This week
                            </button>
                            </div>
                        </div>
                    
                        <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>
                        </main>
                    </div>
                    </div>
            </div>
            <div class="tab-pane fade" id="nav-publications" role="tabpanel" aria-labelledby="nav-profile-tab">
            <div id="container-left" class="container-fluid" style="padding-top: 2%; padding-top: 4%;">
                            <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                <div id="container-loader" style="display: block;">
                                <div id="spinner-loader" class="spinner-border spinner-profile" role="status" style="display: block; left: 47.1% !important;">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                </div>
                                <div id="profile-content" class="container-fluid profile-container">
                                <div class="container-uptdate-delete-options">
                                    <i onclick="fieldUpdateGenerate()" id='editInformation'  class="material-icons dp48 profile-actions-buttons"  style="margin-right: 5.7px;"  data-toggle="tooltip" data-placement="top" title="Actualizar Informacion">edit</i>
                                    <i onclick="$('#delete-count-modal').modal('show');"  id='deleteAccount' class="material-icons dp48 profile-actions-buttons"   data-toggle="tooltip" data-placement="top" title="Eliminar Cuenta">delete_forever</i>
                                </div>
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
                    <div class="container" id="container-form-items" style="display:none;">
                    </div> 
            </div>
            <div class="tab-pane fade" id="nav-products" role="tabpanel" aria-labelledby="nav-products-tab">
                    <div class="container" style="margin-top: 50px;">
                        <div class="col-xl-12" style="padding-left: 76%;">
                            <div id="add-remove-fields" class="row">
                                <button id="more" class="alert-message add-more" onclick="createFieldsProducts()" style="top: -20.6px;
                                left: -393px;">Agregar Nuevos Productos +</button>
                            </div>
                        </div>
                        <div id="fields-add-product">
                            <input type="file" id="image-product" multiple>
                        </div>
                        <div id="container-products-register">
                            <div class="row" id="products-container">
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" style="max-width: 340px;" role="document">
                            <div class="modal-content" style="background-color: white;">
                                <div class="modal-header">
                                    <h5 class="modal-title">Confirmacion Para Eliminar</h5>
                                </div>
                            <div class="modal-body">
                                <div class="row exclamation-simbol">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                                <div class="row">
                                    <label class="card-text" style="padding: 17.3px; font-weight: 400;">¿Esta Seguro de Eliminar Este Producto?</label>
                                </div>
                                <div class="row" style="padding-left: 18%;">
                                    <button type="button" class="btn btn-light mx-2 my-2" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-warning mx-2 my-2 btn-color-accept">Aceptar</button>                                                        
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="tab-pane fade" id="nav-promotions" role="tabpanel" aria-labelledby="nav-promotions-tab">
                    <div class="container" style="margin-top: 50px;">
                        <div class="row" style="padding-left: 25%;">
                        </div>
                        <div id="container-products-register">
                            <div class="row">
                                <h3 style="margin-top:25px;  margin-bottom: 0px">Productos En Promocion</h3>
                            </div>
                            <hr style="width: 95%; margin-top: 0px; background-color: #495057">
                                <div class="row" id='products-in-promotions'>
                                </div>
                                <div class="row" id="content-static-products">
                                    <div class="row">
                                        <h3 style="margin-top:25px; margin-bottom: 0px">Productos Fuera Promocion</h3>
                                    </div>
                                    <hr style="width: 95%; margin-top: 0px; background-color: #495057">
                            </div>
                            <div class="modal fade" id="details-promotions" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document" style="max-width: 820px;">
                                    <div class="modal-content" style="background-color: white;">
                                    <div class="modal-body" style='width:80%'>
                                        <div class="row" style="padding-left: 27.8%;">
                                            <h3>Detalles de Promocion</h3>
                                        </div>	
                                        <hr style="background: gray;">
                                        <div class="container" style="padding: 25px 10px;">
                                        <form id='form-promotions'>
                                            <label class="label-fields">Precio de Promocion</label>
                                            <div>
                                                <input id="promotions-price" value='ajaljals' name="promotions-price" type="text" class="form-control rounded-input-text" placeholder="Precio de Promocion: L. 0000.00">
                                                <div class="valid-feedback">
                                                    Ok
                                                </div>
                                                <div class="invalid-feedback">
                                                    Campo obligatorio
                                                </div>
                                            </div>
                                            <label class="label-fields">Precio Original</label>
                                            <div>
                                                <input  id="original-price" value='ajaljals' name="original-price"type="text" class="form-control rounded-input-text" placeholder="Precio Original: L. 0000.00">
                                                <div class="valid-feedback">
                                                    Ok
                                                </div>
                                                <div class="invalid-feedback">
                                                    Campo obligatorio
                                                </div>
                                            </div>
                                            <label for="" class="label-fields">Cantidad de Productos por ese Precio</label>
                                            <div class="quantity-input">
                                            <button id="decrement" class="quantity-input__modifier quantity-input__modifier--left increment-decrement" onclick="decrement()">—</button>
                                            <div>
                                                <input id="size-promotion" name="size-promotion" type="text" id="value-size" class="quantity-input__screen" value="1" style='width:50%;'>
                                                <div class="valid-feedback">
                                                    Ok
                                                </div>
                                                <div class="invalid-feedback">
                                                    Campo obligatorio
                                                </div>
                                            </div>
                                            <button id="increment" class="quantity-input__modifier quantity-input__modifier--right increment-decrement" onclick="increment()">＋</button>
                                            </div>
                                            <label for="" class="label-fields">Duracion de la Promocion</label>
                                            <div id="floating-panel">
                                                    <input class="btn btn-outline-secondary" onclick="clearMarkers();" type="button" value="Esconder Marcadores">
                                                    <input class="btn btn-outline-secondary" onclick="showMarkers();" type="button" value="Mostrar Todos">
                                                    <input class="btn btn-outline-secondary" onclick="deleteMarkers();" type="button" value="Eliminar Marcadores">
                                            </div>
                                            <div id="mapPromotions" class="form-control" style="height:410px"></div>
                                            <div class="container-time">
                                                <div>
                                                <select id="days" name="days" class="form-control duration-select rounded-input-text">
                                                    <option>Dia</option>
                                                </select>
                                                <div class="valid-feedback">
                                                    Ok
                                                </div>
                                                <div class="invalid-feedback">
                                                    Campo obligatorio
                                                </div>
                                            </div>
                                                <div>
                                                    <select id="month" name="month" onclick="creteTime()" class="form-control duration-select rounded-input-text">
                                                    <option>Mes</option>
                                                </select>
                                                <div class="valid-feedback">
                                                    Ok
                                                </div>
                                                <div class="invalid-feedback">
                                                    Campo obligatorio
                                                </div>
                                            </div>
                                                <div>
                                                    <select id="year" name="year" onclick="creteTime()" class="form-control duration-select rounded-input-text">
                                                    <option>Año</option>
                                                </select>
                                                <div class="valid-feedback">
                                                    Ok
                                                </div>
                                                <div class="invalid-feedback">
                                                    Campo obligatorio
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row">
                                            <button type="button" class="btn btn-dark" id="send-promotion" style="margin-left: 35%;" onclick="resgitryPromotions(this.value)">Activar Promocion</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                        <div class="container-fluid separador">
                                        </div>
                                    </div>
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


<!--Modal ImageProfile View-->
<div class="modal fade" id="delete-promotion-verify" tabindex="-1" role="dialog" aria-labelledby="image-profile-viewTitle" aria-hidden="true">
  <div id="modal-dialog" class="modal-dialog" role="document">
    <div id="modal-content" class="modal-content" style="min-heigth:300px;">
      <div id="header" class="modal-header">
        <i class="fas fa-exclamation-circle" style="font-size:7.3rem; color:white;"></i>
      </div>  
         
      <div id="body" class="modal-body">
        <label style="color:white;">¿Desa Eliminar Este Producto?</label>   
      </div>
      <div id="modal-footer" class="modal-footer" style="border-top: none;">
      <button type="button" id="cancel-delete-promotion" value="" onclick="cancelDeletePromotion(this.value)" class="btn btn-light">Cancelar</button>
      <button type="button" id="delete-promotion" value="" onclick="deletePromotion(this.value)" class="btn btn-light">Confirmar</button>
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
                            <h3 style="width: 50%;color: white">Estado: Activos</h3>
                            <small class="text-muted">Un maximo de 3 Activos</small>
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
            <div class="row"><label style="padding: 25px 0px 0px 5px; color: white;">Contraseña</label>
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
            
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCxvGODTgLbBAiG5XQR-M886o1XsIHJmFo&callback=initMap" async defer></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>  
    <script src="js/dashboard.js"></script>
    <script src="js/queryGetDataCompany.js"></script>
    <script src="js/profile-actions.js"></script>
</body>
</html>

