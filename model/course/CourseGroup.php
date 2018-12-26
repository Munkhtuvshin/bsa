<?php
require_once ROOT . '/model/Model.php';
class Coursegroup extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getAll() {
        $result = array(); // butsaah utga hadgalna
        $query = "SELECT teacher_schedule.*, class.year class, course.code course, season.name season, user.first_name user from teacher_schedule inner join class on class.id = teacher_schedule.class_id inner join course on course.id = class.course_id inner join season on season.id = class.season_id inner join user on user.id = teacher_schedule.instructor_user_id "; // select query

        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function get($id) {
        $query = 'SELECT * FROM teacher_schedule WHERE id = ' . intVal($id); // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        if ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            return $row;
        }
        return null;
    }
    public function add($group) {
        //$query = 'INSERT INTO teacher_schedule (course, class, season, user)';
        $query = "INSERT INTO teacher_schedule.(course, class, season, user), class.year class, course.code course, season.name season, user.first_name user from teacher_schedule inner join class on class.id = teacher_schedule.class_id inner join course on course.id = class.course_id inner join season on season.id = class.season_id inner join user on user.id = teacher_schedule.instructor_user_id "; // select query
        $query .= 'values ("' . $group->course . '", "' . 
            $group->class . '", "' . $group->season . '", "' . 
            $group->user . '")';
        return $this->db->query($query); // query ajilluulna
    }
    public function edit($id, $group){  
        $query = 'UPDATE teacher_schedule SET ';
        $query .= 'course = "' . $group->course . '",
                    class = "' . $group->class . '",
                    season = "' . $group->season . '",
                    user = "' . $group->user . '"';
        $query .= ' WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna  
    }
    public function remove($id) {
        $query = 'DELETE FROM teacher_schedule WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna
    }
}