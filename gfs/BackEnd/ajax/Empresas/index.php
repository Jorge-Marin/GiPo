<?php
    header('Content-Type: application/json');
    // contiene el mensaje a mostrar al usuario
    require_once 'Companies.php';

    //Listar solo a un Usuario mediante el id, en este caso se tomaria el indice.
    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_GET['accion']) && $_GET['accion']=='login'){
        echo Companies :: login($_POST['email'],$_POST['password']);
     }

    //Guardar, Segun la Arquitectura REST para guardar el metodo debe ser:
    if($_SERVER['REQUEST_METHOD']=='POST' && !isset($_GET['accion'])){
        $numberPhones = [];
        $numberPhones[] = $_POST['number'];
        for($i=0; $i<3; $i++){
            if (array_key_exists('phone-'.$i, $_POST)) {
                $numberPhones[]= $_POST['phone-'.$i];
            }
        }

        //Instancia y envio de datos a la clase Companies
        $companies = new Companies(
            $_POST['nameCompany'],
            $_POST['email'],
            $_POST['password'],
            $numberPhones,
            $_POST['direction'],
            $_POST['country'],
            $_POST['mision'],
            $_POST['vision'],
            $_POST['socialFacebook'],
            $_POST['socialTwitter'],
            $_POST['socialInstagram'],
            json_decode($_POST['latLng']));

            
        //Este Id Es Necesario Para Crear La Carpeta de las Imagenes
        $id = $companies->createAccounForCompany();
        
        if($id=='exists'){
            echo json_encode('exists');
            return;
        }
        $message='';
        $noFound=false;
        $companies->createCollectionUbication($id);
        $lkave = $companies->addNewCollectionDataThisDocument($id,'Products',['keyProducts'=>[]]);
        $companies->addOneField($id,array('path'=>'accessProducts', 'value'=>$lkave));
        if($_FILES){
        //Necesito un contador para acceder a el tamaño del Arreglo file de banners
        $cont = 0;

        //Variable folder para especificar la carpeta de Banner o Logotipo en la que se guardara
        $folder;
        
        //Array Para almacenar los Path de las Imagenes
        $pathsBanner = array();
        $pathsLogotype = array();

        //Recorriendo cada elemento del arreglo $_FILES
        foreach($_FILES as $file){
            //Se verifica que existe una key para especificar el tipo de imagen
            if(array_key_exists('BannersImage-'.$cont, $_FILES )){
                $folder = "Banners";
                $cont = $cont+1;
            }else if(array_key_exists('LogotypeImage-0', $_FILES )){
                $folder = "Logotype";
            }

            //Escritura de las Imagenes al servidor con move_uploaded_file
            if($file["error"]==UPLOAD_ERR_OK){
                
                if($folder=='Banners'){
                    $pathsBanner[] = '/'.$folder.'/'.$file["name"];
                }else if($folder=="Logotype"){
                    $pathsLogotype[] = '/'.$folder.'/'.$file["name"];
                }
            }else{
                $message.="No se ha recibido ningun archivo\n";
            }
        }

        $keyDocumentPictures = $companies->createCollectionPicture($id,$pathsBanner,$pathsLogotype);
        //$keyProducts = $companies->createCollectionProducts($id);
        //Ruta del Servidor donde se Guardaran las Imagenes
        
        $companies->addOneField($id,array('path' => 'accessPictures', 'value' => $keyDocumentPictures));        
        $pathDestination =  "C:/xampp/htdocs/gfs/BackEnd/ajax/Empresas/CompaniesImageDataBase/".$keyDocumentPictures;

        //Se crean los directorios especificos para el tipo de imagen
        mkdir($pathDestination, 0700);
        mkdir($pathDestination."/Banners", 0700);
        mkdir($pathDestination."/Logotype", 0700);
        mkdir($pathDestination."/Products", 0700);
        
        //Necesito un contador para acceder a el tamaño del Arreglo file de banners
        $cont = 0;
        //Recorriendo cada elemento del arreglo $_FILES
        foreach($_FILES as $key => $file){
            //Se verifica que existe una key para especificar el tipo de imagen
            if('BannersImage-'.$cont == $key){
                $folder = "Banners"; 
                $cont = $cont+1;
                $message.= $folder;
            }else if('LogotypeImage-0'== $key){
                $folder = "Logotype";
                $message.= $folder;
            }
            
            //Escritura de las Imagenes al servidor con move_uploaded_file
            if($file["error"]==UPLOAD_ERR_OK){
                if($folder=='Banners'){
                    move_uploaded_file($file["tmp_name"], $pathDestination.'/'.$folder.'/'.$file["name"]);
                }else if($folder=="Logotype"){
                    move_uploaded_file($file["tmp_name"], $pathDestination.'/'.$folder.'/'.$file["name"]);
                }
               
                $noFound = TRUE;
            }else{
                $message.="No se ha recibido ningun archivo\n";  
            }
        }    
    }

        if($noFound){
            echo json_encode($companies->getNameCompany());
        }else{
            echo json_encode($message);
        }
}

    
     //Listar solo a un Usuario mediante el id, en este caso se tomaria el indice.
    if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['allLogotypeData'])){
        echo Companies :: getAllDataLogotype($_GET['allLogotypeData']);
     }


     //Listar solo a un Usuario mediante el id, en este caso se tomaria el indice.
    if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['changeImage'])){
        echo Companies :: setNewImageProfile($_GET['changeImage'],$_GET['index']);
     }

     //Listar solo a un Usuario mediante el id, en este caso se tomaria el indice.
    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['newLogotype'])){
        $referenceFolder = Companies::getRefenceFolderContainImage($_POST['newLogotype']);

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

        Companies::newImageProfile($_POST['newLogotype'],$referenceFolder,$pathImage);

        echo json_encode([$referenceFolder,$pathImage]);
    }

    if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['deletePictures'])){
        $res = Companies::deleteImageProfiles($_GET['deletePictures'],json_decode($_GET['picturesPathReference'])) ;
        $referenceFolder = 'C:/xampp/htdocs/gfs/BackEnd/ajax/Empresas/CompaniesImageDataBase/'.$res[0];
        $pathImage = $res[1];
        foreach($pathImage as $value){
            $pathFile = $referenceFolder.$value;
            if (file_exists($pathFile)) {
                unlink($pathFile);
            }
        }

        echo json_encode($pathImage);
    }

     //Listar solo a un Usuario mediante el id, en este caso se tomaria el indice.
     if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['getBanners'])){
        echo Companies ::getBannersPublicitary($_GET['getBanners']);
     }
      
     
     //Listar solo a un Usuario mediante el id, en este caso se tomaria el indice.
    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['newBanners'])){ 
        //Array Para almacenar los Path de las Imagenes
        $pathsBanner = array();
        if($_FILES){
    
        //Obtener key de Referencia Folder
        $message ='';

        $keyDocumentPictures = Companies:: getRefenceFolderContainImage($_POST['newBanners']);
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
    
        Companies:: newImageBanners($_POST['newBanners'],$keyDocumentPictures,$pathsBanner);

        echo json_encode([$keyDocumentPictures,$pathsBanner]);
        
        
        }
    }

    //Listar solo a un Usuario mediante el id, en este caso se tomaria el indice.
    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['changeBanner'])){
        $pathArray = json_decode($_POST['nameElements']);
        $pathSend = [];
        foreach($pathArray as $value){
            $pathSend[] = '/Banners'.'/'.$value; 
    }

        echo Companies:: changeBannersImage($_POST['changeBanner'],$pathSend);
     }

    //Listar solo a un Usuario mediante el id, en este caso se tomaria el indice.
    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['delete'])){
        $pathArray = json_decode($_POST['nameElements']);
        $pathSend = [];
        foreach($pathArray as $value){
            $pathSend[] = '/Banners'.'/'.$value; 
        }

        echo Companies:: deleteBannersImage($_POST['delete'],$pathSend);
     }

    //Listar solo a un Usuario mediante el id, en este caso se tomaria el indice.
    if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['delete'])){
       Companies::deleteDocumentCompany($_GET['delete']);
     }

      //Actualizar, Segun la Arquitectura REST para guardar el metodo debe ser POST Y la URL es /usuarios
    if($_SERVER['REQUEST_METHOD']== 'PUT' && isset($_GET['action']) && $_GET['action']=='updateData'){
        $_PUT = array();

        if($_SERVER['REQUEST_METHOD']=='PUT'){
            parse_str(file_get_contents("php://input"), $_PUT);
        }

        $numberPhones = [];
        $numberPhones[] = $_PUT['input-phone-principal'];
        for($i=0; $i<3; $i++){
            if (array_key_exists('phone-'.$i, $_PUT)) {
                $numberPhones[]= $_PUT['phone-'.$i];
            }
        }


        //Instancia y envio de datos a la clase Companies
        $companies = new Companies(
            $_PUT['nameCompany'],
            $_PUT['email'],
           '',
            $numberPhones,
            $_PUT['text-direction'],
            $_PUT['select-country'],
            $_PUT['mision-textarea'],
            $_PUT['vision-textarea'],
            $_PUT['faceboox-textbox'],
            $_PUT['twitter-textbox'],
            $_PUT['instagram-textbox'],
            json_decode($_PUT['latLng']));

           echo $companies->updateDataProfile($_COOKIE['key']);
            
    }



?>