<?php
require_once ROOT . '/model/model.php';
class KreditLab extends Model {
    public function __construct() {
		parent::__construct();
    }
    function getAll(){
        $result = array();
        $query = "select  IF(id=1 ,\"2\",\"1\") AS s ".
        "from class_type ".
        "WHERE id='2';";
        $rows = $this->db->query($query);
        while($row = $rows->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }
    }