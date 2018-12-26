<?php
require_once ROOT . '/model/Model.php';
class classRoom extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getBySchoolId($school_id) {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM class_room WHERE school_id = ' . intVal($school_id); // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    //Дараах код нь addAddress.php бүх утгыг нэмнэ
    public function add($classRoom) {
        $query = 'INSERT INTO class_room (name, floor, capacity, school_id)';
        $query .= 'values ("' . $classRoom->name . '", "' . $classRoom->floor . '", "' . $classRoom->capacity . '", "' .  $classRoom->school_id . '")';
        return $this->db->query($query); // query ajilluulna
    }
    //Дараах код нь address.php бүх утгыг устгана
    public function remove($id) {
        $query = 'DELETE FROM class_room WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna
    }
    public function edit($id, $classRoom){
        $query = 'UPDATE class_room SET';
        $query .= ' name = "' . $classRoom->name . '",
                    floor= "' . $classRoom->floor . '",
                    capacity = ' . intVal($classRoom->capacity) . ',
                    school_id = ' . intVal($classRoom->school_id);
        $query .= ' WHERE id =  ' . intVal($id);
        return $this->db->query($query);
    }
}