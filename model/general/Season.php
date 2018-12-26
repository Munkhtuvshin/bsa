<?php
require_once ROOT . '/model/Model.php';
class Season extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getAll() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM season'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    //Дараах код нь addAddress.php бүх утгыг нэмнэ
    public function add($season) {
        $query = 'INSERT INTO season (name)';
        $query .= 'values ("' . $season->name .'")';
        return $this->db->query($query); // query ajilluulna
    }
    //Дараах код нь address.php бүх утгыг устгана
    public function remove($id) {
        $query = 'DELETE FROM season WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna
    }

    public function edit($id, $season){
        $query = 'UPDATE season SET ';
        $query .= 'name = "' . $season->name . '"';
        $query .= 'WHERE id =  ' . intVal($id);
        return $this->db->query($query);
    }

}