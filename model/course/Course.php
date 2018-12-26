<?php
require_once ROOT . '/model/Model.php';
class Course extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getAll() {
        $result = array(); // butsaah utga hadgalna
        $query = "SELECT C.id as Cid, D.name AS DName, C.name AS name, C.name, C.code, C.credit, C.description, CT.name AS CTName FROM course AS C INNER JOIN division AS D ON C.division_id = D.id INNER JOIN course_type AS CT ON C.course_type_id = CT.id "; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function get($id) {
        $query = 'SELECT * FROM course WHERE id = ' . intVal($id); // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        if ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            return $row;
        }
        return null;
    }
    public function getAllCourse() {
        $result = array(); // butsaah utga hadgalna
        $query = "SELECT C.id as Cid, D.name AS DName, C.name AS name, C.name, C.code, C.credit, C.description, CT.name AS CTName FROM course AS C INNER JOIN division AS D ON C.division_id = D.id INNER JOIN course_type AS CT ON C.course_type_id = CT.id ";
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function getAllDivision() {
        $query = 'SELECT * FROM division'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        if ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            return $row;
        }
        return null;
    }
    public function getAllCourseType() {
        $query = 'SELECT * FROM course_type'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        if ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            return $row;
        }
        return null;
    }
    public function add($course) {
        $query = 'INSERT INTO course (name, code, credit, division_id, course_type_id, description)';
        $query .= 'values ("' . $course->name . '", "' . 
                                $course->code . '", "' .
                                $course->credit . '", "' .
                                $course->division . '", "' .  
                                $course->courseType . '", "' . 
                                $course->description . '")';
        return $this->db->query($query); // query ajilluulna
    }
    public function edit($id, $course){
        $query = 'UPDATE course SET ';
        $query .= 'name = "' . $course->name . '",
                    code = "' .$course->code . '",
                    credit = "' .$course->credit . '",
                    division_id = "' . $course->division_id . '",
                    course_type_id = "' .$course->division_type_id . '",
                    description = "' . $course->description . '"';
        $query .= 'WHERE id =  ' . intVal($id);
        return $this->db->query($query);
    }
    public function remove($id) {
        $query = 'DELETE FROM course WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna
    }
    public function getByInstructerId($id) {
        $query = 'SELECT DISTINCT course.* FROM course';
        $query.= ' JOIN class ON class.course_id = course.id';
        $query.= ' JOIN teacher_schedule ON teacher_schedule.class_id = class.id';
        $query.= ' WHERE teacher_schedule.instructor_user_id = ' . intVal($id); // select query
        $res = $this->db->query($query); // query ajilluulna
        $result = array(); // butsaah utga hadgalna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
}