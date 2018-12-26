<?php
require_once ROOT . '/controller/Controller.php';
require_once ROOT . '/model/coursegroup.php';
class CoursegroupController extends Controller {
    public function __construct() {
		parent::__construct();
    }
    public function index() {
        $model = new Coursegroup();
        $groups = $model->getAll();
        require ROOT . '/view/coursegroup/index.php';
    }
    public function add() {
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['course']) &&
                isset($_POST['class']) &&
                isset($_POST['season']) &&
                isset($_POST['user'])){
                $model = new Coursegroup();
                $group = new stdClass();
                $group->course = $_POST['course'];
                $group->class = $_POST['class'];
                $group->season = $_POST['season'];
                $group->user = $_POST['user'];
                $result = $model->add($group);
                if ($result > 0){
                    $message = 'Амжилттай нэмэгдлээ';
                }
            } else {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
        require ROOT . '/view/coursegroup/add.php';
    }
    public function edit($id) {
        $message = null;
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['course']) &&
                isset($_POST['class']) &&
                isset($_POST['season']) &&
                isset($_POST['user'])){
                $model = new Coursegroup();
                $group = new stdClass();
                $group->course = $_POST['course'];
                $group->class = $_POST['class'];
                $group->season = $_POST['season'];
                $group->user = $_POST['user'];
                $result = $model->edit($id, $group);
                if ($result > 0){
                    $message = 'Амжилттай нэмэгдлээ';
                } else {
                    $message = 'Нэмж чадсангүй';
                }
            } else {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
        require ROOT . '/view/coursegroup/add.php';
    }
    public function remove($id) {
        $message = null;
        if ($id > 0) {
            $model = new Coursegroup();
            $result = $model->remove($id);
            $this->index();
        }   
    }   
}