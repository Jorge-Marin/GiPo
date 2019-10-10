<?php 

    require_once __DIR__.'/../../vendor/autoload.php';
    use Google\Cloud\Firestore\FieldValue;
    use Google\Cloud\Firestore\FirestoreClient;
    use Google\Cloud\Firestore\FieldPath;

    class Firestore{
        protected $db;
        protected $name;

        //Instancia a la Base de Datos Y Se instancia a la coleccion principal
        public function __construct(string $collection){
            $this->db = new FirestoreClient([
                'projectId' => 'ideale-is410'
            ]);

            $this->name = $collection;
        }

        //Obtener un documento de la coleccion
        public function getDocument(string $name){
            try{
                if($this->db->collection($this->name)->document($name)->snapshot()->exists()){
                    return $this->db->collection($this->name)->document($name)->snapshot()->data();
                }else{
                    throw new Exception('Document are not Exist');
                }
            }catch(Exception $exception){
                return $exception->getMessage();
            }
        }
        
        
        //Filtra en la Colleccion todos aquellos documentos que cumplen con los tres requisitos
        public function getWhere(string $field, string $operator, $value){
            $query = $this->db->collection($this->name)->where($field, $operator, $value)->documents()->rows();
            $key = '';
            $arr = [];
            if(!empty($query)){
                foreach($query as $item){
                    $key = $item->id();
                    $arr[] = $item->data();
                }
            }

            return [$key, $arr];
        }

        //Filtra en la Colleccion todos aquellos documentos que cumplen con los tres requisitos
        public function getWhereEmail(string $field, string $operator, $value){
            $query = $this->db->collection($this->name)->where($field, $operator, $value)->documents()->rows();
            if(!empty($query)){
                foreach($query as $item){
                    $query = $item->data();
                }
            }

            return sizeOf($query);
        }

    
        public function addNewFieldThisDocument(string $id,array $value){
            try{
                $this->db->collection($this->name)->document($id)->update([$value]);
            }catch(Exception $exception){
                return $exception->getMessage();
            }
        }

        //Filtra en la Colleccion todos aquellos documentos que cumplen con los tres requisitos
        public function getAllDocuments(string $name, string $referenceDocument){
            $query = $this->db->collection($this->name)->document($name)->collection('Products')->document($referenceDocument)
            ->collection('AllProducts')->where('Product', '=', true)->documents()->rows();
            $arr = [];
            if(!empty($query)){
                foreach($query as $item){
                    $arr[] = $item->data();
                }
            }

            return $arr;
        }

        //Filtra en la Colleccion todos aquellos documentos que cumplen con los tres requisitos
        public function getAllOnPromotion(string $name, string $referenceDocument){
            $query = $this->db->collection($this->name)->document($name)->collection('Products')->document($referenceDocument)
            ->collection('AllProducts')->where('inPromotion','=', true)->documents()->rows();
            $arr = [];
            if(!empty($query)){
                foreach($query as $item){
                    $arr[] = $item->data();
                }
            }
            return $arr;
        }

         //Filtra en la Colleccion todos aquellos documentos que cumplen con los tres requisitos
         public function getAllNonePromotion(string $name, string $referenceDocument){
            $query = $this->db->collection($this->name)->document($name)->collection('Products')->document($referenceDocument)
            ->collection('AllProducts')->where('inPromotion','=', false)->documents()->rows();
            $arr = [];
            if(!empty($query)){
                foreach($query as $item){
                    $arr[] = $item->data();
                }
            }
            return $arr;
        }

        

        //Filtra en la Colleccion todos aquellos documentos que cumplen con los tres requisitos
        public function getAllPromotionIndex(){
            $query = $this->db->collection($this->name)->where('Promotion','=', true)->documents()->rows();
            $arr = [];
            if(!empty($query)){
                foreach($query as $item){
                    $arr[] = $item->data();
                }
            }
            return $arr;
        }

        public function getThisDocumentPromotion(string $nameDocument){
            if($this->db->collection($this->name)->document($nameDocument)->snapshot()->exists()){
                return $this->db->collection($this->name)->document($nameDocument)->snapshot()->data();
            }else{
                throw new Exception('Document are not Exist');
            }
        }

    
        
        public function getemailCompany(string $name){
            if($this->db->collection($this->name)->document($name)->snapshot()->exists()){
                $emailcompany = $this->db->collection($this->name)->document($name)->snapshot()->get(new FieldPath(['email']));
                return $emailcompany;
            }else{
                throw new Exception('Document are not Exist');
            }
        }

        

        
        public function getAllaDataLogotype(string $name,string $referenceKeyPictures){
            if($this->db->collection($this->name)->document($name)->snapshot()->exists()){
                $idReferencePictures = $this->getRefenceFolderContainImage($name, $referenceKeyPictures);
                $getPathLogotypeActive = $this->getImageDocument($name,'Pictures',$idReferencePictures);
                return [$idReferencePictures,$getPathLogotypeActive->get(new FieldPath(['Logotype']))] ;
            }else{
                throw new Exception('Document are not Exist');
            }
        }


        public function setNewImagePath(string $name,string $referenceKeyPictures,string $value){
            try{
                $idReferencePictures = $this->getRefenceFolderContainImage($name, $referenceKeyPictures);
                $getPathLogotypeActive = $this->getImageDocument($name,'Pictures',$idReferencePictures);
                $isNewPathImage = $getPathLogotypeActive->get(new FieldPath(['Logotype']));
                $this->db->collection($this->name)->document($name)->collection('Pictures')->document($idReferencePictures)->update([array('path' => 'ActiveLogotype', 'value' => $isNewPathImage[$value])]);
                return [$idReferencePictures,$isNewPathImage[$value]];
            }catch(Exception $exception){
                return $exception->getMessage();
            }
        }

        
        public function setNewBannersPath(string $name,string $referenceKeyPictures,array $pathBanners){
            try{
                $idReferencePictures = $this->getRefenceFolderContainImage($name, $referenceKeyPictures);
                $getPathLogotypeActive = $this->getImageDocument($name,'Pictures',$idReferencePictures);
                $this->db->collection($this->name)->document($name)->collection('Pictures')->document($idReferencePictures)->update([array('path' => 'ActiveBanners', 'value' => $pathBanners)]);
                return [$idReferencePictures,$pathBanners];
            }catch(Exception $exception){
                return $exception->getMessage();
            }
        }

        public function setImagePathUser(string $name,string $ActiveLogotype,array $paths){
            try{
                $this->db->collection($this->name)->document($name)->update([array('path' => 'ActiveLogotype', 'value' => [$ActiveLogotype])],
                [array('path' => 'AllLogotypes', 'value' => [$paths])]);
            }catch(Exception $exception){
                return $exception->getMessage();
            }
        }

        
        public function popElementsBanner(string $name,string $referenceKeyPictures,array $pathBanners){
            $idReferencePictures = $this->getRefenceFolderContainImage($name, $referenceKeyPictures);
            $getPathLogotypeActive = $this->getImageDocument($name,'Pictures',$idReferencePictures);
            $delete = $this->db->collection($this->name)->document($name)->collection('Pictures')->document($idReferencePictures);

            foreach($pathBanners as $value){
                $delete->update([array('path' => 'Banners', 'value' => FieldValue::arrayRemove([$value]))]);
            }

            return TRUE;
        }

        
        //'path' => 'Logotype', 'value' => FieldValue::arrayRemove(['/Logotype/logo2.png'])
        public function popPicturesDb(string $name,string $referenceKeyPictures,array $pathImage){
            $idReferencePictures = $this->getRefenceFolderContainImage($name, $referenceKeyPictures);
            $getPathLogotypeActive = $this->getImageDocument($name,'Pictures',$idReferencePictures);
            $isNewPathImage = $getPathLogotypeActive->get(new FieldPath(['Logotype']));
            $delete = $this->db->collection($this->name)->document($name)->collection('Pictures')->document($idReferencePictures);
            $pathConstant = [];
            for ($i = 0; $i <sizeof($pathImage); $i++) {
                $pathConstant[] = $isNewPathImage[$pathImage[$i]];
            }

            foreach($pathConstant as $value){
                $delete->update([array('path' => 'Logotype', 'value' => FieldValue::arrayRemove([$value]))]);
            }

            return [$idReferencePictures, $pathConstant];
        }

        
        public function getAllBanners(string $name,string $referenceKeyPictures){
            $idReferencePictures = $this->getRefenceFolderContainImage($name, $referenceKeyPictures);
            $getPathLogotypeActive = $this->getImageDocument($name,'Pictures',$idReferencePictures);
            $pathBannerActive = $getPathLogotypeActive->get(new FieldPath(['ActiveBanners']));
            $pathAllBanners = $getPathLogotypeActive->get(new FieldPath(['Banners']));

            for($i=0; $i<sizeof($pathBannerActive); $i++){
                $key = array_search($pathBannerActive[$i], $pathAllBanners);
                array_splice($pathAllBanners, $key, 1);
            }
            
            if(sizeof($pathAllBanners)==0){
                return [$idReferencePictures,$pathBannerActive];
            }else{
                return [$idReferencePictures,$pathBannerActive,$pathAllBanners];
            }
        
        }

        
        public function sendNewImageProfile(string $name, string $referenceDocument,string $field, string $fieldActive, array $pathImage){
            $this->db->collection($this->name)->document($name)->collection('Pictures')->document($referenceDocument)->update([array('path' => $field,
            'value' => FieldValue::arrayUnion($pathImage))]);
            $this->db->collection($this->name)->document($name)->collection('Pictures')->document($referenceDocument)->update([array('path' => $fieldActive,
            'value' => $pathImage)]);
        }

        
        public function getRefenceFolderContainImage(string $name, string $referenceKeyPictures){
            return $this->db->collection($this->name)->document($name)->snapshot()->get(new FieldPath([$referenceKeyPictures]));
        }

        
        public function getImageDocument(string $name,string $nameCollection, string $idReferencePictures){
            return $this->db->collection($this->name)->document($name)->collection($nameCollection)->document($idReferencePictures)->snapshot();
        }

       
        public function createDocument(array $data =[]){
            try{
                $data = $this->db->collection($this->name)->add($data)->id();
                return $data;
            }catch(Exception $exception){
                return $exception->getMessage();
            }
        }

        
        public function createCollection(string $name, string $doc_name, array $data){
            try{
                $this->db->collection($name)->document($doc_name)->create($data);
                return true;
            }catch(Exception $exception){
                return $exception->getMessage();
            }
        }

        public function createCollectionForPicture($name,$dataBanners, $dataLogotype){
            $idDocument = $this->db->collection($this->name)->document($name)->collection('Pictures')->add(['Banners' => $dataBanners,
            'ActiveBanners'=> $dataBanners,'Logotype' =>  $dataLogotype, 'ActiveLogotype'=>  $dataLogotype])->id();
            return  $idDocument;
        }

        
        public function deleteDocument(string $name){
            $this->db->collection($this->name)->document($name)->delete();
        }

        public function deleteCollection(string $name){
            $documents = $this->db->collection($name)->limit(1)->documents();
            while(!$documents->isEmpty()){
                foreach($documents as $item){
                    $item->reference()->delete();
                }
            }
        }

        public function sendingPathPromotion(string $id,string $newFolder, string $pathsImage){
            $data = $this->db->collection('Companies')->document($id)->collection('Products')->document('IYiLx7fyyxbmAWuquHX')
            ->collection('AllProducts')->document($newFolder);

            $data->update([['path'=>'pathPromotion', 'value'=> $pathsImage]]);
            
            return $data;
        }

        public function getArrayPath(string $nameDocument){
            $pathProduct = $this->db->collection($this->name)->document($nameDocument)->snapshot()->get(new FieldPath(['pathProduct']));
            return $pathProduct;
        }

        public function promotionDelete(string $nameDocument){
            $pathProduct = $this->db->collection($this->name)->document($nameDocument)->delete();
            return true;
        }


        public function addPathPictureUser(string $idAcount,string $pathImage, string $pathBanner){
            $data = $this->db->collection($this->name)->document($idAcount)
            ->update([['path'=>'profileActive', 'value'=> $pathImage],
            ['path'=>'bannerActive', 'value'=> $pathBanner],
            ['path'=>'allLogotypes', 'value'=> array(0=>$pathImage)],
            ['path'=>'allBanners', 'value'=> array(0=>$pathBanner)]]);
   
            return true;
        }
   
    }
    
?>


