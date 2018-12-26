<?php 
// Модел классаа оруулж ирнэ
require_once ROOT . '/model/credit/TeacherPage.php';
class TeacherPageController{
     // route: /credit/choose
    public function index(){
         // Модел классын обьектыг үүсгэнэ
         $model = new TeacherPage();
         // Модел классыг ашиглан өгөгдөл ачаална
         $data = $model->getAll();
         // Загвар ашиглан өгөгдлөө хэвлэнэ
        require ROOT . '/view/credit/TeacherPage.php';
    }
    function add2() {
        if($_SERVER['REQUEST_METHOD']=='GET'){
            // Мэдээлэл оруулах хуудас харуулна
            require ROOT.'/view/credit/TeacherPageAdd.php';
        } else if($_SERVER['REQUEST_METHOD']=='POST'){
            // Өгөгдлийн санд шинэ мэдээлэл оруулна
            // Модел классын обьектыг үүсгэнэ
            $model = new TeacherPage();
            // Модел классыг ашиглан өгөгдөл ачаална
            $result = $model->add($_POST["instructor_user_id"],$_POST["code"],$_POST["name"],$_POST["credit"],$_POST["year"],$_POST["season_id"],$_POST["class_room_id"],$_POST["par"],$_POST["class_type_id"]);
            if($result) {
                header('location: /credit/TeacherPage');
            }
            else{
                echo "aldaa olson";
            }
        } else {
            echo "wrong request";
        }
    }
}