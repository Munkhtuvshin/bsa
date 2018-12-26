<?php
require_once ROOT . '/model/model.php';
class Calcu extends Model {
    public function __construct() {
		parent::__construct();
    }
    function getAll(){
        $result = array();
        $query = "select name ,code,credit
        from course
        WHERE id=5;
        ";
        $rows = $this->db->query($query);
        while($row = $rows->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }
    }