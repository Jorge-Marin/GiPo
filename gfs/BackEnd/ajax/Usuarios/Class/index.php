
<?php

    header('Content-Type: application/json');
    // contiene el mensaje a mostrar al usuario
    
    include_once('User.php');

    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_GET['action']) && $_GET['action']=='newUser'){

        $u = new Usuario(
            $_POST['firstname'],
            $_POST['lastname'],
            $_POST['email'],
            $_POST['password']
        );


        $idAccount = $u->createNewUser();
        if($idAccount!='exist'){
            $pathDestini = 'C:/xampp/htdocs/gfs/BackEnd/ajax/Usuarios/UserDataBaseImg/'.$idAccount;
            mkdir($pathDestini, 0700);
            $pathDestiniBanner = 'C:/xampp/htdocs/gfs/BackEnd/ajax/Usuarios/UserDataBaseImg/'.$idAccount.'/Banners';
            mkdir($pathDestiniBanner, 0700);
            $pathDestiniimgLogotype = 'C:/xampp/htdocs/gfs/BackEnd/ajax/Usuarios/UserDataBaseImg/'.$idAccount.'/imgsProfiles';
            mkdir($pathDestiniimgLogotype, 0700);

            $img = array(
                0=> 'C:/xampp/htdocs/gfs/BackEnd/ajax/Usuarios/UserDataBaseImg/WallpapersDefault/0.jpg',
                1=> 'C:/xampp/htdocs/gfs/BackEnd/ajax/Usuarios/UserDataBaseImg/WallpapersDefault/1.jpg',
                2=> 'C:/xampp/htdocs/gfs/BackEnd/ajax/Usuarios/UserDataBaseImg/WallpapersDefault/2.jpg',
                3=> 'C:/xampp/htdocs/gfs/BackEnd/ajax/Usuarios/UserDataBaseImg/WallpapersDefault/3.jpg',
                4=> 'C:/xampp/htdocs/gfs/BackEnd/ajax/Usuarios/UserDataBaseImg/WallpapersDefault/4.jpg',
                5=> 'C:/xampp/htdocs/gfs/BackEnd/ajax/Usuarios/UserDataBaseImg/WallpapersDefault/5.jpg',
                6=> 'C:/xampp/htdocs/gfs/BackEnd/ajax/Usuarios/UserDataBaseImg/WallpapersDefault/6.jpg',
                7=> 'C:/xampp/htdocs/gfs/BackEnd/ajax/Usuarios/UserDataBaseImg/WallpapersDefault/7.jpg',
                8=> 'C:/xampp/htdocs/gfs/BackEnd/ajax/Usuarios/UserDataBaseImg/WallpapersDefault/9.jpg'
            );

            $wallpaperRandom = $img[$_POST['randWall']];

            $pathBanner = (copia_banner($wallpaperRandom, $pathDestiniBanner, $_POST['randWall'].'.jpg')==true)?'/'.$idAccount.'/Banners'.'/'.$_POST['randWall'].'.jpg':'';
            $pathDefault ='C:/xampp/htdocs/gfs/BackEnd/ajax/Usuarios/UserDataBaseImg/DefaultImage/default.PNG';
            $pathimgProfile = (copia_Profile($pathDefault, $pathDestiniimgLogotype, 'default.PNG')==true)?'/'.$idAccount.'/imgsProfiles'.'/'.'default.PNG':'';
            
            $u->addFieldPictures($idAccount,$pathBanner,$pathimgProfile);

            echo json_encode([$pathBanner,$pathimgProfile]);
        }
        
    }
    

    function copia_banner($ruta_origen,$ruta_destino, $img){
        $create = false;
        if (file_exists($ruta_origen)) {
            chmod($ruta_destino, 0777);//importante dar permisos
            $archivo_destino=$ruta_destino;
            if (copy($ruta_origen,$archivo_destino.'/'.$img)) {
                $create = true;
            } else {
                 echo "Se ha producido un error al intentar copiar el fichero\n";
            }
        }
        return $create;
    }

    function copia_Profile($ruta_origen,$ruta_destino, $img){
        $create = false;
        if (file_exists($ruta_origen)) {
            chmod($ruta_destino, 0777);//importante dar permisos
            $archivo_destino=$ruta_destino;
            if (copy($ruta_origen,$archivo_destino.'/'.$img)) {
                $create = true;
            } else {
                 echo "Se ha producido un error al intentar copiar el fichero\n";
            }
        }
        return $create;
    }

    //Listar solo a un Usuario mediante el id, en este caso se tomaria el indice.
    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_GET['action']) && $_GET['action']=='login'){
        echo Usuario :: login($_POST['email'],$_POST['password']);
     }


    if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['action']) && $_GET['action']=='home' && isset($_COOKIE['key'])){
        Usuario:: getDataForHome($_COOKIE['key']);
    
    }

    if($_SERVER['REQUEST_METHOD']=='PUT' && isset($_GET['action']) && $_GET['action']='updatProfile'){

    }



    
?>