<?php
require_once ROOT . '/controller/Controller.php';
require_once ROOT . '/model/school/School.php';
require_once ROOT . '/model/school/ClassRoom.php';
class classRoomController extends Controller {
    public function __construct() {
		parent::__construct();
    }
    public function index() {
        header("Location: /");
    }
    public function list($school_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            switch($_POST['action']) {
                case 'add': $this->add($school_id); break;
                case 'edit': $this->edit($school_id); break;
                case 'remove': $this->remove(); break;
            }
            header('Location: '.$_SERVER['REQUEST_URI']);
        } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $model = new ClassRoom();
            $classRooms = $model->getBySchoolId($school_id);
            $model = new School();
            $school = $model->get($school_id);
            require ROOT . '/view/school/classRoom.php';
        }
    }
    private function add($school_id) {
        if(isset($_POST['name']) &&
            isset($_POST['floor']) &&
            isset($_POST['capacity']))
        {
            $model = new ClassRoom();
            $classRoom = new stdClass();
            $classRoom->name = $_POST['name'];
            $classRoom->floor = $_POST['floor'];
            $classRoom->capacity = $_POST['capacity'];
            $classRoom->school_id = $school_id;
            
            return $model->add($classRoom);
        }
    }
    private function remove() {
        $id = $_POST['id'];
        if ($id > 0) {
            $model = new ClassRoom();
            return $model->remove($id);
        }
    }
    private function edit($school_id) {
        if(isset($_POST['id']) &&
            isset($_POST['name']) &&
            isset($_POST['floor']) &&
            isset($_POST['capacity']))
        {
            $id = $_POST['id'];
            $model = new ClassRoom();
            $classRoom = new stdClass();
            $classRoom->name = $_POST['name'];
            $classRoom->floor = $_POST['floor'];
            $classRoom->capacity = $_POST['capacity'];
            $classRoom->school_id = $school_id;
            return $model->edit($id, $classRoom);
        }
    }

}