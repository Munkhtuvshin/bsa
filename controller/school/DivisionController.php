<?php
require_once ROOT . '/controller/Controller.php';
require_once ROOT . '/model/school/School.php';
require_once ROOT . '/model/school/Division.php';
require_once ROOT . '/model/general/DivisionType.php';
class DivisionController extends Controller {
    public function __construct() {
		parent::__construct();
    }
    public function index() {
        header("Location: /");
    }
    public function list($school_id) {
        $model = new Division();
        $divisions = $model->getBySchoolId($school_id);
        $model = new School();
        $school = $model->get($school_id);
        require ROOT . '/view/school/division.php';
    }
    public function add($school_id) {
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['name']) &&
                isset($_POST['description']) &&
                isset($_POST['division_type_id'])) {
                $model = new Division();
                $division = new stdClass();
                $division->name = $_POST['name'];
                $division->description = $_POST['description'];
                $division->division_type_id = $_POST['division_type_id'];
                $division->school_id = $school_id;
                $division->parent_id = $_POST['parent_id'];
                $result = $model->add($division);
                if ($result > 0) {
                    header("Location: /school/division/list/" . $school_id);
                    return;
                } else {
                    $message = 'Нэмж чадсангүй';
                }
            } else {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
        $model = new Division();
        $divisions = $model->getBySchoolId($school_id);
        $model = new School();
        $school = $model->get($school_id);
        $model = new DivisionType();
        $divisionTypes = $model->getAll();
        require ROOT . '/view/school/addDivision.php';
    }
    public function edit($id) {
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['name']) &&
                isset($_POST['description']) &&
                isset($_POST['division_type_id'])) {
                $model = new Division();
                $division = new stdClass();
                $division->name = $_POST['name'];
                $division->description = $_POST['description'];
                $division->division_type_id = $_POST['division_type_id'];
                $division->school_id = $_POST['school_id'];
                $division->parent_id = $_POST['parent_id'];
                $result = $model->edit($id, $division);
                if ($result > 0) {
                    header("Location: /school/division/list/" . $_POST['school_id']);
                    return;
                } else {
                    $message = 'Засч чадсангүй';
                }
            } else 
            {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
        $model = new Division();
        $division = $model->get($id);
        $divisions = $model->getBySchoolId($division->school_id);
        $model = new School();
        $school = $model->get($division->school_id);
        $model = new DivisionType();
        $divisionTypes = $model->getAll();
        require ROOT . '/view/school/editDivision.php';
    }
    public function remove($id) {
        if ($id > 0) {
            $model = new Division();
            $model->remove($id);
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

   # public function getEdit(){
    #    $data = $this->
    #}
}

