<?php

header('Content-Type: application/json');
    // contiene el mensaje a mostrar al usuario
    require_once 'Companies.php';
    require_once 'Products.php';
    require_once 'Promotions.php';

//Inicio Cargar Pagina
    if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['action']) && $_GET['action']=='home' && isset($_COOKIE['key'])){
       echo Companies :: getDataQueryForHome($_COOKIE['key']);
       exit();
    }

    
    if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['action']) && $_GET['action']=='logout' && isset($_COOKIE['key'])){
        echo Companies :: logout();
        exit();
     }

    if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['action']) && $_GET['action']=='getProducts' && isset($_COOKIE['key'])){
        $referenceProducts = Companies::getRefenceProducts($_COOKIE['key']);
        echo json_encode(array('data'=>Products::getAllProduct($_COOKIE['key'],$referenceProducts),
        'reference'=>  $referenceProducts));
        exit();
    }   


//Obtienen la imagen de perfil
    if($_SERVER['REQUEST_METHOD']=='GET'  &&  isset($_GET['action']) && $_GET['action']=='imagenProfile' && isset($_COOKIE['key'])){
        echo Companies :: getImageProfile($_COOKIE['key']);
        exit();
     }

//  Obtienen todos los logotipos
    if($_SERVER['REQUEST_METHOD']=='GET' &&  isset($_GET['action']) && $_GET['action']=='allLogotypeData' && isset($_COOKIE['key'])){
    echo Companies :: getAllDataLogotype($_COOKIE['key']);
        exit();
    }

//Cambia la Imagen de Perfil
    if($_SERVER['REQUEST_METHOD']=='GET' &&  isset($_GET['action']) && $_GET['action']=='changeImage' && isset($_COOKIE['key'])){
        echo Companies :: setNewImageProfile($_COOKIE['key'],$_GET['index']);
        exit();
     }

//El Usuario Cambia la Imagen de perfil
    if($_SERVER['REQUEST_METHOD']=='POST' &&  isset($_GET['action']) && $_GET['action']=='newLogotype' && isset($_COOKIE['key'])){
        $referenceFolder = Companies::getRefenceFolderContainImage($_COOKIE['key']);

        $pathDestination =  'C:/xampp/htdocs/gfs/BackEnd/ajax/Empresas/CompaniesImageDataBase/'.$referenceFolder;
        $pathImage = '';
        foreach($_FILES as $file){
            //Escritura de las Imagenes al servidor con move_uploaded_file
            if($file["error"]==UPLOAD_ERR_OK){
                    move_uploaded_file($file["tmp_name"], $pathDestination.'/Logotype'.'/'.$file["name"]);
                    $pathImage.= '/Logotype'.'/'.$file["name"];
            }else{
                $message.="No se ha recibido ningun archivo\n";  
            }
        }

        Companies::newImageProfile($_COOKIE['key'],$referenceFolder,$pathImage);

        echo json_encode([$referenceFolder,$pathImage]);
        exit();
    }


//Elimina Logotypos
    if($_SERVER['REQUEST_METHOD']=='GET' &&  isset($_GET['action']) && $_GET['action']=='deletePictures' && isset($_COOKIE['key'])){
        $res = Companies::deleteImageProfiles($_COOKIE['key'],json_decode($_GET['picturesPathReference'])) ;
        $referenceFolder = 'C:/xampp/htdocs/gfs/BackEnd/ajax/Empresas/CompaniesImageDataBase/'.$res[0];
        $pathImage = $res[1];
        foreach($pathImage as $value){
            $pathFile = $referenceFolder.$value;
            if (file_exists($pathFile)) {
                unlink($pathFile);
            }
        }

        echo json_encode($pathImage);
        exit();
    }

//Obtinene todos los getBanners.
     if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['action']) && $_GET['action']=='getBanners' && isset($_COOKIE['key'])){
        echo Companies ::getBannersPublicitary($_COOKIE['key']);
        exit();
     }

     //Listar solo a un Usuario mediante el id, en este caso se tomaria el indice.
    if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['action']) && $_GET['action']=='profile' && isset($_COOKIE['key'])){
        echo Companies :: getDataQueryForProfile($_COOKIE['key']);
        exit();
    }


    //Listar solo a un Usuario mediante el id, en este caso se tomaria el indice.
    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_GET['action']) && $_GET['action']=='changeBanner' && isset($_COOKIE['key'])){
        $pathArray = json_decode($_GET['nameElements']);
        $pathSend = [];
        foreach($pathArray as $value){
            $pathSend[] = '/Banners'.'/'.$value; 
        }

        echo Companies:: changeBannersImage($_COOKIE['key'],$pathSend);
        exit();
     }

      //Listar solo a un Usuario mediante el id, en este caso se tomaria el indice.
    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_GET['action']) && $_GET['action']=='newBanner' && isset($_COOKIE['key'])){ 
        //Array Para almacenar los Path de las Imagenes
        $pathsBanner = array();
        if($_FILES){
    
        //Obtener key de Referencia Folder
        $message ='';

        $keyDocumentPictures = Companies:: getRefenceFolderContainImage($_COOKIE['key']);
        $pathDestination =  "C:/xampp/htdocs/gfs/BackEnd/ajax/Empresas/CompaniesImageDataBase/".$keyDocumentPictures;
        //Recorriendo cada elemento del arreglo $_FILES
        
        foreach($_FILES as $file){
            if($file["error"]==UPLOAD_ERR_OK){
                $pathsBanner[] = '/'.'Banners'.'/'.$file["name"];
                move_uploaded_file($file["tmp_name"], $pathDestination.'/'.'Banners'.'/'.$file["name"]);
            }else{
                $message.="No se ha recibido ningun archivo\n";
            }
        }
    
        Companies:: newImageBanners($_COOKIE['key'],$keyDocumentPictures,$pathsBanner);

        echo json_encode([$keyDocumentPictures,$pathsBanner]);
        
        }
        exit();
    }


     //Listar solo a un Usuario mediante el id, en este caso se tomaria el indice.
    if($_SERVER['REQUEST_METHOD']=='DELETE' && isset($_GET['action']) && $_GET['action']=='delete' && isset($_COOKIE['key'])){
        $pathArray = json_decode($_GET['nameElements']);
        $pathSend = [];
        foreach($pathArray as $value){
            $pathSend[] = '/Banners'.'/'.$value; 
        }

        echo Companies:: deleteBannersImage($_COOKIE['key'],$pathSend);
     }

     if($_SERVER['REQUEST_METHOD']=='POST' && isset($_GET['action']) &&  $_GET['action']=='addProducts' && isset($_COOKIE['key']) ){

        $id =$_COOKIE['key'];

        $referenceImages = Companies::getRefenceFolderContainImage($id);
        $referenceProducts = Companies::getRefenceProducts($id);

            $products = new Products(
                $_POST['title'],
                $_POST['subtitle'],
                $_POST['trademark'],
                $_POST['model'],
                $_POST['quantity'],
                $_POST['description'],
                json_decode($_POST['category'])
            );

        $newFolder = $products->addProducts($id, $referenceProducts);

        $pathDestination =  'C:/xampp/htdocs/gfs/BackEnd/ajax/Empresas/CompaniesImageDataBase/'.$referenceImages.'/Products'.'/'.$newFolder;
        mkdir($pathDestination, 0700);
        mkdir($pathDestination.'/imageProducts', 0700);    
       

        $pathsImage = [];
        foreach($_FILES as $key => $file){
            //Escritura de las Imagenes al servidor con move_uploaded_file
            if($file["error"]==UPLOAD_ERR_OK){
                $pathsImage[] = '/'.$referenceImages.'/Products'.'/'.$newFolder.'/'.'imageProducts'.'/'.$file["name"];
                move_uploaded_file($file["tmp_name"], $pathDestination.'/imageProducts'.'/'.$file["name"]);               
            }else{
                $message.="No se ha recibido ningun archivo\n";  
            }
        }    

        $response = $products->sendImageProducts($id,$referenceProducts,$newFolder,$pathsImage);
        $response['tmp'] =  $referenceProducts;
        $response['folderubi'] =  $referenceImages;

        echo json_encode($response);
        exit();
     }

    if($_SERVER['REQUEST_METHOD']=='DELETE' && isset($_GET['action']) && $_GET['action']=='deleteProduct' && isset($_COOKIE['key'])){
        $referenceProducts = $_GET['referenceProducts'];
        $idItemDelete = $_GET['itemDelete'];
        $pathFolder = $_GET['pathFolder'];

        echo Products::deleteProduct($_COOKIE['key'],$referenceProducts,$idItemDelete);
        $pathDelete='C:/xampp/htdocs/gfs/BackEnd/ajax/Empresas/CompaniesImageDataBase/'.$pathFolder;
        deleteDirectory($pathDelete);
 
        exit();
        
    }

    function deleteDirectory($dir) {
        if(!$dh = @opendir($dir)) return;
        while (false !== ($current = readdir($dh))) {
            if($current != '.' && $current != '..') {
                echo 'Se ha borrado el archivo '.$dir.'/'.$current.'<br/>';
                if (!@unlink($dir.'/'.$current)) 
                    deleteDirectory($dir.'/'.$current);
            }       
        }
        closedir($dh);
        echo 'Se ha borrado el directorio '.$dir.'<br/>';
        rmdir($dir);
    }


    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_GET['action']) && $_GET['action']=='sendPromotion' && isset($_COOKIE['key'])){
        $referenceProducts = Companies::getRefenceProducts($_COOKIE['key']);
        
        $pathProduct = ['Companies', $_COOKIE['key'],'Products',$referenceProducts,'AllPictures',$_GET['itemPromo']];
        $promotions = new Promotions(
            $_POST['promotions-price'],
            $_POST['original-price'],
            $_POST['size-promotion'],
            array(
                'day'=> $_POST['days'],
                'month'=> $_POST['month'],
                'year'=> $_POST['year']),
            $_POST['markers'],
            $pathProduct
        );

        $referencePathPromotion = $promotions->newPromotions();
        Companies:: savePathPromotion($_COOKIE['key'] , $referenceProducts,$_GET['itemPromo'], $referencePathPromotion);

        echo json_encode('envio exitoso');
        exit();
    }

    if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['action']) && $_GET['action']=='getPromotions' && isset($_COOKIE['key'])){ 
        $referenceProducts = Companies::getRefenceProducts($_COOKIE['key']);
        $dataPromotions = Promotions::getAllProductsForPromotions($_COOKIE['key'],$referenceProducts);
        $dataPromotions['referenceFolder'] = $referenceProducts;
        echo json_encode($dataPromotions);
    }

    if($_SERVER['REQUEST_METHOD']=='DELETE' && isset($_GET['action']) && $_GET['action']=='deletePromotion' && isset($_COOKIE['key'])){
        $patPromotion = Promotions::getPathPromotion($_GET['deletePromo']);
        $changeValuePromotion = Companies::desactivePromotion($patPromotion);
        $deletePromotion = Promotions::deleteThisPromotion($_GET['deletePromo']);
        
        echo json_encode($patPromotion);
        exit();
    }

    //Listar solo a un Usuario mediante el id, en este caso se tomaria el indice.
    if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['action']) && $_GET['action']=='all' && isset($_COOKIE['key'])){
        echo Companies::getDocumentCompanies($_COOKIE['key']);
    }


    //Listar solo a un Usuario mediante el id, en este caso se tomaria el indice.
    if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['action']) && $_GET['action']=='homeidex'){
        $data = Promotions::getAllPromotion();
        $duplaPath = [];

        for($i=0; $i<sizeof($data);$i++){
            $duplaPath[] = [$data[$i],Companies::getDataProduct($data[$i]['pathProduct'])];
        }

        echo json_encode($duplaPath); 
    }

    //Listar solo a un Usuario mediante el id, en este caso se tomaria el indice.
    if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['action']) && $_GET['action']=='getProducforClient'){
        $data = Promotions::getthisPromotion($_GET['promotionCode']);
        $duplaPath = [$data, Companies::getDataProduct($data['pathProduct'])];
        echo json_encode($duplaPath);
    }


   
?>