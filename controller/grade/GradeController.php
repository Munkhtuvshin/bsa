<?php 
require_once ROOT . '/model/grade/Grade.php';

class GradeController{
    public function index(){
        require ROOT . '/view/grade/hicheel-jagsaalt-harah.php';
    }

    public function grades(){
    	$model = new Grade();
    	$grades=$model->getAll();
    	require ROOT.'/view/grade/gradeList.php';
    }

    function remove($id) {
        $model = new Grade();
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $result = $model->remove($id);
            if($result) {
                header('location: /grade/grade/grades');
            }
        } else {
            echo "wrong request";
        }
    }

    function edit($id) {
        // Модел классын обьектыг үүсгэнэ
        $model = new Grade();
        if($_SERVER['REQUEST_METHOD']=='GET'){
            $grade = $model->get($id);
            require ROOT.'/view/grade/edit.php';
        } else if($_SERVER['REQUEST_METHOD']=='POST'){
            // Өгөгдлийн санд шинэ мэдээлэл оруулна
            // Модел классыг ашиглан өгөгдөл ачаална
            $result = $model->edit($id, $_POST["point"],$_POST["description"],$_POST["student_id"],$_POST["lesson_id"]);
            if($result) {
                header('location: /grade/grade/grades');
            }
        } else {
            echo "wrong request";
        }
    }

    public function add(){
    	if($_SERVER['REQUEST_METHOD']=='GET'){
            // Мэдээлэл оруулах хуудас харуулна
            require ROOT . '/view/grade/add.php';
        } else if($_SERVER['REQUEST_METHOD']=='POST'){
            $model = new Grade();
            $result = $model->add($_POST["point"],$_POST["description"],$_POST["student_id"],$_POST["lesson_id"]);
            if($result) {
                header('location: /grade/grade/grades');
            }
        } else {
            echo "wrong request";
        }
    }

    public function courses(){
        if($_SERVER['REQUEST_METHOD']=='GET'){
            // Мэдээлэл оруулах хуудас харуулна
            $model = new Grade();
            $courses = $model->getCourses();
            require ROOT . '/view/grade/Courses.php';
        } else if($_SERVER['REQUEST_METHOD']=='POST'){
            
        } else {
            echo "wrong request";
        }        
    }

    public function grade($course_id){
        $model = new Grade();
        if($_SERVER['REQUEST_METHOD']=='GET'){
            $results = $model->getGradesAndMaxGradeCount($course_id);
            $lessons = $model->getLessons($course_id);
            $maxLab=0;$maxLec=0;$maxSem=0;
            $labIds=array();$lecIds=array();$semIds=array();
            foreach ($lessons as $key => $value) {
                if($value->name=="Лаборатори") {
                    $maxLab++;
                    $labIds[]=$value->id;
                }
                else if($value->name=="Лекц"){
                    $maxLec++;
                    $lecIds[]=$value->id;
                }
                else if($value->name=="Семинар"){
                    $maxSem++;
                    $semIds[]=$value->id;
                }
            }

            foreach ($lessons as $key => $value) {
                $lesson_ids[]=$value->id;
            }
            $sorils=$model->getSoril($course_id);
            $examinations=$model->getSorilCount();
            $course_id=$course_id;
            $sorilCount=0;
            $sorilIds=array();
            foreach ($examinations as $key => $value) {
                $sorilCount++;
                $sorilIds[]=$value->id;
            }
            // var_dump($sorilCount);
            // var_dump($sorils);
            require ROOT . '/view/grade/Grades.php';


        } else {
            echo "wrong request";
        }
    }

    public function editGrade(){
        $model = new Grade();
        if($_SERVER['REQUEST_METHOD']=='POST'){
            echo $model->updateGrade($_POST["student_lesson"],$_POST["value"]);
        }
    }

    public function addGrade(){
        $model = new Grade();
        if($_SERVER['REQUEST_METHOD']=='POST'){
            // echo $_POST["value"];
            echo $model->setGrade($_POST["student_lesson"],$_POST["course_id"],$_POST["value"]);
        }
    }

    public function editSoril(){
        $model = new Grade();
        echo $model->updateSoril($_POST["examination_id"],$_POST["student_id"], $_POST["value"]);
    }

    public function addSoril(){
        $model = new Grade();
        echo $model->addSoril($_POST["examination_id"],$_POST["student_id"], $_POST["value"]);
    }
}

?>