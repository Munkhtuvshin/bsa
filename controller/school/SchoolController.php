<?php
require_once ROOT . '/controller/Controller.php';
require_once ROOT . '/model/school/School.php';
class SchoolController extends Controller {
    public function __construct() {
		parent::__construct();
    }
    public function index() {
        $model = new School();
        $schools = $model->getAll();
        $addresss = $model->getAllAddress(); 
        require ROOT . '/view/school/school.php';
    }
    public function add() {
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
         {
            if(isset($_POST['schoolName']))
            {
                $model = new School();
                $school = new stdClass();
                $school->schoolName = $_POST['schoolName'];
                $school->description = $_POST['description'];
                $school->address = $_POST['address'];
                $school->parent = $_POST['parent'];
                $school->address_id = $_POST['address_id'];
                $result = $model->add($school);
                if ($result > 0)
                {
                    echo "<script>alert('Сургууль нэмэгдлээ'); window.location='getAllSchool';</script>";
                } else {
                    $message = 'Нэмж чадсангүй';
                }
            } else 
            {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
        $model = new School();
        $schools = $model->getAll();
        $addresss = $model->getAllAddress();
        require ROOT . '/view/school/addSchool.php';
    }
    public function remove($id) {
        if ($id > 0) {
            $model = new School();
            $result = $model->remove($id);
            $this->index();
        }
    }
    public function edit($id) {
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['schoolName']) &&
                isset($_POST['description'])&&
                isset($_POST['address']) &&
                isset($_POST['parent'])  &&
                isset($_POST['address_id'])) {
                $model = new School();
                $school = new stdClass();
                $school->schoolName = $_POST['schoolName'];
                $school->description = $_POST['description'];
                $school->address = $_POST['address'];
                $school->parent = $_POST['parent'];
                $school->address_id = $_POST['address_id'];
                $result = $model->edit($id, $school);
                if ($result > 0)
                {
                    $message = 'Амжилттай засагдлаа';
                } else {
                    $message = 'Засч чадсангүй';
                }
            } else {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
        $model = new School();
        $school = $model->get($id);
        $schools = $model->getAll();
        $addresss = $model->getAllAddress();
        require ROOT . '/view/school/editSchool.php';
    }

}