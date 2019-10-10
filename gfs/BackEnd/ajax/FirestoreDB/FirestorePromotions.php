<?php

    require_once __DIR__.'/../../vendor/autoload.php';
    use Google\Cloud\Firestore\FieldValue;
    use Google\Cloud\Firestore\FirestoreClient;
    use Google\Cloud\Firestore\FieldPath;

    require_once('Firestore.php');

    class FirestorePromotions extends Firestore{
        protected $Firestore;
        protected $db;
        protected $name;  


        public function __construct(
            $collection
        ){
            parent::__construct(
                $collection
            );

            $this->db = new FirestoreClient([
                'projectId' => 'ideale-is410'
            ]);

            $this->name = $collection;
        }


        public function newPromotion(array $dataPromotion){
            return $this->createDocument($dataPromotion);
        }


        public static function sendPathPromotions(string $id,string $newFolder, string $pathsImage){
            $fs = new Firestore('Companies');
            $fs->sendingPathPromotion($id,$newFolder, $pathsImage);
        }

        public static function promotionGetPath(string $nameDocument){
            $fsP = new Firestore('Promotions');
            $pathProduct = $fsP->getArrayPath($nameDocument);
            return $pathProduct;
        }


        public static function deletePromotionAndGetPath(string $nameDocument){
            $fsP = new Firestore('Promotions');
            return $fsP->promotionDelete($nameDocument);
        }


        public static function getPromotions(){
            $fsP = new Firestore('Promotions');
            return $fsP->getAllPromotionIndex();
        }
    }

?>




