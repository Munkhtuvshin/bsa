<?php
require_once ROOT . '/model/Model.php';
class LessonPoint extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getAll() {
        $result = array(); // butsaah utga hadgalna
        #$query = 'SELECT * FROM lesson'; // select query
       $query = "SELECT LP.id as LPid, LP.start_date, LP.end_date, LP.point, L.subject AS Lsubject FROM lesson_point AS LP INNER JOIN 
    lesson AS L ON LP.lesson_id = L.id ";
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function getAllLessonPoint() {
        $result = array(); // butsaah utga hadgalna
        #$query = 'SELECT * FROM lesson'; // select query
        $query = "SELECT LP.id as LPid, LP.start_date, LP.end_date, LP.point, L.subject AS Lsubject FROM lesson_point AS LP INNER JOIN 
    lesson AS L ON LP.lesson_id = L.id ";
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
     public function get($id) {
        $query = 'SELECT * FROM lesson WHERE id = ' . intVal($id); // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        if ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            return $row;
        }
        return null;
    }
    public function add($lessonPoint) {
        $query = 'INSERT INTO lesson_point (start_date, end_date, point, lesson_id)';
        $query .= 'values ("' . $lessonPoint->start_date . '", "' . 
            $lessonPoint->end_date . '", "' . $lessonPoint->point . '", "' . 
            $lessonPoint->lesson_id . '")';
        return $this->db->query($query); // query ajilluulna
       
    }

    public function edit($id, $lessonPoint){
        $query = 'UPDATE lesson_point SET ';
        $query .= 'start_date = "' . $lessonPoint->start_date . '",
                    end_date = "' . $lessonPoint->end_date . '",
                    point = "' .$lessonPoint->point . '",
                    lesson_id = "' . $lessonPoint->lesson_id . '"';
        $query .= 'WHERE id =  ' . intVal($id);
        return $this->db->query($query);
    }


     public function remove($id) {
       $query = 'DELETE FROM lesson_point WHERE id = ' . intVal($id);
        #$query = "DELETE FROM lesson WHERE id ='".$_GET['id']."'";

        return $this->db->query($query); // query ajilluulna

        #header("Location: /view/lesson/index.php");
    }

    public function getAllLesson() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM lesson'; // select query
      
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    

}