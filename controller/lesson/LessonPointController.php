<?php
require_once ROOT . '/controller/Controller.php';
require_once ROOT . '/model/lessonPoint.php';
class LessonPointController extends Controller {
    public function __construct() {
		parent::__construct();
    }
    public function index() {
        $model = new LessonPoint();
        $lessonPoints = $model->getAll();
        $lessonPoints = $model->getAllLessonPoint();
        $lessons = $model->getAllLesson();
        
        require ROOT . '/view/lesson/lessonPoint.php';
    }

    public function getAllLessonPoint() {
        $model = new LessonPoint();
        $lessonPoints = $model->getAll();
        $lessonPoints = $model->getAllLessonPoint();
         $lessons = $model->getAllLesson();
        require ROOT . '/view/lesson/lessonPoint.php';
    }
    public function add() {
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
         {
            if(isset($_POST['start_date']) &&
                isset($_POST['end_date']) &&
                isset($_POST['point']) &&
                isset($_POST['lesson_id']))
            {
                $model = new LessonPoint();
                $lessonPoint = new stdClass();
                $lessonPoint->start_date = $_POST['start_date'];
                $lessonPoint->end_date = $_POST['end_date'];
                $lessonPoint->point = $_POST['point'];
                $lessonPoint->lesson_id = $_POST['lesson_id'];
                $result = $model->add($lessonPoint);
                if ($result > 0)
                {
                    echo "<script>alert('Оноо нэмэгдлээ'); window.location='getAllLessonPoint';</script>";
                } else {
                    $message = 'Нэмж чадсангүй';
                }
            } else 
            {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
         $model = new LessonPoint();
        $lessonPoints = $model->getAllLessonPoint();
        $lessons = $model->getAllLesson();
       
        require ROOT . '/view/lesson/addLessonPoint.php';
        #redirect("/view/lesson/index.php");
    }
     public function edit($id) {
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
         {
           if(isset($_POST['start_date']) &&
                isset($_POST['end_date']) &&
                isset($_POST['point']) &&
                isset($_POST['lesson_id']))
            {
                $model = new LessonPoint();
                $lessonPoint = new stdClass();
                $lessonPoint->start_date = $_POST['start_date'];
                $lessonPoint->end_date = $_POST['end_date'];
                $lessonPoint->point = $_POST['point'];
                $lessonPoint->lesson_id = $_POST['lesson_id'];
                $result = $model->edit($id, $lessonPoint);
                if ($result > 0)
                {
                    #echo "<script>alert('Даалгавар засагдлаа'); window.location='getAllLesson';</script>";
                } else {
                    $message = 'Засч чадсангүй';
                }
            } else 
            {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
         $model = new LessonPoint();
        $lessonPoints = $model->getAllLessonPoint();
        $lessons = $model->getAllLesson();
       
        require ROOT . '/view/lesson/editLessonPoint.php';
        #redirect("/view/lesson/index.php");
    }

   

    public function remove($id) {
        if ($id > 0) {
            $model = new LessonPoint();
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

