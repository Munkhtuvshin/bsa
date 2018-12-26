<?php
require_once ROOT . '/controller/Controller.php';
require_once ROOT . '/model/general/CourseType.php';
class CourseTypeController extends Controller {
    public function __construct() {
		parent::__construct();
    }
    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            switch($_POST['action']) {
                case 'add': $this->add(); break;
                case 'edit': $this->edit(); break;
                case 'remove': $this->remove(); break;
            }
            header('Location: '.$_SERVER['REQUEST_URI']);
        } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $model = new CourseType();
            $courseTypes = $model->getAll();
            require ROOT . '/view/general/coursetype.php';
        }
    }
    private function add() {
        if(isset($_POST['name']))
        {
            $model = new CourseType();
            $courseType = new stdClass();
            $courseType->name = $_POST['name'];
            return $model->add($courseType);
        }
    }
    private function remove() {
        $id = $_POST['id'];
        if ($id > 0) {
            $model = new CourseType();
            return $model->remove($id);
        }
    }
    private function edit() {
        if(isset($_POST['name']))
        {
            $model = new CourseType();
            $courseType = new stdClass();
            $id = $_POST['id'];
            $courseType->name = $_POST['name'];
            return $model->edit($id, $courseType);
        }
    }
}