<?php
    header('Content-Type: application/json');
    // contiene el mensaje a mostrar al usuario
    require_once 'Companies.php';
    require_once 'Products.php';
    require_once 'Promotions.php';

    //Inicio Cargar Pagina
    if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['action']) && $_GET['action']=='home' && isset($_COOKIE['key'])){
       echo Companies :: getDataQueryForHome($_GET['visitcompany']);
       exit();
    }

    //Obtienen la imagen de perfil
    if($_SERVER['REQUEST_METHOD']=='GET'  &&  isset($_GET['action']) && $_GET['action']=='imagenProfile' && isset($_COOKIE['key'])){
        echo Companies :: getImageProfile($_GET['visitcompany']);
        exit();
     }


     //Listar solo a un Usuario mediante el id, en este caso se tomaria el indice.
    if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['action']) && $_GET['action']=='profile' && isset($_COOKIE['key'])){
        echo Companies :: getDataQueryForProfile($_GET['visitcompany']);
        exit();
    }



?>