<?php
require_once ROOT . '/model/Model.php';
class TeacherSchedule extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getAll() {
        $result = array(); // butsaah utga hadgalna
        $query = "SELECT TS.id AS TSid, TS.week_day, TS.par,  C.year AS CYear, CT.name AS CTName, U.username AS UName, CR.name AS CRName 
        FROM teacher_schedule AS TS INNER JOIN class AS C ON TS.class_id = C.id INNER JOIN class_type AS CT ON TS.class_type_id = CT.id INNER JOIN user AS U ON TS.instructor_user_id = U.id INNER JOIN class_room AS CR ON TS.class_room_id = CR.id ";
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function getAllTeacherSchedule() {
        $result = array(); // butsaah utga hadgalna
        $query = "SELECT TS.id AS TSid, TS.week_day, TS.par,  C.year AS CYear, CT.name AS CTName, U.username AS UName, CR.name AS CRName 
        FROM teacher_schedule AS TS INNER JOIN class AS C ON TS.class_id = C.id INNER JOIN class_type AS CT ON TS.class_type_id = CT.id INNER JOIN user AS U ON TS.instructor_user_id = U.id INNER JOIN class_room AS CR ON TS.class_room_id = CR.id ";
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    //Дараах код нь бүх утгыг нэмнэ
    public function add($teacherSchedule) {
        $query = 'INSERT INTO teacher_schedule (week_day, par, class_id, class_type_id, instructor_user_id, class_room_id)';
        $query .= 'values ("' . $teacherSchedule->week_day . '", "' .  $teacherSchedule->par . '", "' . $teacherSchedule->class_id . '", "' . $teacherSchedule->class_type_id .'", "' . $teacherSchedule->instructor_user_id . '", "' . $teacherSchedule->class_room_id . '" )';
        return $this->db->query($query); // query ajilluulna
    }
    public function getAllClass() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM class'; // select query
       
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function getAllClassType() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM class_type'; // select query
       
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function getAllUser() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM user'; // select query
       
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function getAllClassRoom() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM class_room'; // select query
       
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    //Дараах код нь address.php бүх утгыг устгана
    public function remove($id) {
       $query = 'DELETE FROM teacher_schedule WHERE id = ' . intVal($id);
        #$query = "DELETE FROM lesson WHERE id ='".$_GET['id']."'";

        return $this->db->query($query); // query ajilluulna

        #header("Location: /view/lesson/index.php");
    }
    public function edit($id, $teacherSchedule){
        $query = 'UPDATE teacher_schedule SET ';
        $query .= 'week_day = "' . $teacherSchedule->week_day . '",
                    par = "' . $teacherSchedule->par . '",
                    class_id = "' . $teacherSchedule->class_id . '",
                    class_type_id = "' . $teacherSchedule->class_type_id . '",
                    class_room_id = "' . $teacherSchedule->class_room_id . '",
                    instructor_user_id = "' . $teacherSchedule->instructor_user_id . '"';
        $query .= 'WHERE id =  ' . intVal($id);
        return $this->db->query($query);
    }
    public function getByInstructerId($id) {
        $result = array(); // butsaah utga hadgalna
        $query = "SELECT TS.*, C.course_id, C.year as class_year, C.season_id, ";
        $query.= "Q.name AS course_name, Q.code AS course_code, ";
        $query.= "CT.name AS class_type_name, CR.name AS course_room_name ";
        $query.= "FROM teacher_schedule AS TS ";
        $query.= "INNER JOIN class AS C ON TS.class_id = C.id ";
        $query.= "INNER JOIN course AS Q ON C.course_id = Q.id ";
        $query.= "INNER JOIN class_type AS CT ON TS.class_type_id = CT.id ";
        $query.= "INNER JOIN user AS U ON TS.instructor_user_id = U.id ";
        $query.= "INNER JOIN class_room AS CR ON TS.class_room_id = CR.id ";
        $query.= "WHERE TS.instructor_user_id = " .  intVal($id);
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            $schedule = new stdClass();
            $schedule->id = $row->id;
            $schedule->week_day = $row->week_day;
            $schedule->par = $row->par;
            $schedule->class = new stdClass();
            $schedule->class->id = $row->class_id;
            $schedule->class->year = $row->class_year;
            $schedule->class->season = new stdClass();
            $schedule->class->season->id = $row->season_id;
            $schedule->class->course = new stdClass();
            $schedule->class->course->id = $row->course_id;
            $schedule->class->course->name = $row->course_name;
            $schedule->class->course->code = $row->course_code;
            $schedule->classRoom = new stdClass();
            $schedule->classRoom->id = $row->class_room_id;
            $schedule->classRoom->name = $row->class_room_name;
            $schedule->classType = new stdClass();
            $schedule->classType->id = $row->class_type_id;
            $schedule->classType->name = $row->class_type_name;
            $schedule->instructor_user_id = $row->instructor_user_id;
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $schedule;
        }
        return $result;
    }
}