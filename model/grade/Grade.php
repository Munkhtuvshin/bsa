<?php
require_once ROOT . '/model/Model.php';
class Grade extends Model{

    public function __construct() {
		parent::__construct();
    }
    public function getAll() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM student_lesson'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }

    public function get($id){
        $query = "SELECT * FROM student_lesson WHERE id = " . $id;
        $rows = $this->db->query($query);
        if($row = $rows->fetch_object()){
            return $row;
        }
    }


    function edit($id, $point,$description,$student_id,$lesson_id){

        $query="UPDATE `student_lesson` SET `point`=$point,`description`='$description',`student_user_id`=$student_id,`lesson_id`=$lesson_id  WHERE `id`=$id;";
            // var_dump($query);

        $result = $this->db->query($query);
        if($result){
            return $result;
        }
        else{
            echo $this->db->error;
        }
    }
    function remove($id){
        $query = "DELETE FROM student_lesson WHERE id = " . $id;
        $result = $this->db->query($query);
        if($result){
            return $result;
        }
        else{
            echo $this->db->error;
        }
    }

    public function add($point,$description,$student_id,$lesson_id) {
        $query = "INSERT INTO `eschool`.`student_lesson` (`point`, `description`, `lesson_id`, `student_user_id`) VALUES ($point, '$description', $student_id, $lesson_id);";
        return $this->db->query($query); // query ajilluulna
    }

    public function getCourses(){
        $query="select * from course;";
        $res = $this->db->query($query);
        while ($row = $res->fetch_object()) {
            $result[] = $row;
        }
        return $result;
    }

    public function getGradesAndMaxGradeCount($course_id){
        $we="SELECT u.id, u.first_name FROM (((((course as c inner join course_class_type as cct on cct.course_id=    c.id) inner join class_type 
                as ct on ct.id=cct.class_type_id) inner join lesson as l on l.class_type_id=ct.id ) inner join student_lesson as sl
                on sl.lesson_id=l.id) inner join user as u on u.id=sl.student_user_id) left join student_examination as se on se.student_user_id=u.id 
                where c.id=$course_id group by u.id;";

        $query = "SELECT u.id, sl.point as onoo, sl.id as student_lesson_id,l.id as lesson_id, l.description, ct.name FROM ((((course as c inner join course_class_type as cct on cct.course_id=c.id) inner join class_type 
            as ct on ct.id=cct.class_type_id) inner join lesson as l on l.class_type_id=ct.id ) inner join student_lesson as sl
             on sl.lesson_id=l.id) inner join user as u on u.id=sl.student_user_id
             where c.id=$course_id;";

        $res = $this->db->query($query);
        while ($row = $res->fetch_object()) {
            $result[] = $row;
        }
        $res = $this->db->query($we);
        while ($row = $res->fetch_object()) {
            $users[] = $row;
        }

        $r=array($result,$users);
        return $r;
    }

    public function getSoril($course_id){
        $query = "SELECT se.point, se.student_user_id as student_id, se.examination_id as examination_id
         from (((user as u inner join student_examination as se on u.id=se.student_user_id) inner join 
            examination as e on e.id=se.examination_id) inner join class as c on c.id=e.class_id) inner join course 
            on course.id=c.course_id where course.id=$course_id;";

        $res = $this->db->query($query);
        while ($row = $res->fetch_object()) {
            $result[] = $row;
        }
        return $result;
    }

    public function updateSoril($examination_id,$student_id,$value){
        $query="INSERT INTO `eschool`.`student_examination` (`examination_id`, `student_user_id`, `point`) VALUES ('$examination_id', '$student_id', '$value');";
        return $res = $this->db->query($query);
    }

    public function addSoril($examination_id,$student_id,$value){
        $query="INSERT INTO `eschool`.`student_examination` (`examination_id`, `student_user_id`, `point`) VALUES ($examination_id, $student_id, $value);";
        return $res = $this->db->query($query);
    }

    public function updateGrade($student_lesson_id,$value){
        $query="UPDATE `student_lesson` SET `point`='$value' WHERE `id`='$student_lesson_id';";
        return $res = $this->db->query($query);
    }

    public function setGrade($student_lesson_id,$course_id,$value){
        $query="INSERT INTO `student_lesson` (`point`, `description`, `lesson_id`, `student_user_id`) VALUES ('$value', '', '$course_id', '$student_lesson_id');";
        return $res = $this->db->query($query);
    }

    public function getLessons($course_id){
        $query="SELECT lesson.*,ct.name FROM ((lesson inner join class_type as ct on ct.id=lesson.class_type_id) inner join course_class_type as cct on cct.class_type_id=ct.id) 
            inner join course as c on c.id=cct.course_id where c.id=$course_id;";
        $res = $this->db->query($query);
        while ($row = $res->fetch_object()) {
            $result[] = $row;
        }
        return $result;    
    }
    public function getSorilCount(){
        $query="SELECT * from examination;";
        $res = $this->db->query($query);
        while ($row = $res->fetch_object()) {
            $result[] = $row;
        }
        return $result;
    }
    // public function maxSemCount($course_id){
    //     $query="call simpleproc($course_id,'Семинар');";
    //     $rows = $this->db->query($query);
    //     if($row = $rows->fetch_object()){
    //         $re= $row;
    //     }
    //     $rows->close();
    //     return array($re);
        
    // }

    // public function maxLecCount($course_id){
    //     $query="call simpleproc1($course_id,'Лаборатори');";
    //     $rows = $this->db->query($query);
    //     if($row = $rows->fetch_object()){
    //         $re= $row;
    //     }
    //     $rows->close();
    //     return $re;
    // }

}