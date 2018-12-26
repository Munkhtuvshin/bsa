<?php
require_once ROOT . '/model/Model.php';
class Address extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getAll() {
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
    public function get($id) {
        $query = 'SELECT * FROM address WHERE id = ' . intVal($id); // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        if ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            return $row;
        }
        return null;
    }
    //Дараах код нь addAddress.php бүх утгыг нэмнэ
    public function add($address) {
        $query = 'INSERT INTO address (name, parent_id)';
        $query.= 'values ("' . $address->name;
        $query.= $address->parent > 0 ? '", "' .  $address->parent . '")':
            '", NULL)';
        return $this->db->query($query); // query ajilluulna
    }
    //Дараах код нь address.php бүх утгыг устгана
    public function remove($id) {
        $query = 'DELETE FROM address WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna
    }
    public function edit($id, $address){
        $query = 'UPDATE address SET ';
        $query.= 'name = "' . $address->name . '", parent_id = ';
        $query.= $address->parent > 0 ? '"' . $address->parent . '"':'NULL';
        $query.= ' WHERE id =  ' . intVal($id);
        return $this->db->query($query);
    }
}