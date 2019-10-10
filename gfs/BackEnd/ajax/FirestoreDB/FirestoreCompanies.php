<?php

    require_once __DIR__.'/../../vendor/autoload.php';
    use Google\Cloud\Firestore\FieldValue;
    use Google\Cloud\Firestore\FirestoreClient;
    use Google\Cloud\Firestore\FieldPath;

    require_once('Firestore.php');

    class FirestoreCompanies extends Firestore{
        protected $Firestore;
        protected $db;
        protected $name;

        public function __construct(
            $collection
        ){
            parent::__construct(
                $collection
            );
        }

        public function uptadeDataProfile(string $name, array $fieldsUpdate, array $makersUbications){
            try{
                if($this->db->collection($this->name)->document($name)->snapshot()->exists()){
                    $this->db->collection($this->name)->document($name)->update([
                        ['path'=> 'nameCompany' , 'value'=> $fieldsUpdate['nameCompany']],
                        ['path'=> 'email' , 'value'=> $fieldsUpdate['email']],
                        ['path'=> 'password' , 'value'=> $fieldsUpdate['password']],
                        ['path'=> 'number' , 'value'=> $fieldsUpdate['number']],
                        ['path'=> 'direction' , 'value'=> $fieldsUpdate['direction']],
                        ['path'=> 'country' , 'value'=> $fieldsUpdate['country']],
                        ['path'=> 'mision' , 'value'=> $fieldsUpdate['mision']],
                        ['path'=> 'vision' , 'value'=> $fieldsUpdate['vision']],
                        ['path'=> 'socialFacebook' , 'value'=> $fieldsUpdate['socialFacebook']],
                        ['path'=> 'socialTwitter' , 'value'=> $fieldsUpdate['socialTwitter']],
                        ['path'=>  'socialInstagram'  , 'value'=> $fieldsUpdate['socialInstagram']]
                    ]);

                    $this->db->collection($this->name)->document($name)->collection('GoogleMapsMakers')->document('Makers')
                    ->set(['latLngMakersArray' => $makersUbications]);
                }else{
                    throw new Exception('Document are not Exist');
                }
            }catch(Exception $exception){
                return $exception->getMessage();
            }
            
        }
        
        public function homePageData(string $name,string $getIdPicturesReference, array $pathArrays ){
            try{
                if($this->db->collection($this->name)->document($name)->snapshot()->exists()){
                    $dataRequires = [];
                    $idReferencePictures = $this->db->collection($this->name)->document($name)->snapshot()->get(new FieldPath([$getIdPicturesReference]));
                    $dataRequires['referenceFolder'] = $idReferencePictures;
                    for($i=0; $i<sizeof($pathArrays);$i++){
                        if(sizeof($pathArrays[$i])==1){
                            $referenceDocument = $this->db->collection($this->name)->document($name)->snapshot();
                            $dataRequires['nameCompany'] = $referenceDocument->get(new FieldPath($pathArrays[$i]));
                        }else if(sizeof($pathArrays[$i])==2){
                            $referenceDocument = $this->db->collection($this->name)->document($name)->collection($pathArrays[$i][0])->document($dataRequires['referenceFolder'])->snapshot();
                            $dataRequires[$pathArrays[$i][1]] = $referenceDocument->get(new FieldPath([$pathArrays[$i][1]]));
                        }
                    }
                    return $dataRequires;
                }else{
                    throw new Exception('Document are not Exist');
                }
            }catch(Exception $exception){
                return $exception->getMessage();
            }
        }

        public function getDataProfile(string $name,array $getFields){
            try{
                if($this->db->collection($this->name)->document($name)->snapshot()->exists()){
                    $information = [];
                    $idDocument = $this->db->collection($this->name)->document($name)->snapshot();
                    foreach($getFields as $value){
                        $information[$value[0]] = $idDocument->get(new FieldPath($value));
                    }
                    return $information;
                }
            }catch(Exception $exception){
                return $exception->getMessage();
            }
        }

        public function addProductsAtDatabase(string $id, string $collection, string $referenceDocument, string $nameCollection, array $value){
            try{
                $data = $this->db->collection($this->name)->document($id)->collection($collection)->document($referenceDocument)
                ->collection($nameCollection)->add($value)->id();
                return $data;
            }catch(Exception $exception){
                return $exception->getMessage();
            }
        }

        public function sendImageProducts(string $id,string $referenceProducts,string $newFolder, array $pathsImage){
            $data = $this->db->collection($this->name)->document($id)->collection('Products')->document($referenceProducts)
            ->collection('AllProducts')->document($newFolder);

            $data->update([['path'=>'principalImage', 'value'=> $pathsImage[0]],
            ['path'=>'allImages', 'value'=> $pathsImage]]);

            $data = $this->db->collection($this->name)->document($id)->collection('Products')->document($referenceProducts)
            ->collection('AllProducts')->document($newFolder)->snapshot()->data();
            
            return $data;
        }

        public function deleteProductDB(string $id, string $referenceProducts, string $itemDelete){
            try{
                $this->db->collection($this->name)->document($id)->collection('Products')->document($referenceProducts)
                ->collection('AllProducts')->document($itemDelete)->delete();;
                return true;
            }catch(Exception $exception){
                return $exception->getMessage();
            }
        }

        public function getPasswordDocument(string $name){
            if($this->db->collection($this->name)->document($name)->snapshot()->exists()){
                $password = $this->db->collection($this->name)->document($name)->snapshot()
                ->get(new FieldPath(['password'])) ;
                return $password;
            }else{
                throw new Exception('Document are not Exist');
            }
        }
        
        public function getMakersUbication(string $name){
            if($this->db->collection($this->name)->document($name)->snapshot()->exists()){
                $DocumentMakers = $this->db->collection($this->name)->document($name)->collection('GoogleMapsMakers')
                ->document('Makers')->snapshot()->get(new FieldPath(['latLngMakersArray'])) ;
                return $DocumentMakers;
            }else{
                throw new Exception('Document are not Exist');
            }
        }

        public function sendPathPromotion(string $name,string $referenceProducts,string $itemPromo, string $pathPromotions){
            if($this->db->collection($this->name)->document($name)->snapshot()->exists()){
                $this->db->collection($this->name)->document($name)->collection('Products')
                ->document($referenceProducts)->collection('AllProducts')->document($itemPromo)->update([['path'=> 'idPromotion', 'value'=> $pathPromotions],
                ['path'=>'inPromotion', 'value'=>true]]);
            }else{
                throw new Exception('Document are not Exist');
            }
        }
        
        public function giveMeDataProduct(array $pathProduct){
            if($this->db->collection($this->name)->document($pathProduct[1])->snapshot()->exists()){
                $dataProduct = $this->db->collection($this->name)->document($pathProduct[1])->collection('Products')
                ->document($pathProduct[3])->collection('AllProducts')->document($pathProduct[5])->snapshot()->data();

                return $dataProduct;
            }else{
                throw new Exception('Document are not Exist');
            }
        }

        public function outPromotion(array $pathPromotion){
            echo json_encode($pathPromotion[5]);
            if($this->db->collection($pathPromotion[0])->document($pathPromotion[1])->snapshot()->exists()){
                $refereceDocumentProduct = $this->db->collection($pathPromotion[0])->document($pathPromotion[1])->collection($pathPromotion[2])
                ->document($pathPromotion[3])->collection('AllProducts')->document($pathPromotion[5]);
                
                $refereceDocumentProduct->update([
                    [
                        'path' => 'idPromotion',
                        'value' => FieldValue::deleteField()
                    ]
                ]);

                $refereceDocumentProduct->update([
                    [
                        'path' => 'inPromotion',
                        'value' => false
                    ]
                ]);
            }else{
                throw new Exception('Document are not Exist');
            }
        }  

        public function createMarkersUbication($name,$dataMakersUbications){
            $this->db->collection($this->name)->document($name)->collection('GoogleMapsMakers')->document('Makers')->create(['latLngMakersArray' => $dataMakersUbications]);
        }

        public function addNewCollectionDataThisDocument(string $id,string $nameCollection, array $value){
            try{
                $data = $this->db->collection($this->name)->document($id)->collection($nameCollection)->add($value)->id();
                return $data;
            }catch(Exception $exception){
                return $exception->getMessage();
            }
        }


        public function getDataThreeLevel(string $id,string $firstCollection,string $referenceSecondDocument, string $secondCollection, string $lastDocument){
            try{
                $data = $this->db->collection($this->name)->document($id)->collection($firstCollection)->document($referenceSecondDocument)
                ->collection($secondCollection)->document($lastDocument)->data();
                return $data;
            }catch(Exception $exception){
                return $exception->getMessage();
            }
        }

        public function getProfileImage($id,$referenceFolderPictures){
            $path = $this->db->collection($this->name)->document($id)->collection('Pictures')->document($referenceFolderPictures)->snapshot()->get(new FieldPath(['ActiveLogotype'])); 
            return '/'.$referenceFolderPictures.'/'.$path;        
        }
    }

?>