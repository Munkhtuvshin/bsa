<?php
require_once ROOT . '/controller/Controller.php';
require_once ROOT . '/model/lessonFile.php';
class LessonFileController extends Controller {
    public function __construct() {
		parent::__construct();
    }
    public function index() {
        $model = new File();
        $files = $model->getAll();
        require ROOT . '/view/lessonFile/index.php';
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
                    $message = 'Амжилттай нэмэгдлээ';
                } else {
                    $message = 'Нэмж чадсангүй';
                }
            } else 
            {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
        require ROOT . '/view/lesson/add.php';
    }


    public function download($path){
        if(isset($_GET['dow']))  {
            $path = $_GET['dow'];

            header('Content=Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($path).'"');
            header('Content-Length: '.filesize($path));
            readfile($path);
            # code...
        }
    }
}
