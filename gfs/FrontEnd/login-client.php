<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login Ideale</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/login.css">
  <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
  
</head>
<body>
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
        <img src="icons/Logotype-Black.svg" width="80px;" style="padding-top: 5.6px;">
      <h5 class="my-0 mr-md-auto font-weight-normal" style="font-size: 2rem">GiPo</h5>
      <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="GiPoHome.html">GiPo</a>
        <a class="p-2 text-dark" href="http://localhost/gfs/FrontEnd/perfil-compa%c3%b1ia.php">Mi Cuenta</a>
        <a class="p-2 text-dark" href="#">Curosear Empresas</a>
      </nav>
      <div class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Crear una Cuenta</a>
          <div class="dropdown-menu" aria-labelledby="dropdown01">
            <a class="dropdown-item" href="client-resgistry.html">Cliente</a>
            <a class="dropdown-item" href="company-registry.html">Empresas</a>
          </div>
        </div>
      <div class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Iniciar Sesion</a>
          <div class="dropdown-menu" aria-labelledby="dropdown01">
            <a class="dropdown-item" href="login-client.php">Cliente</a>
            <a class="dropdown-item" href="login-company.php">Empresa</a>
          </div>
        </div>
    </div>
  <div class="container">
    <div class="row login-div">
      <div class="col-xl-12">
        <img src="icons/Logotype-Black.svg" class="logotype-login" width="100px;" height="100px;" alt=""><br>
        <div class="col-xl-12" style="text-align: center;">
          <label class="title-begin">Iniciar Secion</label>
        </div>
        <form id="form-login">
          <label style="padding-left: 8px;">Email</label>
          <input type="text" id="email" name="email" placeholder="Email" class="email"><br>
          <label style="padding-left: 8px;">Password</label>
          <input type="password" name="password" id="password" placeholder="Password" class="password-text"><br>
          <button type="button" id="btn-login-client" class="btn-logotype">Login</button><br>
        </form>
        <div class="checkbox">
          <input type="checkbox" class="input-assumpte" id="input-confidencial">
          <label for="input-confidencial"></label><label style="font-size: 14px;">&nbsp Remember me</label>
        </div>
        <div>
          <a href="#" stylze="widows: 50%; float: right; font-weight: bold; text-decoration: none;">Need help?</a>
        </div>
        <div class="sign-up">
            <label style="float: right;">¿Primera vez en Ideale?
            <a href="#" style="text-decoration: none;">&nbsp Suscríbete ya.</a>
          </label>
        </div>
      </div>
    </div>
  </div> 
  <div class="container-fluid">
  </div>
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src='js/login-client.js'></script>
</body>
</html>






