<?php
require_once ROOT . '/model/model.php';
class Season extends Model {
    public function __construct() {
		parent::__construct();
    }
    function getAll(){
        $result = array();
        $query = "select id , 8 AS namar , 8 as havar
        from season
        Where id='1'
        ";
        $rows = $this->db->query($query);
        while($row = $rows->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }
    }