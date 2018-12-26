<?php
require_once ROOT . '/controller/Controller.php';
require_once ROOT . '/model/course/Course.php';
class CourseController extends Controller {
    public function __construct() {
		parent::__construct();
    }
    public function index() {
        $model = new Course();
        $courses = $model->getAllCourse();
        $courses = $model->getAll();

        $divisions = $model->getAllDivision();
        $courseTypes = $model->getAllCourseType();
        require ROOT . '/view/lessonAdmin/course.php';
    }
     public function getAllCourse(){
        $model = new  Course();
        $courses = $model->getAllCourse();
        #$schools = $model->getAllSchool();
        #$divisionTypes = $model->getAllDivisionType();
        require ROOT . '/view/lessonAdmin/course.php';
    }
    public function add() {
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
         {
            if(isset($_POST['name']) &&
                isset($_POST['code']) &&
                isset($_POST['credit']) &&
                isset($_POST['division_id']) &&
                isset($_POST['course_type_id']) &&
                isset($_POST['description']))
            {
                $model = new Course();
                $course = new stdClass();
                $course->name = $_POST['name'];
                $course->code = $_POST['code'];
                $course->credit = $_POST['credit'];
                $course->division_id = $_POST['division'];
                $course->course_type_id = $_POST['courseType'];
                $course->description = $_POST['description'];
                $result = $model->add($course);
                if ($result > 0)
                {
                    $message = 'Амжилттай нэмэгдлээ';
                    #$this->index();
                } else {
                    $message = 'Нэмж чадсангүй';
                }
            } else 
            {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
        $model = new Course();
        $courses = $model->getAllCourse();
        $divisions = $model->getAllDivision();
        $courseTypes = $model->getAllCourseType();
        require ROOT . '/view/lessonAdmin/addCourse.php';
        #redirect("/view/lesson/index.php");
    }
     public function edit($id) {
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
         {
            if(isset($_POST['name']) &&
                isset($_POST['code']) &&
                isset($_POST['division_id']) &&
                isset($_POST['course_type_id']) &&
                isset($_POST['description']))
            {
                $model = new Course();
                $course = new stdClass();
                $course->name = $_POST['name'];
                $course->code = $_POST['code'];
                 $course->credit = $_POST['credit'];
                $course->division_id = $_POST['division_id'];
                $course->course_type_id = $_POST['course_type_id'];
                $course->description = $_POST['description'];
                $result = $model->edit($id, $course);
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
        $model = new Course();
        $courses = $model->getAllCourse();
        $divisions = $model->getAllDivision();
        $courseTypes = $model->getAllCourseType();
        require ROOT . '/view/lessonAdmin/editCourse.php';
        #redirect("/view/lesson/index.php");
    }

   

    public function remove($id) {
        if ($id > 0) {
            $model = new Course();
            $result = $model->remove($id);
            #echo "<script>alert('Хичээл устлаа'); window.location='getAllCourse';</script>";
            $this->index();
            #require ROOT . '/view/lesson/add.php';
            #redirect("http://localhost:8081");
        }
    }

   # public function getEdit(){
    #    $data = $this->
    #}
}

