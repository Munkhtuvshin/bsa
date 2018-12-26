<?php
require_once ROOT . '/model/Model.php';
class DivisionType extends Model{
    public function __construct() {
		parent::__construct();
    }
      public function getAll() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM division_type'; // select query
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
     public function getAllDivisionType() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM division_type'; // select query
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
     public function add($divisionType) {
        $query = 'INSERT INTO division_type (name)';
        $query .= 'values ("' . $divisionType->name . '")';
        return $this->db->query($query); // query ajilluulna
    }
//Дараах код нь address.php бүх утгыг устгана
       public function remove($id) {
       $query = 'DELETE FROM division_type WHERE id = ' . intVal($id);
        #$query = "DELETE FROM lesson WHERE id ='".$_GET['id']."'";

        return $this->db->query($query); // query ajilluulna

        #header("Location: /view/lesson/index.php");
    }

     public function edit($id, $divisionType){
        $query = 'UPDATE division_type SET ';
        $query .= 'name = "' . $divisionType->name . '"';
        $query .= 'WHERE id =  ' . intVal($id);
        return $this->db->query($query);
    }

}