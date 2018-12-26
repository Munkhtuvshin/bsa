<?php
require_once ROOT . '/model/model.php';
class Negtgel2 extends Model {
    public function __construct() {
		parent::__construct();
    }
    function getAll(){
        $result = array();
        $query = "select id , 8 AS namar , 8 as havar ,1 as e,2 as es ,1.05 as i, 3.6 as n 
        from season
        Where id='1'";
        $rows = $this->db->query($query);
        while($row = $rows->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }
}