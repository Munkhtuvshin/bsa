<?php 
// Модел классаа оруулж ирнэ
require_once ROOT . '/model/credit/div.php';
class ChooseController{
     // route: /credit/choose
    public function index(){
         // Модел классын обьектыг үүсгэнэ
         $model = new div();
         // Модел классыг ашиглан өгөгдөл ачаална
         $data = $model->getAll();
         // Загвар ашиглан өгөгдлөө хэвлэнэ
        require ROOT . '/view/credit/choose1.php';
    }
      // route: /credit/choose/add
      function add() {
        if($_SERVER['REQUEST_METHOD']=='GET'){
            // Мэдээлэл оруулах хуудас харуулна
            require ROOT.'/view/credit/add.php';
        } else if($_SERVER['REQUEST_METHOD']=='POST'){
            // Өгөгдлийн санд шинэ мэдээлэл оруулна
            // Модел классын обьектыг үүсгэнэ
            $model = new div();
            // Модел классыг ашиглан өгөгдөл ачаална
            $result = $model->add($_POST["id"],$_POST["lesson_date"],$_POST["code"],$_POST["student_count"],$_POST["subject"],$_POST["class_type_id"],$_POST["name"],$_POST["Duration"]);
            if($result) {
                header('location: /credit/choose');
            }
            else{
                echo "aldaa olson";
            }
        } else {
            echo "wrong request";
        }
    }
     // route: /credit/choose/edit/[id]
     function edit($id) {
        // Модел классын обьектыг үүсгэнэ
        $model = new div();
        if($_SERVER['REQUEST_METHOD']=='GET'){
            $data = $model->edit($id);
            // Мэдээлэл оруулах хуудас харуулна
            require ROOT.'/view/credit/edit.php';
        } else if($_SERVER['REQUEST_METHOD']=='POST'){
            $id = $_POST['id'];
            $lesson_date = $_POST['lesson_date'];
            $code= $_POST['code'];
            $student_count = $_POST['student_count'];
            $subject = $_POST['subject'];
            $name = $_POST['name'];
            $Duration = $_POST['Duration'];
            // Өгөгдлийн санд шинэ мэдээлэл оруулна
            // Модел классыг ашиглан өгөгдөл ачаална
            $result = $model->edit1($id,$lesson_date,$code,$student_count,$subject,$class_type_id,$name,$Duration);
            if($result) {
                header('location: /credit/choose');
            }
        } else {
            echo "wrong request";
        }
    }
    function remove($id) {
        // Модел классын обьектыг үүсгэнэ
        $model = new div();
        if($_SERVER['REQUEST_METHOD']=='POST'){
            // Өгөгдлийн санд шинэ мэдээлэл оруулна
            // Модел классыг ашиглан өгөгдөл ачаална
            $result = $model->remove($id);
            if($result) {
                header('location: /credit/choose');
            }
        } else {
            echo "wrong request";
        }
    }
}


?>



   