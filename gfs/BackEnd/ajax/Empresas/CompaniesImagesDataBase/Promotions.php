<?php
    header('Content-Type: application/json'); // Tipod MIME
    require_once(__DIR__.'/../FirestoreDb/FirestoreCompanies.php');
    require_once(__DIR__.'/../FirestoreDb/FirestorePromotions.php');
    require_once ('Products.php');


    class Promotions extends Products{
        private $promotionsPrice;
        private $originalPrice;
        private $sizepPromotion;
        private $expired;


        public function __construct(
            $promotionsPrice,
            $originalPrice,
            $sizepPromotion,
            $expired,
            $mapMarkers,
            $pathProduct
        ){
            $this->promotionsPrice = $promotionsPrice;
            $this->originalPrice = $originalPrice;
            $this->sizepPromotion = $sizepPromotion;
            $this->expired = $expired;
            $this->mapMarkers = $mapMarkers; 
            $this->pathProduct = $pathProduct;

            $this->fs = new FirestorePromotions('Promotions');
        }

        public static function getAllProductsForPromotions(string $name, string $referenceProduct){
           $fs = new FirestorePromotions('Companies');
           $promotionActive = $fs->getAllOnPromotion($name,$referenceProduct);
           $promotionDesactive = $fs->getAllNonePromotion($name,$referenceProduct);

           $fsp = new FirestorePromotions('Promotions');
           
           for($i=0; $i<sizeof($promotionActive); $i++){
            $dataPromotion = $fsp -> getThisDocumentPromotion($promotionActive[$i]['idPromotion']);
            $promotionActive[$i]['informationPromotion'] = $dataPromotion;
           }

           return array('Active'=>$promotionActive, 'NoActive'=> $promotionDesactive);
        }

        public function newPromotions(){
           $pathPromotion = $this->fs->newPromotion($this->getData());
           return $pathPromotion;
        }


        public static function getPathPromotion(string $nameDocument){
            return FirestorePromotions::promotionGetPath($nameDocument);
        }

        
        public static function deleteThisPromotion(string $nameDocument){
            return FirestorePromotions::deletePromotionAndGetPath($nameDocument);
        }

        public static function getAllPromotion(){
            $promo = new FirestorePromotions('Promotions');
            return $promo->getPromotions();
        }

        public static function getthisPromotion(string $nameDocument){
            $fsp = new FirestorePromotions('Promotions');
            return $fsp -> getDocument($nameDocument);

        }


        public function __toString(){
            return json_encode($this->getData());
        }

        public function getData(){
            $dataPromotion['promotionPrice'] = $this->promotionsPrice;
            $dataPromotion['originalPrice'] = $this->originalPrice;
            $dataPromotion['sizePromotion'] = $this->sizepPromotion;
            $dataPromotion['expired'] = $this->expired;
            $dataPromotion['mapMarkers'] = $this->mapMarkers;
            $dataPromotion['pathProduct'] = $this->pathProduct;
            $dataPromotion['Promotion'] = true; 
            return $dataPromotion;
        }
    }
?>

