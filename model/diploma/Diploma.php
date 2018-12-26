<?php 
require_once ROOT . '/model/Model.php';
class Diploma extends Model{
    public function __construct(){
        parent::__construct();
    }
    function getAll(){
        $result = array();
        $query = 'select * from user as u inner join user_detail as ud on ud.user_id = u.id  ;';
        $res = $this->db->query($query);
        while($row = $res->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }
    function edit($id){
        $result = array();
        $query = 'SELECT * FROM user WHERE id = '.$id;
        $res = $this->db->query($query);
        while($row = $res->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }
    function editPost($id, $username, $middle_name, $last_name, $first_name){
        $result = array();
        var_dump($middle_name);
        $query = "UPDATE user SET username=\"$username\", middle_name=\"$middle_name\", last_name=\"$last_name\", first_name=\"$first_name\" where id=".$id;
        $result = $this->db->query($query);
        if(!$result){
            echo $this->db->error;
        }
        return $result;
    }
    function detail($id){
        $result = array();
        $query = 'SELECT * FROM user WHERE id = '.$id;
        $res = $this->db->query($query);
        while($row = $res->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }
    function delete($id){
        $result = array();
        $query = 'DELETE FROM user where id='.$id;
        $result = $this->db->query($query);
        if(!$result){
            echo $this->db->error;
        }
        return $result;
    }
}
?>