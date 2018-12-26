<?php
require_once ROOT . '/model/Model.php';
class Topic extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getAll() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM topic'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function get($id) {
        $query = 'SELECT * FROM topic WHERE id = ' . intVal($id); // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        if ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            return $row;
        }
        return null;
    }
    //Дараах код нь addcourse_topic.php бүх утгыг нэмнэ
    public function add($topic) {
        $query = 'INSERT INTO topic (name, parent_id)';
        $query.= 'values ("' . $topic->name;
        $query.= $topic->parent > 0 ? '", "' .  $topic->parent . '")':
            '", NULL)';
        return $this->db->query($query); // query ajilluulna
    }
    //Дараах код нь topic.php бүх утгыг устгана
    public function remove($id) {
        $query = 'DELETE FROM topic WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna
    }
    public function edit($id, $topic){
        $query = 'UPDATE topic SET ';
        $query.= 'name = "' . $topic->name . '", parent_id = ';
        $query.= $topic->parent > 0 ? '"' . $topic->parent . '"':'NULL';
        $query.= ' WHERE id =  ' . intVal($id);
        return $this->db->query($query);
    }
    public function getByCourseId($id) {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM topic WHERE course_id = ' . intVal($id); // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function getQuestionCountByCourseId($id) {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT Q.topic_id, Q.answer_type_id, Q.level_id, 
                count(*) AS question_count FROM question AS Q
            JOIN topic AS T on Q.topic_id = T.id
            WHERE T.course_id = ' . intVal($id) . '
            GROUP BY Q.topic_id, Q.answer_type_id, Q.level_id'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            if(!isset($result[$row->topic_id])) {
                $topic = array('count'=>$row->question_count,
                    'id'=>$row->topic_id,
                    'types'=>array(
                        $row->answer_type_id=>array('count'=>$row->question_count,
                            'id'=>$row->answer_type_id,
                            'levels'=>array(
                                $row->level_id=>array('count'=>$row->question_count,
                                    'id'=>$row->level_id)
                            )
                        )
                    )
                );
                $result[$row->topic_id] = $topic;
            } else if(!isset($result[$row->topic_id]['types'][$row->answer_type_id])) {
                $type = array('count'=>$row->question_count,
                    'id'=>$row->answer_type_id,
                    'levels'=>array(
                        $row->level_id=>array('id'=>$row->level_id,
                            'count'=>$row->question_count)
                    )
                );
                $result[$row->topic_id]['count']+=$row->question_count;
                $result[$row->topic_id]['types'][$row->answer_type_id] = $type;
            } else if(!isset($result[$row->topic_id]['types'][$row->answer_type_id]['levels'][$row->level_id])) {
                $result[$row->topic_id]['count']+=$row->question_count;
                $result[$row->topic_id]['types'][$row->answer_type_id]['count']+=$row->question_count;
                $result[$row->topic_id]['types'][$row->answer_type_id]['levels'][$row->level_id] = array(
                    'id'=>$row->level_id, 'count'=>$row->question_count);
            }
        }
        return $result;
    }
}