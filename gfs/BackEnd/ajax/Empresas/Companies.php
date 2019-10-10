<?php
    require_once (__DIR__.'/../FirestoreDb/FirestoreCompanies.php');

    class Companies extends FirestoreCompanies{
        protected $fs;
        private $nameCompany;
        private $email;
        private $password;
        private $number;
        private $direction;
        private $country;
        private $mision;
        private $vision;
        private $socialFacebook;
        private $socialTwitter;
        private $socialInstagram;
        private $makersUbications;
        
        //Nombre de la Collecion Hacia las compañias
        const collectionForCom = 'Companies';

        //Definicion del Constructor,   Necesita Retoques
        public function __construct(
            $nameCompany,
            $email,
            $password,
            $number,
            $direction,
            $country,
            $mision,
            $vision,
            $socialFacebook,
            $socialTwitter,
            $socialInstagram,
            $makersUbications
        ){
            $this -> nameCompany = $nameCompany;
            $this -> email = $email;
            $this -> password = $password;
            $this -> number = $number;
            $this -> direction = $direction;
            $this -> country = $country;
            $this -> mision = $mision;
            $this -> vision = $vision;
            $this -> socialFacebook = $socialFacebook;
            $this -> socialTwitter = $socialTwitter;
            $this -> socialInstagram = $socialInstagram;
            $this-> makersUbications = $makersUbications;

            $this->fs = new FirestoreCompanies('Companies');
        }

        
        public function createAccounForCompany(){
            if($this->getReferenceId()>0){
                return 'exists';
            }else{
                $id = $this->fs->createDocument($this->getData());
                return $id;
            } 
        }
        
        public function createCollectionPicture(string $idDocument,array $dataBanners,array $dataLogotype){
            $data =$this->fs->createCollectionForPicture($idDocument,$dataBanners, $dataLogotype);
            return $data;
        }

        /*public function createCollectionProducts($idDocument,array $emptyArray){
            $this->fs->createCollectionForPicture($idDocument,$dataBanners, $dataLogotype);
        }*/

        
        public function createCollectionUbication($idDocument){
            json_encode($this->fs->createMarkersUbication($idDocument,$this->makersUbications));
        }
        
        public static function logout(){
            setcookie('key',"",time()-3600,'/');
            setcookie('token',"",time()-3600,'/');
            return true;
        }

        //Obtener
        public function getReferenceId(){
            return $this->fs->getWhereEmail('email','=',$this->email);
        }


        public function addOneField(string $id,array $value){
            $this->fs->addNewFieldThisDocument($id, $value);
        }
        
        public static function getDataQueryForHome($id){
            $fs = new FirestoreCompanies('Companies');
            $res = $fs->homePageData($id,'accessPictures',
            array(
                0 => ['nameCompany'],
                1 => ['Pictures','ActiveBanners'],
                2 => ['Pictures','ActiveLogotype']
            ));
            return json_encode($res);
        }

        
        public static function getDocumentCompanies(string $id){
            $fs = new FirestoreCompanies('Companies'); 
            $data = $fs->getDocument($id);
            unset($data['password']);
            return json_encode($data);
        }

        
        public static function getDataQueryForProfile(string $id){
            $fs = new FirestoreCompanies('Companies');
            $referenceFolderPictures = $fs->getRefenceFolderContainImage($id,'accessPictures');
            $res = $fs->getDataProfile($id, 
            array(
                0 => ['nameCompany'],
                1 => ['email'],
                2 => ['mision'],
                3 => ['vision'],
                4 => ['number'],
                5 => ['direction']
            ));

            $res['Logotype'] = $fs->getProfileImage($id,$referenceFolderPictures);
            $res['MakersMap'] = $fs->getMakersUbication($id);
            return json_encode($res);
        }
        
        public function updateDataProfile(string $id){
            $this->password = $this->fs->getPasswordDocument($id);
            $this->fs->uptadeDataProfile($id, $this->getData(), $this->makersUbications);
            return true;
        }

        
        public static function getImageProfile($id){
            $fs = new FirestoreCompanies('Companies');
            return json_encode($fs->getProfileImage($id,'accessPictures'));
        }

        public static function getAllDataLogotype($id){
            $fs = new FirestoreCompanies('Companies');
            return json_encode($fs->getAllaDataLogotype($id,'accessPictures'));
        }

        
        public static function setNewImageProfile(string $id,string $index){
            $fs = new FirestoreCompanies('Companies');
            return json_encode($fs->setNewImagePath($id,'accessPictures',$index));
        }

        public function addNewCollectionDataThisDocument(string $id,string $nameCollection, array $value){
            $this->fs->addNewCollectionDataThisDocument($id,$nameCollection,$value);
        }

        
        public function getRefenceFolderContainImage(string $name,string $access = 'accessPictures'){
            $fs = new FirestoreCompanies('Companies');
            return $fs->getRefenceFolderContainImage($name,$access);
        }

        public static function getRefenceProducts(string $name){
            $fs = new FirestoreCompanies('Companies');
            return $fs->getRefenceFolderContainImage($name,'accessProduct');
        }

        
        public static function deleteImageProfiles(string $id,array $pathImage){
            $fs = new FirestoreCompanies('Companies');
            return $fs->popPicturesDb($id,'accessPictures',$pathImage);
        }
        
        
        public function newImageProfile(string $name, string $referenceFolder, string $pathImage){
            $fs = new FirestoreCompanies('Companies');
            $fs->sendNewImageProfile($name,$referenceFolder,'Logotype','ActiveLogotype',array($pathImage));
        }

        
        public  static  function getBannersPublicitary(string $name){
            $fs = new FirestoreCompanies('Companies');
            return json_encode($fs->getAllBanners($name,'accessPictures'));
        }

        
        public function newImageBanners(string $name, string $referenceFolder, array $pathImage){
            $fs = new FirestoreCompanies('Companies');
            $fs->sendNewImageProfile($name,$referenceFolder,'Banners','ActiveBanners',$pathImage);
        }

        
        public static function changeBannersImage(string $id,array $pathSend){
            $fs = new FirestoreCompanies('Companies');
            return json_encode($fs->setNewBannersPath($id,'accessPictures',$pathSend));
        }

        
        public static function deleteBannersImage(string $id,array $pathSend){
            $fs = new FirestoreCompanies('Companies');
            return $fs->popElementsBanner($id,'accessPictures',$pathSend);
        }

        
        public static function deleteDocumentCompany(string $name){
            $fs = new FirestoreCompanies('Companies');
            $fs->deleteDocument($name);
        }

        public static function desactivePromotion(array $pathDesactive){
            $fs = new FirestoreCompanies('Companies');
            $fs->outPromotion($pathDesactive);
        }

        public static function login(string $user, string $password){
            $fs = new FirestoreCompanies('Companies');
            $data = $fs->getWhere('email', '=', $user);

            $key = $data[0];
            $passwordDB = $data[1];
            $passwordDB = $passwordDB[0]['password'];
            $autenticate = password_verify($password, $passwordDB);
            $respuesta['valido'] = $autenticate==1?true:false;
            if($respuesta['valido']){
                $respuesta['key'] = $key;
                $respuesta['token'] = bin2hex(openssl_random_pseudo_bytes(16));
                setcookie('key', $respuesta['key'], time() + (86400 * 30), "/");
                setcookie('token', $respuesta['token'], time() + (86400 * 30), "/");
                $fs->addNewFieldThisDocument($key,array('path'=>'token','value'=>$respuesta['token']));
            }
            return '{"Valido":"'.$respuesta['valido'].'"}';
        }

        public static  function savePathPromotion( string $name, string $referenceProducts,string $itemPromo, string $pathPromotions){
            $fs = new FirestoreCompanies('Companies');
            $fs->sendPathPromotion($name, $referenceProducts, $itemPromo, $pathPromotions);
        }

        public static function getDataProduct(array $arrayPath){
            $fs = new FirestoreCompanies('Companies');
            $dataCompany = $fs->getemailCompany($arrayPath[1]);
            return [$fs->giveMeDataProduct($arrayPath), $dataCompany];
        }


        public static function verificarAutenticacion(){
            if(!isset($_COOKIE['key']))
                return false;

            $fs = new FirestoreCompanies('Companies');
            $data = $fs->getDocument($_COOKIE['key']);

            $token = $data['token'];
            if($token == $_COOKIE['token']){
                return true;
            }else{
                return FALSE;
            }
        }


        public function __toString(){
            return json_encode($this->getData());
        }

        public function getData(){
            $dataCompany['nameCompany'] = $this ->nameCompany;
            $dataCompany['email'] = $this ->email;
            $dataCompany['password'] = password_hash($this ->password, PASSWORD_DEFAULT);
            $dataCompany['number'] = $this ->number;
            $dataCompany['direction'] = $this ->direction;
            $dataCompany['country'] = $this ->country;
            $dataCompany['mision'] = $this ->mision;
            $dataCompany['vision'] = $this ->vision;
            $dataCompany['socialFacebook'] = $this ->socialFacebook;
            $dataCompany['socialTwitter'] = $this ->socialTwitter;
            $dataCompany['socialInstagram'] = $this ->socialInstagram;
            return $dataCompany;
        }

        public function getNameCompany(){
            return json_encode($this->nameCompany);
        }

}


?>

    
