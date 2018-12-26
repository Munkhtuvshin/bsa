<?php 
require_once ROOT . '/model/credit/Negtgel1.php';
require_once ROOT . '/model/credit/Negtgel.php';
require_once ROOT . '/model/credit/Negtgel2.php';
class NegtgelController{
     // route: /credit/choose
    public function index(){
         // Модел классын обьектыг үүсгэнэ
         // Загвар ашиглан өгөгдлөө хэвлэнэ
             // Модел классын обьектыг үүсгэнэ
             $model = new Negtgel1();
             // Модел классыг ашиглан өгөгдөл ачаална
             $data = $model->getAll();
             $model1 = new Negtgel();
             // Модел классыг ашиглан өгөгдөл ачаална
             $data1 = $model1->getAll();
             $model2 = new Negtgel2();
             // Модел классыг ашиглан өгөгдөл ачаална
             $data2 = $model2->getAll();
         
        require ROOT . '/view/credit/negtgel.php';
    }
}

?>