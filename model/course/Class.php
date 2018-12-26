<?php
require_once ROOT . '/model/Model.php';
class CourseClass extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getAll() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM class'; // select query
       #$query = "SELECT C.id as Cid, D.name AS DName, C.name AS name, C.code, C.credit, CT.name AS CTName FROM course AS C INNER JOIN 
    #division AS D ON C.division_id = D.id INNER JOIN course_type AS CT ON C.course_type_id = CT.id ";
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
     public function getAllClass() {
        $result = array(); // butsaah utga hadgalna
        #$query = 'SELECT * FROM course'; // select query
         $query = "SELECT C.id as Cid, CO.name AS COName, SE.name AS SEName, C.year FROM class AS C INNER JOIN course AS CO ON C.course_id = CO.id INNER JOIN season AS SE ON C.season_id = SE.id ";
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }

     public function getAllCourse() {
        $query = 'SELECT * FROM course'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        if ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            return $row;
        }
        return null;
    }

     public function getAllSeason() {
        $query = 'SELECT * FROM season'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        if ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            return $row;
        }
        return null;
    }
    public function add($class) {
        $query = 'INSERT INTO course (year, course_id, season_id)';
        $query .= 'values ("' . $class->year . '", "' . 
                                $class->course_id . '", "' .
                                $class->season_id . '")';
        return $this->db->query($query); // query ajilluulna
       
    }

    public function edit($id, $class){
        $query = 'UPDATE class SET ';
        $query .= 'year = "' . $class->year . '",
                    course_id = "' .$class->course_id . '",
                    season_id = "' .$class->season_id . '"';
        $query .= 'WHERE id =  ' . intVal($id);
        return $this->db->query($query);
    }


     public function remove($id) {
       $query = 'DELETE FROM class WHERE id = ' . intVal($id);
        #$query = "DELETE FROM lesson WHERE id ='".$_GET['id']."'";

        return $this->db->query($query); // query ajilluulna

        #header("Location: /view/lesson/index.php");
    }

}