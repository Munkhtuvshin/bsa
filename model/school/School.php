<?php
require_once ROOT . '/model/Model.php';
class School extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getAll() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM school'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    function get($id){
        $query = "SELECT * FROM school WHERE id = " . $id;
        $rows = $this->db->query($query);
        if($row = $rows->fetch_object()){
            return $row;
        }
    }
    //Дараах код нь бүх утгыг нэмнэ
    public function add($school) {
        $query = 'INSERT INTO school (name, description, address, parent_id, address_id, creator)';
        $query .= 'values ("' . $school->schoolName . '", ';
        $query .= isset($school->description) ? '"' .  $school->description . '", ' : 'NULL, ';
        $query .= isset($school->address) ? '"' . $school->address . '", ' : 'NULL, ';
        $query .= $school->parent > 0 ? $school->parent .', ' : 'NULL, ';
        $query .= $school->address_id > 0 ? $school->address_id .', ' : 'NULL, ';
        $query .= User::getMe();
        return $this->db->query($query); // query ajilluulna
    }

    //Дараах код нь address.php бүх утгыг устгана
    public function remove($id) {
       $query = 'DELETE FROM school WHERE id = ' . intVal($id);
        #$query = "DELETE FROM lesson WHERE id ='".$_GET['id']."'";

        return $this->db->query($query); // query ajilluulna

        #header("Location: /view/lesson/index.php");
    }

    public function edit($id, $school){
        $query = 'UPDATE school SET ';
        $query .= 'name = "' . $school->schoolName . '",
                    description = "' . $school->description . '",
                    address = "' . $school->address . '",
                    parent_id = "' . $school->parent . '",
                    address_id = "' . $school->address_id . '"';
        $query .= 'WHERE id =  ' . intVal($id);
        return $this->db->query($query);
    }

    public function getAllAddress() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM address'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }

}