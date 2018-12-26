<?php
require_once ROOT . '/model/Model.php';
class Tailan extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getAll() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT COUNT(id) FROM course'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function get($id) {

    }
    public function add($user) {
        $query = 'INSERT INTO user (username, first_name, last_name, middle_name)';
        $query .= 'values ("' . $user->username . '",  "' . $user->first_name . '", "' . 
            $user->last_name . '", "' . $user->middle_name . '")';
        return $this->db->query($query); // query ajilluulna
    }
    public function edit($id, $user) {
        $query = 'UPDATE user SET ';
        $query .= 'username = "' . $user->username . '",
                    first_name = "' . $user->first_name . '",
                    last_name = "' . $user->last_name . '",
                    middle_name = "' . $user->middle_name . '"';
        $query .= ' WHERE id = ' . intVal($id);
        return $this->db->query($query);

    }
    public function remove($id) {
        $query = 'DELETE FROM user WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna
    }
}