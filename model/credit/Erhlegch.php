<?php
require_once ROOT . '/model/model.php';
class Erhlegch extends Model {
    public function __construct() {
		parent::__construct();
    }
    function getAll(){
        $result = array();
        $query = "SELECT vertical_table_status.id, vertical_table.instructor_user_id ,vertical_table.checked_user_id,vertical_table_status_id,vertical_table_status.name
        FROM vertical_table 
       Inner Join vertical_table_status ON vertical_table.vertical_table_status_id=vertical_table_status.id
       WHERE vertical_table_status.id='3';";
        $rows = $this->db->query($query);
        while($row = $rows->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }
    function get($id){
        $query = "SELECT * FROM eschool.vertical_table; WHERE id = " . $id;
        $rows = $this->db->query($query);
        if($row = $rows->fetch_object()){
            return $row;
        }
    }
}