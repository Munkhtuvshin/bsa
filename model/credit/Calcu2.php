<?php
require_once ROOT . '/model/model.php';
class Calcu2 extends Model {
    public function __construct() {
		parent::__construct();
    }
    function getAll(){
        $result = array();
        $query = "select Date.id ,Date.lesson_date , IFNULL(SUM(Date.Duration), 0) AS lec, 
        IFNULL((select SUM(Date.Duration) from Date_view AS Date WHERE  lesson_date>='2018-01-30 08:00:00' AND lesson_date<='2018-01-30 11:20:00'
        group by class_type_id having class_type_id=2), 0) as lab, 
        IFNULL((select SUM(Date.Duration) from Date_view AS Date WHERE  lesson_date>='2018-01-30 08:00:00' AND lesson_date<='2018-01-30 11:20:00'
        group by class_type_id having class_type_id=3), 0) as sem,
        IFNULL((select SUM(Date.Duration) from Date_view AS Date WHERE  lesson_date>='2018-01-30 08:00:00' AND lesson_date<='2018-01-30 11:20:00'
        group by class_type_id having class_type_id=4), 0) as bd
        from  Date_view AS Date
        WHERE  lesson_date>='2018-01-30 08:00:00' AND lesson_date<='2018-01-30 11:20:00'
        group by class_type_id
        having class_type_id=1;
        ";
        $rows = $this->db->query($query);
        while($row = $rows->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }
    }