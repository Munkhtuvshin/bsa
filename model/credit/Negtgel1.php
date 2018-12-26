<?php
require_once ROOT . '/model/model.php';
class Negtgel1 extends Model {
    public function __construct() {
		parent::__construct();
    }
    function getAll(){
        $result = array();
        $query = "SELECT division.name AS SA,course.code, course.name AS CO
        from division
        INNER JOIN course ON division.id=course.division_id
        WHERE division.id='2' and course.id='5' ";
        $rows = $this->db->query($query);
        while($row = $rows->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }
}