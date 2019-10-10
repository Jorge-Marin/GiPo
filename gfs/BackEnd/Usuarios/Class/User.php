<?php 
    require_once (__DIR__.'/../../FirestoreDb/Firestore.php');

    //Inicializa la Colleccion Usuarios Desde El Constructos
    

    // This assumes that you have placed the Firebase credentials in the same directory
    // as this PHP file.

    class Usuario{
        protected $fs;
        private $firstname;
        private $lastname;
        private $email;
        private $password;
    
        public function __construct(
            $firstName,
            $lastName,
            $email,
            $password
        ){
            $this->firstname = $firstName;
            $this->lastname = $lastName;
            $this->email = $email;
            $this->password = $password;
            $this->fs = new Firestore('Users');
        }

        public function __toString(){
            return json_encode($this->getData());
        }

        public function createNewUser(){
            if($this->getReferenceId()>0){
                return 'exists';
            }else{
               return $this->fs->createDocument($this->getData());;
            }
        }

        public function addFieldPictures(string $idAccount,string $imageProfile, string $Banner){
            $this->fs->addPathPictureUser($idAccount,$imageProfile,$Banner);
        }


        public function addImageLogotype(string $idAccount, string $ActiveLogotype, array $AllLogotypes){
            $this->fs->setImagePathUser($idAccount, $ActiveLogotype,  $AllLogotypes);
        }

        public function getReferenceId(){
            return $this->fs->getWhereEmail('email','=',$this->email);
        }

        public function getData(){
            $documentData['firstname'] = $this->firstname;
            $documentData['lastname'] = $this->lastname;
            $documentData['email'] = $this->email;
            $documentData['password'] = password_hash($this->password, PASSWORD_DEFAULT);
            return $documentData;            
        }


        public static function login(string $email, string $password){
            $fsU = new Firestore('Users');
            $data = $fsU->getWhere('email','=',$email);

            $key = $data[0];
            $passwordDB = $data[1];
            $passwordDB = $passwordDB[0]['password'];
            $autenticate = password_verify($password, $passwordDB);
            $response['valid']= $autenticate==1?true:false;
            if($response['valid']){
                $response['key'] = $key;
                $response['token'] = bin2hex(openssl_random_pseudo_bytes(16));
                setcookie('key', $response['key'], time()+(86400 * 30),'/');
                setcookie('token',$response['token'], time()+(86400 * 30), '/');
                $fsU->addNewFieldThisDocument($key, array('path'=>'token', 'value'=>$response['token']));
            }
            return '{"Valido":"'.$response['valid'].'"}';
        }


        public static function verificarAutenticacion(){
            if(!isset($_COOKIE['key']))
                return false;

            $fs = new Firestore('Users');
            $data = $fs->getDocument($_COOKIE['key']);


            $token = $data['token'];
            if($token == $_COOKIE['token']){
                return true;
            }else{
                return FALSE;
            }
        }

        public static function getMyData(string $nameDocument){
            $fs = new Firestore('Users');
            $data = $fs->getDocument($nameDocument);
            return $data;
        }


        public static function getImageProfile($id){
            $fs = new FirestoreCompanies('Companies');
            return json_encode($fs->getProfileImage($id,'accessPictures'));
        }

    }

?>
