<?php
require_once ROOT . '/model/Model.php';
class Question extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getAll() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM question'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function get($id) {
        $query = 'SELECT * FROM question WHERE id = ' . intVal($id); // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        if ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            return $row;
        }
        return null;
    }
    //Дараах код нь addquestion.php бүх утгыг нэмнэ
    public function add($question) {
        $query = 'INSERT INTO question (question, answer, parent_id, level_id, topic_id, hint, answer_type_id)';
        $query.= 'values ("' . $this->db->escape_string($question->question) . '"';
        $query.= ',"' . $this->db->escape_string(json_encode($question->answer, JSON_UNESCAPED_UNICODE)) . '"';
        $query.= $question->parent_id > 0 ? ', ' .  intVal($question->parent) : ', NULL';
        $query.= ',' . intVal($question->level_id);
        $query.= ',' . intVal($question->topic_id);
        $query.= ',' . intVal($question->hint);
        $query.= ',' . intVal($question->type_id);
        $query.= ')';
        return $this->db->query($query); // query ajilluulna
    }
    //Дараах код нь question.php бүх утгыг устгана
    public function remove($id) {
        $query = 'DELETE FROM question WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna
    }
    public function edit($id, $question){
        $query = 'UPDATE question SET ';
        $query.= 'name = "' . $question->name . '", parent_id = ';
        $query.= $question->parent > 0 ? '"' . $question->parent . '"':'NULL';
        $query.= ' WHERE id =  ' . intVal($id);
        return $this->db->query($query);
    }
    public function getByTopicId($id, $page = 0, $count = 50) {
        $rows = array(); // butsaah utga hadgalna
        $query = 'SELECT Q.*, L.name AS level_name, 
                T.name AS answer_type_name
            FROM question AS Q
            LEFT JOIN `level` AS L on Q.level_id = L.id
            LEFT JOIN answer_type AS T on Q.answer_type_id = T.id 
            WHERE topic_id = ' . intVal($id); // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            $question = new stdClass();
            $question->id = $row->id;
            $question->question = $row->question;
            $question->answer = json_decode($row->answer);
            $question->parent_id = $row->parent_id;
            $question->topic = new stdClass();
            $question->topic->id = $row->topic_id;
            $question->level = new stdClass();
            $question->level->id = $row->level_id;
            $question->level->name = $row->level_name;
            $question->answerType = new stdClass();
            $question->answerType->id = $row->answer_type_id;
            $question->answerType->name = $row->answer_type_name;
            // tuhain mur ugugdliig butsaah utgad nemne
            $rows[] = $question;
        }
        $query = 'SELECT count(*) AS total FROM question WHERE topic_id = ' . intVal($id); // select query
        $res = $this->db->query($query); // query ajilluulna
        $total = $res->fetch_object()->total;
        $result = new stdClass();
        $result->content = $rows;
        $result->page = $page;
        $result->count = $count;
        $result->total = $total;
        return $result;
    }
}