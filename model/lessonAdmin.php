<?php
require_once ROOT . '/model/Model.php';
class LessonAdmin extends Model{
    public function __construct() {
		parent::__construct();
    }
      public function getAll() {
         $result = array(); // butsaah utga hadgalna
        #$query = 'SELECT * FROM teacher_schedule'; // select query
        $query = "SELECT TS.id AS TSid, TS.week_day, TS.par,  C.year AS CYear, CT.name AS CTName, U.username AS UName, CR.name AS CRName 
        FROM teacher_schedule AS TS INNER JOIN class AS C ON TS.class_id = C.id INNER JOIN class_type AS CT ON TS.class_type_id = CT.id INNER JOIN user AS U ON TS.instructor_user_id = U.id INNER JOIN class_room AS CR ON TS.class_room_id = CR.id ";
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function getAllLessonAdmin() {
        $result = array(); // butsaah utga hadgalna
        #$query = 'SELECT * FROM teacher_schedule'; // select query
        $query = "SELECT TS.id AS TSid, TS.week_day, TS.par,  C.year AS CYear, CT.name AS CTName, U.username AS UName, CR.name AS CRName 
        FROM teacher_schedule AS TS INNER JOIN class AS C ON TS.class_id = C.id INNER JOIN class_type AS CT ON TS.class_type_id = CT.id INNER JOIN user AS U ON TS.instructor_user_id = U.id INNER JOIN class_room AS CR ON TS.class_room_id = CR.id ";
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
   
}

