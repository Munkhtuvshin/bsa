<?php
require_once ROOT . '/model/Model.php';
class CourseType extends Model{
    public function __construct() {
        parent::__construct();
    }
      public function getAll() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM course_type'; // select query
       # $query = "SELECT l.id as Lid, CT.name AS CTName, L.subject AS subject, L.description, C.year AS CYear FROM lesson AS L INNER JOIN 
    #class_type AS CT ON L.class_type_id = CT.id INNER JOIN class AS C ON L.class_id = C.id ";
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
//Дараах код нь address.php дээрх бүх утгыг харуулна
     public function getAllCourseType() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM course_type'; // select query
       # $query = "SELECT l.id as Lid, CT.name AS CTName, L.subject AS subject, L.description, C.year AS CYear FROM lesson AS L INNER JOIN 
    #class_type AS CT ON L.class_type_id = CT.id INNER JOIN class AS C ON L.class_id = C.id ";
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
//Дараах код нь addAddress.php бүх утгыг нэмнэ
     public function add($courseType) {
        $query = 'INSERT INTO course_type (name)';
        $query .= 'values ("' . $courseType->name .'")';
        return $this->db->query($query); // query ajilluulna
    }
//Дараах код нь address.php бүх утгыг устгана
       public function remove($id) {
       $query = 'DELETE FROM course_type WHERE id = ' . intVal($id);
        #$query = "DELETE FROM lesson WHERE id ='".$_GET['id']."'";

        return $this->db->query($query); // query ajilluulna

        #header("Location: /view/lesson/index.php");
    }

     public function edit($id, $courseType){
        $query = 'UPDATE course_type SET ';
        $query .= 'name = "' . $courseType->name . '"';
        $query .= 'WHERE id =  ' . intVal($id);
        return $this->db->query($query);
    }

}