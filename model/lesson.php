<?php
require_once ROOT . '/model/Model.php';
class Lesson extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getAll() {
        $result = array(); // butsaah utga hadgalna
        #$query = 'SELECT * FROM lesson'; // select query
       $query = "SELECT L.id as Lid, CT.name AS CTName, L.subject AS subject, L.description, C.year AS CYear FROM lesson AS L INNER JOIN 
    class_type AS CT ON L.class_type_id = CT.id INNER JOIN class AS C ON L.class_id = C.id ";
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function getAllLesson() {
        $result = array(); // butsaah utga hadgalna
        #$query = 'SELECT * FROM lesson'; // select query
       $query = "SELECT L.id as Lid, CT.name AS CTName, L.subject AS subject, L.description, C.year AS CYear FROM lesson AS L INNER JOIN 
    class_type AS CT ON L.class_type_id = CT.id INNER JOIN class AS C ON L.class_id = C.id ";
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
    public function add($lesson) {
        $query = 'INSERT INTO lesson (subject, description, class_type_id, class_id)';
        $query .= 'values ("' . $lesson->subject . '", "' . 
            $lesson->description . '", "' . $lesson->class_type_id . '", "' . 
            $lesson->class_id . '")';
        return $this->db->query($query); // query ajilluulna
       
    }

    public function edit($id, $lesson){
        $query = 'UPDATE lesson SET ';
        $query .= 'subject = "' . $lesson->subject . '",
                    description = "' . $lesson->description . '",
                    class_type_id = "' .$lesson->class_type_id . '",
                    class_id = "' . $lesson->class_id . '"';
        $query .= 'WHERE id =  ' . intVal($id);
        return $this->db->query($query);
    }


     public function remove($id) {
       $query = 'DELETE FROM lesson WHERE id = ' . intVal($id);
        #$query = "DELETE FROM lesson WHERE id ='".$_GET['id']."'";

        return $this->db->query($query); // query ajilluulna

        #header("Location: /view/lesson/index.php");
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
    

}