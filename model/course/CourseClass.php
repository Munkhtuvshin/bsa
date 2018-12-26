<?php
require_once ROOT . '/model/Model.php';
class Courseclass extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getAll() {
        $result = array(); // butsaah utga hadgalna
        //$query = 'SELECT * FROM class'; // select query
        $query = 'SELECT class.*, course.name course, season.name season from class inner join course on course.id = class.course_id inner join season on season.id = class.season_id';
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function get($id) {
        $query = 'SELECT class.*, course.name course, season.name season from class inner join course on course.id = class.course_id inner join season on season.id = class.season_id WHERE id = ' . intVal($id); // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        if ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            return $row;
        }
        return null;
    }
    public function add($class) {
        //$query = 'INSERT INTO class.*,course.name course, season.name season from class inner join course on course.id = class.course_id inner join season on season.id = class.season_id';
        $query = 'INSERT INTO class (course_id, year, season_id)';
        $query .= 'values ("' . $class->course_id . '", "' . 
            $class->year . '", "' . $class->season_id .'")';
        return $this->db->query($query); // query ajilluulna
    }
    public function edit($id, $class){  
        $query = 'UPDATE class SET ';
        $query .= 'course_id = "' . $class->course_id . '",
                    year = "' . $class->year . '",
                    season_id = "' . $class->season_id . '"';
        $query .= ' WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna  
    }
    public function remove($id) {
        $query = 'DELETE FROM class WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna
    }
}