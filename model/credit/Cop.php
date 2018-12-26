<?php
require_once ROOT . '/model/model.php';
class Cop extends Model {
    public function __construct() {
		parent::__construct();
    }
    function getAll(){
        $result = array();
        $query = " SELECT IF(SUBSTRING(code, 5, 1)=3,\"1.2\",\"Less\")  AS m".
        " FROM course " .
        " WHERE id='5';";
        $rows = $this->db->query($query);
        while($row = $rows->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }
    }