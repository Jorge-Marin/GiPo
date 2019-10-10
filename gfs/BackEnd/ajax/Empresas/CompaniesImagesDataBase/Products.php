<?php

    header('Content-Type: application/json'); // Tipod MIME
    require_once(__DIR__.'/../FirestoreDb/FirestoreCompanies.php');
    require_once 'Companies.php';

    class Products extends Companies{
        private $titleProduct;
        private $subTitleProduct;
        private $tradeMark;
        private $model;
        private $quantity;
        private $descriptionProduct;
        protected $fs;
        //private $imagesProducts;


        public function __construct(
            $titleProduct,
            $subTitleProduct,
            $tradeMark,
            $model,
            $quantity,
            $descriptionProduct
        ){
            $this->titleProduct = $titleProduct;
            $this->subTitleProduct = $subTitleProduct;
            $this->tradeMark = $tradeMark;
            $this->model = $model;
            $this->quantity = $quantity;
            $this->descriptionProduct = $descriptionProduct;
            //$this->imagesProducts  = $imagesProducts;

            $this->fs = new FirestoreCompanies('Companies');
        }


        public function addProducts(string $id, string $referenceDocument){
            $referenceDocument = $this->fs->getRefenceFolderContainImage($id,'accessProduct');
            return $this->fs->addProductsAtDatabase($id,'Products', $referenceDocument,'AllProducts' ,$this->getData());
        }

        public static function getAllProduct(string $id,string $refereceProduct){
            $fs = new FirestoreCompanies('Companies');
            return $fs->getAllDocuments($id,$refereceProduct);
        }

        public static function deleteProduct(string $id,string $refereceProduct, string $itemDelete){
            $fs = new FirestoreCompanies('Companies');
            $data = $fs->deleteProductDB($id,$refereceProduct,$itemDelete);
            return $data;
        } 

        public function __toString(){
            return json_encode($this->getData());
        }

        public function sendImageProducts(string $id,string $referenceProducts,string $newFolder, array $pathsImage){
            $data = $this->fs->sendImageProducts($id,$referenceProducts,$newFolder, $pathsImage);

            $showProduct['principalImage'] = $data['principalImage'];
            $showProduct['titleProduct'] = $data['titleProduct'];
            $showProduct['subTitleProduct'] = $data['subTitleProduct'];
            $showProduct['tradeMark'] = $data['subTitleProduct'];
            $showProduct['model'] = $data['model'];
            $showProduct['quantity'] = $data['quantity'];
            $showProduct['item'] = $newFolder;
            return $showProduct;
        }

        public static function getDataShowProduct(string $id,string $referenceProducts,string $lastDocument){
            return $this->fs->getDataThreeLevel($id,'Products',$referenceProducts,'AllProducts',$lastDocument);    
        }

        public function getData(){
            $dataProducts['titleProduct'] = $this->titleProduct;
            $dataProducts['subTitleProduct'] = $this->subTitleProduct;
            $dataProducts['tradeMark'] = $this->tradeMark;
            $dataProducts['model'] = $this->model;
            $dataProducts['quantity'] = $this->quantity;
            $dataProducts['descriptionProduct'] = $this->descriptionProduct;
            $dataProducts['Product'] = true;
            $dataProducts['inPromotion'] = false;
            return $dataProducts;
        }
        
    }

?>
