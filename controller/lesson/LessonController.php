<?php
require_once ROOT . '/controller/Controller.php';
require_once ROOT . '/model/lesson.php';
class LessonController extends Controller {
    public function __construct() {
		parent::__construct();
    }
    public function index() {
        $model = new Lesson();
        $lessons = $model->getAll();
        $lessons = $model->getAllLesson();
        $classs = $model->getAllClass();
        $classType = $model->getAllClassType();
        require ROOT . '/view/lesson/index.php';
    }

    public function getAllLesson() {
        $model = new Lesson();
        $lessons = $model->getAll();
        $lessons = $model->getAllLesson();
         $classs = $model->getAllClass();
        $classType = $model->getAllClassType();
        require ROOT . '/view/lesson/index.php';
    }
    public function add() {
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
         {
            if(isset($_POST['subject']) &&
                isset($_POST['description']) &&
                isset($_POST['class_type_id']) &&
                isset($_POST['class_id']))
            {
                $model = new Lesson();
                $lesson = new stdClass();
                $lesson->subject = $_POST['subject'];
                $lesson->description = $_POST['description'];
                $lesson->class_type_id = $_POST['class_type_id'];
                $lesson->class_id = $_POST['class_id'];
                $result = $model->add($lesson);
                if ($result > 0)
                {
                    echo "<script>alert('Даалгавар нэмэгдлээ'); window.location='getAllLesson';</script>";
                } else {
                    $message = 'Нэмж чадсангүй';
                }
            } else 
            {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
         $model = new Lesson();
        $lessons = $model->getAllLesson();
        $classs = $model->getAllClass();
        $classTypes = $model->getAllClassType();
        require ROOT . '/view/lesson/addLesson.php';
        #redirect("/view/lesson/index.php");
    }
     public function edit($id) {
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
         {
            if(isset($_POST['subject']) &&
                isset($_POST['description']) &&
                isset($_POST['class_type_id']) &&
                isset($_POST['class_id'])){
                $model = new Lesson();
                $lesson = new stdClass();
                $lesson->subject = $_POST['subject'];
                $lesson->description = $_POST['description'];
                $lesson->class_type_id = $_POST['class_type_id'];
                $lesson->class_id = $_POST['class_id'];
                $result = $model->edit($id, $lesson);
                if ($result > 0)
                {
                    echo "<script>alert('Даалгавар засагдлаа'); window.location='getAllLesson';</script>";
                } else {
                    $message = 'Засч чадсангүй';
                }
            } else 
            {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
         $model = new Lesson();
        $lessons = $model->getAllLesson();
        $classs = $model->getAllClass();
        $classTypes = $model->getAllClassType();
        require ROOT . '/view/lesson/editLesson.php';
        #redirect("/view/lesson/index.php");
    }

   

    public function remove($id) {
        if ($id > 0) {
            $model = new Lesson();
            $result = $model->remove($id);
            $this->index();
            #require ROOT . '/view/lesson/add.php';
            #redirect("http://localhost:8081");
        }
    }

   # public function getEdit(){
    #    $data = $this->
    #}
}

