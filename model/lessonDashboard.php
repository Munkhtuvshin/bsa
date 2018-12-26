<?php
require_once ROOT . '/model/Model.php';
class LessonDashboard extends Model{
    public function __construct() {
		parent::__construct();
    }
      public function getAllLessonDashboard() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM user'; // select query
       # select user.id, user.first_name, (select count(id) from file where user_id = user.id) as file, (select count(id) from event where club_id = club.id) as event from club order by  event desc,news desc;
            #select club.id, club.name, (select count(id) from news where club_id = club.id) as news, (select count(id) from event where club_id = club.id) as event from club order by  event desc,news desc;
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
     public function getAllUser() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM user'; // select query
       # $query = "SELECT l.id as Lid, CT.name AS CTName, L.subject AS subject, L.description, C.year AS CYear FROM lesson AS L INNER JOIN 
    #class_type AS CT ON L.class_type_id = CT.id INNER JOIN class AS C ON L.class_id = C.id ";
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function getAllFile() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM file'; // select query
       # $query = "SELECT l.id as Lid, CT.name AS CTName, L.subject AS subject, L.description, C.year AS CYear FROM lesson AS L INNER JOIN 
    #class_type AS CT ON L.class_type_id = CT.id INNER JOIN class AS C ON L.class_id = C.id ";
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
}