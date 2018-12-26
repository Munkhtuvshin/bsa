<?php
require_once ROOT . '/model/model.php';
class Calcu1 extends Model {
    public function __construct() {
		parent::__construct();
    }
    function getAll(){
        $result = array();
        $query = " select * from Date_view
        where id='1';";
        $rows = $this->db->query($query);
        while($row = $rows->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }
    }