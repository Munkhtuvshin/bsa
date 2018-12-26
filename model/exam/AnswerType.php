<?php
require_once ROOT . '/model/Model.php';
class AnswerType extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getAll() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM answer_type'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function get($id) {
        $query = 'SELECT * FROM answer_type WHERE id = ' . intVal($id); // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        if ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            return $row;
        }
        return null;
    }
    //Дараах код нь addanswer_type.php бүх утгыг нэмнэ
    public function add($answer_type) {
        $query = 'INSERT INTO answer_type (name)';
        $query.= 'values ("' . $this->db->escape_string($answer_type->name) . '")';
        return $this->db->query($query); // query ajilluulna
    }
    //Дараах код нь answer_type.php бүх утгыг устгана
    public function remove($id) {
        $query = 'DELETE FROM answer_type WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna
    }
    public function edit($id, $answer_type){
        $query = 'UPDATE answer_type SET ';
        $query.= 'name = "' . $answer_type->name . '"';
        $query.= ' WHERE id =  ' . intVal($id);
        return $this->db->query($query);
    }
}