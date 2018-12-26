<?php
require_once ROOT . '/model/model.php';
class TeacherPage extends Model {
    public function __construct() {
		parent::__construct();
    }
    function getAll(){
        $result = array();
        $query = "SELECT  teacher_schedule.instructor_user_id,course.code,course.name,course.credit, class.year,class.season_id,teacher_schedule.class_room_id, teacher_schedule.par, teacher_schedule.class_type_id
        FROM class
        INNER JOIN teacher_schedule ON class.id=  teacher_schedule.class_id 
        INNER JOIN course ON class.course_id=course.id;";
        $rows = $this->db->query($query);
        while($row = $rows->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }
    function get($id){
        $query = "SELECT  teacher_schedule.instructor_user_id,course.code,course.name,course.credit, class.year,class.season_id,teacher_schedule.class_room_id, teacher_schedule.par, teacher_schedule.class_type_id
        FROM class
        INNER JOIN teacher_schedule ON class.id=  teacher_schedule.class_id 
        INNER JOIN course ON class.course_id=course.id" . $instructor_user_id;
        $rows = $this->db->query($query);
        if($row = $rows->fetch_object()){
            return $row;
        }
    }
    function add($id,$name,$code,$credit,$division_id,$course_type_id,$description){
        $query = "INSERT INTO SELECT  teacher_schedule.instructor_user_id,course.code,course.name,course.credit, class.year,class.season_id,teacher_schedule.class_room_id, teacher_schedule.par, teacher_schedule.class_type_id
        FROM class
        INNER JOIN teacher_schedule ON class.id=  teacher_schedule.class_id 
        INNER JOIN course ON class.course_id=course.id; VALUES (\"$instructor_user_id\",\"$code\",\"$name\",\"$credit\",\"$year\",\"$season_id\",\"$class_room_id\",\"$par\",\"$class_type_id\")";
        $result = $this->db->query($query);
        if(!$result){
            echo $this->db->error;
        }
        return $result;
         
        }  
}