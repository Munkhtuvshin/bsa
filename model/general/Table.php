<?php
require_once ROOT . '/model/Model.php';
class Table extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getAll() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM `table`'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    //Дараах код нь addAddress.php бүх утгыг нэмнэ
    public function add($table) {
        $query = 'INSERT INTO `table` (name)';
        $query .= 'values ("' . $table->name . '")';
        return $this->db->query($query); // query ajilluulna
    }
    //Дараах код нь address.php бүх утгыг устгана
    public function remove($id) {
        $query = 'DELETE FROM `table` WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna
    }

    public function edit($id, $table){
        $query = 'UPDATE `table` SET ';
        $query .= 'name = "' . $table->name . '"';
        $query .= 'WHERE id =  ' . intVal($id);
        return $this->db->query($query);
    }

}