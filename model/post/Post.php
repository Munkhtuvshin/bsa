<?php
require_once ROOT . '/model/Model.php';
class Post extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getAll() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM post'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function get($id) {
        $query = 'SELECT * FROM post WHERE id = ' . intVal($id); // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        if ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            return $row;
        }
        return null;
    }
    public function add($post) {
        $query = 'INSERT INTO post (description, created_date, created_user_id, owner_type_id, owner_id, post_type_id)';
        $query .= 'values ("' . $post->description . '", "' . 
            $post->created_date . '", ' . intVal($post->created_user_id) . ', ' . 
            intVal($post->owner_type_id) . ', ' . intVal($post->owner_id) . ', ' . 
            intVal($post->post_type_id) . ')';
        return $this->db->query($query); // query ajilluulna
    }
    public function edit($id, $post) {
        $query = 'UPDATE post SET ';
        $query .= 'description = "' . $post->description . '",';
        $query .= 'created_date = "' . $post->created_date . '",';
        $query .= 'created_user_id = ' . intVal($post->created_user_id) . ',';
        $query .= 'owner_type_id = ' . intVal($post->owner_type_id) . ',';
        $query .= 'owner_id = ' . intVal($post->owner_id) . ',';
        $query .= 'post_type_id = ' . intVal($post->post_type_id);
        $query .= ' WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna
    }
    public function remove($id) {
        $query = 'DELETE post WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna
    }
}