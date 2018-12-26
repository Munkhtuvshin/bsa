<?php 
// Модел классаа оруулж ирнэ
require_once ROOT . '/model/credit/Detail.php';
require_once ROOT . '/model/credit/ClassType.php';
require_once ROOT . '/model/credit/detail2.php';
require_once ROOT . '/model/credit/helber1.php';
require_once ROOT . '/model/credit/helber2.php';
require_once ROOT . '/model/credit/helber3.php';
require_once ROOT . '/model/credit/helber4.php';
require_once ROOT . '/model/credit/helber5.php';
class DetailController{
     // route: /credit/choose
    public function index(){
         // Модел классын обьектыг үүсгэнэ
         $model = new Detail();
         // Модел классыг ашиглан өгөгдөл ачаална
         $data = $model->getAll();
         $model1 = new ClassType();
         $data1 = $model1->getAll();
         $model2 = new Detail2();
         $data2 = $model2->getAll();
         $model3 = new helber1();
         $data3 = $model3->getAll();
         $model4 = new helber2();
         $data4 = $model4->getAll();
         $model5 = new helber3();
         $data5 = $model5->getAll();
         $model6 = new helber4();
         $data6 = $model6->getAll();
         $model7 = new helber5();
         $data7 = $model7->getAll();
         // Загвар ашиглан өгөгдлөө хэвлэнэ
        require ROOT . '/view/credit/Detail.php';
    }
}