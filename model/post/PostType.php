<?php
require_once ROOT . '/model/Model.php';
class PostType extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getAll() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM post_type'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function get($id) {
        $query = 'SELECT * FROM post_type WHERE id = ' . intVal($id); // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        if ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            return $row;
        }
        return null;
    }
    public function add($postType) {
        $query = 'INSERT INTO post_type (name)';
        $query .= 'values ("' . $postType->name . '")';
        return $this->db->query($query); // query ajilluulna
    }
    public function edit($id, $postType) {
        $query = 'UPDATE post_type SET ';
        $query .= 'name = "' . $postType->name . '"';
        $query .= ' WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna
    }
    public function remove($id) {
        $query = 'DELETE FROM post_type WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna
    }
}