<?php 
// Модел классаа оруулж ирнэ
require_once ROOT . '/model/credit/Teacher.php';
class TeacherLessonScheduleController{
     // route: /credit/choose
    public function index(){
         // Модел классын обьектыг үүсгэнэ
         $model = new Teacher();
         // Модел классыг ашиглан өгөгдөл ачаална
         $data = $model->getAll();
         // Загвар ашиглан өгөгдлөө хэвлэнэ
        require ROOT . '/view/credit/TeacherLessonSchedule.php';
    }
      // route: /credit/choose/add
     // function add() {
      //  if($_SERVER['REQUEST_METHOD']=='GET'){
            // Мэдээлэл оруулах хуудас харуулна
           // require ROOT.'/view/credit/add1.php';
      //  } else if($_SERVER['REQUEST_METHOD']=='POST'){
            // Өгөгдлийн санд шинэ мэдээлэл оруулна
            // Модел классын обьектыг үүсгэнэ
           // $model = new Teacher();
            // Модел классыг ашиглан өгөгдөл ачаална
           // $result = $model->add($_POST["id"],$_POST["week_day"],$_POST["par"],$_POST["class_id"],$_POST["class_type_id"],$_POST["instructor_user_id"],$_POST["class_room_id"]);
            //if($result) {
                //header('location: /credit/TeacherLessonChoose');
           // }
           // else{
             //   echo "aldaa olson";
         //   }
     //   } else {
         //   echo "wrong request";
       // }
   // }
     // route: /credit/choose/edit/[id]
   //  function edit($id) {
        // Модел классын обьектыг үүсгэнэ
     //   $model = new Teacher();
      //  if($_SERVER['REQUEST_METHOD']=='GET'){
        //    $data = $model->edit($id);
            // Мэдээлэл оруулах хуудас харуулна
          //  require ROOT.'/view/credit/edit1.php';
        //} else if($_SERVER['REQUEST_METHOD']=='POST'){
          //  $id = $_POST['id'];
            //$week_day = $_POST['week_day'];
            //$par= $_POST['par'];
            //$class_id = $_POST['class_id'];
            //$class_type_id = $_POST['class_type_id'];
            //$instructor_user_id = $_POST['instructor_user_id'];
            //$class_room_id = $_POST['class_room_id'];
            // Өгөгдлийн санд шинэ мэдээлэл оруулна
            // Модел классыг ашиглан өгөгдөл ачаална
            //$result = $model->edit2($id,$week_day,$par,$class_id,$class_type_id,$instructor_user_id,$class_room_id);
            //if($result) {
              //  header('location: /credit/TeacherLessonChoose');
            //}
        //} else {
          //  echo "wrong request";
        //}
    //}
   // function remove($id) {
        // Модел классын обьектыг үүсгэнэ
     //   $model = new Teacher();
       // if($_SERVER['REQUEST_METHOD']=='POST'){
            // Өгөгдлийн санд шинэ мэдээлэл оруулна
            // Модел классыг ашиглан өгөгдөл ачаална
         //   $result = $model->remove($id);
           // if($result) {
             //   header('location: /credit/TeacherLessonChoose');
            //}
        //} else {
         //   echo "wrong request";
        //}
    //}
//}

}
?>