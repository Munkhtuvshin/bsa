<?php
require_once ROOT . '/controller/Controller.php';
require_once ROOT . '/model/course/Class.php';
class ClassController extends Controller {
    public function __construct() {
		parent::__construct();
    }
    public function index() {
        $model = new Class1();
        $classs = $model->getAll();

        $courses = $model->getAllCourse();
        $seasons = $model->getAllSeason();
        require ROOT . '/view/lessonAdmin/class.php';
    }
     public function getAllClass(){
        $model = new  Class1();
        $classs = $model->getAllClass();
        require ROOT . '/view/lessonAdmin/class.php';
    }
    public function add() {
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
         {
            if(isset($_POST['year']) &&
                isset($_POST['course_id']) &&
                isset($_POST['season_id']))
            {
                $model = new Class1();
                $class = new stdClass();
                $class->year = $_POST['year'];
                $class->course_id = $_POST['course_id'];
                $class->season_id = $_POST['season_id'];
                $result = $model->add($class);
                if ($result > 0)
                {
                    $message = 'Амжилттай нэмэгдлээ';
                    $this->index();
                } else {
                    $message = 'Нэмж чадсангүй';
                }
            } else 
            {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
        $model = new Class1();
        $classs = $model->getAllClass();
        $courses = $model->getAllCourse();
        $seasons = $model->getAllSeason();
        require ROOT . '/view/lessonAdmin/addClass.php';
    }
     public function edit($id) {
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
         {
            if(isset($_POST['year']) &&
                isset($_POST['course_id']) &&
                isset($_POST['season_id']))
            {
                $model = new Class1();
                $class = new stdClass();
                $class->year = $_POST['year'];
                $class->course_id = $_POST['course_id'];
                $class->season_id = $_POST['season_id'];
                $result = $model->edit($id, $class);
                if ($result > 0)
                {
                    $message = 'Амжилттай засагдлаа';
                    $this->index();
                } else {
                    $message = 'Засч чадсангүй';
                }
            } else 
            {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
        $model = new Class1();
        $classs = $model->getAllClass();
        $courses = $model->getAllCourse();
        $seasons = $model->getAllSeason();
        require ROOT . '/view/lessonAdmin/editClass.php';
    }

   

    public function remove($id) {
        if ($id > 0) {
            $model = new Class1();
            $result = $model->remove($id);
            $this->index();
        }
    }
}

