<?php
require_once ROOT . '/controller/Controller.php';
require_once ROOT . '/model/schedule/TeacherSchedule.php';
class TeacherScheduleController extends Controller {
    public function __construct() {
		parent::__construct();
    }
    public function index() {
        $model = new TeacherSchedule();
        $teacher_schedules = $model->getAll();
        $teacherSchedules = $model->getAllTeacherSchedule();
        $classs = $model->getAllClass();
        $classTypes = $model->getAllClassType();
        $users = $model->getAllUser();
        $classRooms = $model->getAllClassRoom();
        require ROOT . '/view/lesson/teacherSchedule.php';
    }
    public function getAllTeacherSchedule(){
        $model = new  TeacherSchedule();
        $teacher_schedules = $model->getAllTeacherSchedule();
        $classs = $model->getAllClass();
        $classTypes = $model->getAllClassType();
        $users = $model->getAllUser();
        $classRooms = $model->getAllClassRoom();
        #$categories = $model->getAllCategories();
        require ROOT . '/view/lesson/teacherSchedule.php';
    }

     public function add() {
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
         {
            if(isset($_POST['week_day']) &&
                isset($_POST['par'])&&
                isset($_POST['class_id']) &&
                isset($_POST['class_type_id'])  &&
                isset($_POST['instructor_user_id']) &&
                isset($_POST['class_room_id']))
            {
                $model = new TeacherSchedule();
                $teacherSchedule = new stdClass();
                $teacherSchedule->week_day = $_POST['week_day'];
                $teacherSchedule->par = $_POST['par'];
                $teacherSchedule->class_id = $_POST['class_id'];
                $teacherSchedule->class_type_id = $_POST['class_type_id'];
                $teacherSchedule->instructor_user_id = $_POST['instructor_user_id'];
                $teacherSchedule->class_room_id = $_POST['class_room_id'];
                $result = $model->add($teacherSchedule);
                if ($result > 0)
                {
                    #$message = 'Амжилттай нэмэгдлээ';
                    echo "<script>alert('Хөтөлбөр нэмэгдлээ'); window.location='getAllTeacherSchedule';</script>";
                   # $this->index();
                } else {
                    $message = 'Нэмж чадсангүй';
                }
            } else 
            {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
        $model = new TeacherSchedule();
        $teacherSchedules = $model->getAllTeacherSchedule();
        $classs = $model->getAllClass();
        $classTypes = $model->getAllClassType();
        $users = $model->getAllUser();
        $classRooms = $model->getAllClassRoom();
        require ROOT . '/view/lesson/addTeacherSchedule.php';
        #redirect("/view/lesson/index.php");
    }

    public function remove($id) {
        if ($id > 0) {
            $model = new TeacherSchedule();
            $result = $model->remove($id);
            $this->index();
            #require ROOT . '/view/lesson/add.php';
            #redirect("http://localhost:8081");
        }
    }

    public function edit($id) {
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
         {
            if(isset($_POST['week_day']) &&
                isset($_POST['par'])&&
                isset($_POST['class_id']) &&
                isset($_POST['class_type_id'])  &&
                isset($_POST['instructor_user_id']) &&
                isset($_POST['class_room_id']))
            {
                $model = new TeacherSchedule();
                $teacherSchedule = new stdClass();
                $teacherSchedule->week_day = $_POST['week_day'];
                $teacherSchedule->par = $_POST['par'];
                $teacherSchedule->class_id = $_POST['class_id'];
                $teacherSchedule->class_type_id = $_POST['class_type_id'];
                $teacherSchedule->instructor_user_id = $_POST['instructor_user_id'];
                $teacherSchedule->class_room_id = $_POST['class_room_id'];
                $result = $model->edit($id, $teacherSchedule);
                if ($result > 0)
                {
                    echo "<script>alert('Хөтөлбөр засагдлаа'); window.location='getAllTeacherSchedule';</script>";
                } else {
                    $message = 'Засч чадсангүй';
                }
            } else 
            {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
       $model = new TeacherSchedule();
        $teacherSchedules = $model->getAllTeacherSchedule();
        $classs = $model->getAllClass();
        $classTypes = $model->getAllClassType();
        $users = $model->getAllUser();
        $classRooms = $model->getAllClassRoom();
        require ROOT . '/view/lesson/editTeacherSchedule.php';
    }

}