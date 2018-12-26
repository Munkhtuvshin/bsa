<?php
require_once ROOT . '/controller/Controller.php';
require_once ROOT . '/model/school/School.php';
require_once ROOT . '/model/school/Par.php';
class ParController extends Controller {
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
        $model = new Par();
        $pars = $model->getBySchoolId($school_id);
        $model = new School();
        $school = $model->get($school_id);
        require ROOT . '/view/school/par.php';
        }
    }
    private function add($school_id) {
        if(isset($_POST['id']) &&
            isset($_POST['start_time']) &&
            isset($_POST['end_time']))
        {
            $model = new Par();
            $par = new stdClass();
            $par->school = $school_id;
            $par->id = $_POST['id'];
            $par->start_time = $_POST['start_time'];
            $par->end_time = $_POST['end_time'];
            
            return $model->add($par);
        }
    }

    private function remove() {
        $id = $_POST['id'];
        if ($id > 0) {
            $model = new Par();
            return $model->remove($id);
        }
    }

    private function edit($school_id) {
        if(isset($_POST['id']) &&
            isset($_POST['start_time']) &&
            isset($_POST['end_time'])){
            $id = $_POST['id'];
            $model = new Par();
            $par = new stdClass();
            $par->school = $school_id;
            $par->id =$_POST['par'];
            $par->start_time = $_POST['start_time'];
            $par->end_time = $_POST['end_time'];
            return $model->edit($id, $par);
        }
    }

}