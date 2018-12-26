<?php 
// Модел классаа оруулж ирнэ
require_once ROOT . '/model/credit/Calcu.php';
require_once ROOT . '/model/credit/Calcu1.php';
require_once ROOT . '/model/credit/Calcu2.php';
require_once ROOT . '/model/credit/Calcu3.php';
require_once ROOT . '/model/credit/Calcu4.php';
require_once ROOT . '/model/credit/Calcu5.php';
require_once ROOT . '/model/credit/Calcu6.php';
require_once ROOT . '/model/credit/Kredit.php';
require_once ROOT . '/model/credit/Cop.php';
require_once ROOT . '/model/credit/KreditLab.php';
require_once ROOT . '/model/credit/Season.php';
class CalcuController{
     // route: /credit/choose
    public function index(){
         // Модел классын обьектыг үүсгэнэ
         $model = new Calcu();
         // Модел классыг ашиглан өгөгдөл ачаална
         $data = $model->getAll();
         $model1 = new Calcu1();
         $data1 = $model1->getAll();
         $model2 = new Calcu2();
         $data2 = $model2->getAll();
         $model3 = new Calcu3();
         $data3 = $model3->getAll();
         $model4 = new Calcu4();
         $data4 = $model4->getAll();
         $model5 = new Calcu5();
         $data5 = $model5->getAll();
         $model6 = new Calcu6();
         $data6 = $model6->getAll();
         $model7 = new Kredit();
         $data7 = $model7->getAll();
         $model8 = new Cop();
         $data8 = $model8->getAll();
         $model9 = new KreditLab();
         $data9 = $model9->getAll();
         $model10 = new Season();
         $data10 = $model10->getAll();
         // Загвар ашиглан өгөгдлөө хэвл
         // Загвар ашиглан өгөгдлөө хэвлэнэ
        require ROOT . '/view/credit/calendar.php';
     
   
    }
}