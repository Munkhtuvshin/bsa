<?php
require_once ROOT . '/model/Model.php';
class Comment extends Model {
    public function __construct() {
		parent::__construct();
    }
    
    function getAll(){
        $result = array();
        $query = "SELECT u.username, c.id as commentId, c.comment as comment  FROM comment AS c INNER JOIN user AS u ON c.user_id = u.id and c.parent_id is null ";
        $rows = $this->db->query($query);
        while($row = $rows->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }

    function add($comment,$user_id){
        $date = date('Y-m-d H:i:s');
        $u_id = intval($user_id);
        $query = "INSERT INTO comment (comment, `user_id`, created_date, table_id,table_pk ) values('$comment','$u_id','$date',1,1)";
        $result = $this->db->query($query);
        if(!$result){
            echo $this->db->error;
        }
        return $result;
    }
   
    function getComment($id){
        $result = array();
        $query = "SELECT c.id as commentId, u.username as username,u.id as userId FROM comment AS c INNER JOIN user AS u ON c.user_id = u.id where c.id = $id;";
        $rows = $this->db->query($query);
       
        while($row = $rows->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }
    function getReply($id){
        $result = array();
        $query = "SELECT c.id as commentId, u.username as username, c.comment as comment, u.id as userId FROM comment AS c INNER JOIN user AS u ON c.user_id = u.id where c.parent_id = $id";
        $rows = $this->db->query($query);
        while($row = $rows->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }
    function edit($id, $comment){
        // var_dump($id, $comment);
        $query = 'UPDATE `comment` SET ';
        $query .= 'comment ="'.$comment.'"';
        $query .= 'WHERE id = "'. $id.'";';
        $result = $this->db->query($query);
        if(!$result){
            echo $this->db->error;
        }
        return $result;
        // var_dump($result);
    }
   function remove($id){
        $query = "DELETE FROM comment WHERE id = " . $id;
        $result = $this->db->query($query);
        if(!$result){
            echo $this->db->error;
        }
        return $result;
    }
    function addReply($comment,$user_id, $parent_id){
        // var_dump($comment);
        $date = date('Y-m-d H:i:s');
        $u_id = intval($user_id);
        $query = "INSERT INTO comment (comment, `user_id`, created_date, parent_id, table_id,table_pk ) values('$comment','$u_id','$date','$parent_id',1,1)";
        $result = $this->db->query($query);
        if(!$result){
            echo $this->db->error;
        }
        return $result;
    }
   
}


