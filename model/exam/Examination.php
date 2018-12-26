<?php
require_once ROOT . '/model/Model.php';
class Examination extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getAll() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM examination'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function get($id) {
        $query = 'SELECT * FROM examination WHERE id = ' . intVal($id); // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        if ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            return $row;
        }
        return null;
    }
    //Дараах код нь addquestion.php бүх утгыг нэмнэ
    public function add($examination) {
        $query = 'INSERT INTO examination (examination, answer, parent_id, level_id, topic_id, hint, answer_type_id)';
        $query.= 'values ("' . $this->db->escape_string($examination->examination) . '"';
        $query.= ',"' . $this->db->escape_string(json_encode($examination->answer, JSON_UNESCAPED_UNICODE)) . '"';
        $query.= $examination->parent_id > 0 ? ', ' .  intVal($examination->parent) : ', NULL';
        $query.= ',' . intVal($examination->level_id);
        $query.= ',' . intVal($examination->topic_id);
        $query.= ',' . intVal($examination->hint);
        $query.= ',' . intVal($examination->type_id);
        $query.= ')';
        return $this->db->query($query); // query ajilluulna
    }
    //Дараах код нь examination.php бүх утгыг устгана
    public function remove($id) {
        $query = 'DELETE FROM examination WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna
    }
    public function edit($id, $examination){
        $query = 'UPDATE examination SET ';
        $query.= 'name = "' . $examination->name . '", parent_id = ';
        $query.= $examination->parent > 0 ? '"' . $examination->parent . '"':'NULL';
        $query.= ' WHERE id =  ' . intVal($id);
        return $this->db->query($query);
    }
}