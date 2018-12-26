<?php 
// Модел классаа оруулж ирнэ
require_once ROOT . '/model/credit/LessonChoose.php';
class TeacherLessonChooseController{
    // route: /credit/choose
    public function index(){
         // Модел классын обьектыг үүсгэнэ
         $model = new LessonChoose();
         // Модел классыг ашиглан өгөгдөл ачаална
         $data = $model->getAll();
         // Загвар ашиглан өгөгдлөө хэвлэнэ
        require ROOT . '/view/credit/TeacherLessonChoose.php';
    }
    // route: /credit/choose/add
    function add1() {
        if($_SERVER['REQUEST_METHOD']=='GET'){
            // Мэдээлэл оруулах хуудас харуулна
            require ROOT.'/view/credit/add1.php';
        } else if($_SERVER['REQUEST_METHOD']=='POST'){
            // Өгөгдлийн санд шинэ мэдээлэл оруулна
            // Модел классын обьектыг үүсгэнэ
            $model = new LessonChoose();
            // Модел классыг ашиглан өгөгдөл ачаална
            $result = $model->add($_POST["id"],$_POST["name"],$_POST["code"],$_POST["credit"],$_POST["division_id"],$_POST["course_type_id"],$_POST["description"]);
            if($result) {
                header('location: /credit/TeacherLessonChoose');
            }
            else{
                echo "aldaa olson";
            }
        } else {
            echo "wrong request";
        }
    }
     // route: /credit/choose/edit/[id]
     //function edit($id) {
        // Модел классын обьектыг үүсгэнэ
      //  $model = new LessonChoose();
      //  if($_SERVER['REQUEST_METHOD']=='GET'){
      //      $data = $model->edit($id);
            // Мэдээлэл оруулах хуудас харуулна
     //       require ROOT.'/view/credit/editChoose.php';
      //  } else if($_SERVER['REQUEST_METHOD']=='POST'){
         //   $id = $_POST['id'];
          //  $name = $_POST['name'];
          //  $division_type_id= $_POST['code'];
           // $school_id = $_POST['credit'];
          //  $parent_id = $_POST['division_id'];
          //  $parent_id = $_POST['course_type_id'];
         //   $parent_id = $_POST['description'];
         //   $result = $model->editPost($id,$name,$code,$credit,$division_id,$course_type_id,$description);
        //   if($result) {
           //     header('location: /credit/TeacherLessonChoose');
        //    }
     //   } else {
         //   echo "wrong request";
     //   }
    //}
    function remove($id) {
        // Модел классын обьектыг үүсгэнэ
        $model = new LessonChoose();
        if($_SERVER['REQUEST_METHOD']=='POST'){
            // Өгөгдлийн санд шинэ мэдээлэл оруулна
            // Модел классыг ашиглан өгөгдөл ачаална
            $result = $model->remove($id);
            if($result) {
                header('location: /credit/TeacherLessonChoose');
            }
        } else {
            echo "wrong request";
        }
    }

}
?>