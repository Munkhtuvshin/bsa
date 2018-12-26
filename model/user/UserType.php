<?php
require_once ROOT . '/model/Model.php';
class UserType extends Model {
    public function __construct() {
		parent::__construct();
    }
    function getAll(){
        $result = array();
        $query = "SELECT * FROM user_type";
        $rows = $this->db->query($query);
        while($row = $rows->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }
    function add($name){
        $query = "INSERT INTO user_type (name) values(\"$name\")";
        $result = $this->db->query($query);
        if(!$result){
            echo $this->db->error;
        }
        return $result;
    }
    function getName($id){
        $query = "SELECT name FROM user_type WHERE id = " . $id;
        $rows = $this->db->query($query);
        if($row = $rows->fetch_object()){
            return $row->name;
        }
    }
    function edit($id, $name){
        $query = "UPDATE user_type SET name = \"$name\" WHERE id = " . $id;
        $result = $this->db->query($query);
        if(!$result){
            echo $this->db->error;
        }
        return $result;
    }
    function remove($id){
        $query = "DELETE FROM user_type WHERE id = " . $id;
        $result = $this->db->query($query);
        if(!$result){
            echo $this->db->error;
        }
        return $result;
    }
}