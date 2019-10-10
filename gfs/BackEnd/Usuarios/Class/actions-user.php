<?php
    header('Content-Type: application/json');

    require_once 'User.php';

    //Obtienen la imagen de perfil
    if($_SERVER['REQUEST_METHOD']=='GET'  &&  isset($_GET['action']) && $_GET['action']=='home' && isset($_COOKIE['key'])){
        $data = Usuario :: getMyData($_COOKIE['key']);
        echo json_encode($data);
        exit();
     }
?>