<?php
require_once ROOT . '/model/Model.php';
class Level extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getAll() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM level'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function get($id) {
        $query = 'SELECT * FROM level WHERE id = ' . intVal($id); // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        if ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            return $row;
        }
        return null;
    }
    //Дараах код нь addlevel.php бүх утгыг нэмнэ
    public function add($level) {
        $query = 'INSERT INTO level (name, parent_id)';
        $query.= 'values ("' . $level->name;
        $query.= $level->parent > 0 ? '", "' .  $level->parent . '")':
            '", NULL)';
        return $this->db->query($query); // query ajilluulna
    }
    //Дараах код нь level.php бүх утгыг устгана
    public function remove($id) {
        $query = 'DELETE FROM level WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna
    }
    public function edit($id, $level){
        $query = 'UPDATE level SET ';
        $query.= 'name = "' . $level->name . '", parent_id = ';
        $query.= $level->parent > 0 ? '"' . $level->parent . '"':'NULL';
        $query.= ' WHERE id =  ' . intVal($id);
        return $this->db->query($query);
    }
}