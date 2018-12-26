<?php
require_once ROOT . '/controller/Controller.php';
require_once ROOT . '/model/courseclass.php';
class CourseclassController extends Controller {
    public function __construct() {
		parent::__construct();
    }
    public function index() {
        $model = new Courseclass();
        $classes = $model->getAll();
        require ROOT . '/view/courseclass/index.php';
    }
    public function select() {
        $model = new Courseclass();
        $ids = $model->get();
        require ROOT . '/view/courseclass/add.php';
    }
    public function add() {
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['course_id']) &&
                isset($_POST['year']) &&
                isset($_POST['season_id'])){
                $model = new Courseclass();
                $class = new stdClass();
                $class->course_id = $_POST['course_id'];
                $class->year = $_POST['year'];
                $class->season_id = $_POST['season_id'];
                $result = $model->add($class);
                if ($result > 0){
                    $message = 'Амжилттай нэмэгдлээ';
                }
            } else {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
        require ROOT . '/view/courseclass/add.php';
    }
    public function edit($id) {
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['course_id']) &&
                isset($_POST['year']) &&
                isset($_POST['season_id'])){
                $model = new Courseclass();
                $class = new stdClass();
                $class->course_id = $_POST['course_id'];
                $class->year = $_POST['year'];
                $class->season_id = $_POST['season_id'];
                $result = $model->edit($id, $class);
                if ($result > 0){
                    $message = 'Амжилттай нэмэгдлээ';
                } else {
                    $message = 'Нэмж чадсангүй';
                }
            } else {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
        require ROOT . '/view/courseclass/add.php';
    }
    public function remove($id) {
        $message = null;
        if ($id > 0) {
            $model = new Courseclass();
            $result = $model->remove($id);
            $this->index();
        }   
    }   
}