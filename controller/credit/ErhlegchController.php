<?php 
// Модел классаа оруулж ирнэ
require_once ROOT . '/model/credit/Erhlegch.php';
class ErhlegchController{
     // route: /credit/choose
    public function index(){
         // Модел классын обьектыг үүсгэнэ
         $model = new Erhlegch();
         // Модел классыг ашиглан өгөгдөл ачаална
         $data = $model->getAll();
         // Загвар ашиглан өгөгдлөө хэвлэнэ
        require ROOT . '/view/credit/Erhlegch.php';
    }
}

?>