<?php
    class school_user {
        public $id;
        public $school_id;
        public $school_user_type_id;
    }
require_once ROOT . '/model/Model.php';
class Group extends Model {
    public function __construct() {
		parent::__construct();
    }
    function getUserSchool($id){
        $query1 = "SELECT u.id, su.school_id, su.school_user_type_id, su.profession_class_id FROM eschool.user as u 
        INNER JOIN eschool.school_user as su ON u.id = su.user_id
        WHERE u.id=$id limit 1";
        $rows = $this->db->query($query1);
        if($row = $rows->fetch_object()){
            return $row;
        }
    }

    function getUserSchoolGroup($id){
        $result = array();        
        $query = "SELECT g.id, g.table_id, g.table_pk, g.params, s.name, s.description FROM eschool.group as g
        INNER JOIN eschool.school as s
        ON g.table_pk = s.id 
        WHERE g.table_id = 1 AND g.table_pk = $id;";
        $school = $this->db->query($query);
        while($s = $school->fetch_object()){
            $result[] = $s;
        }
        return $result;
    }

    function getUserProfessionGroup($id){
        $result = array();
        $query = "SELECT g.id, g.table_id, g.table_pk, g.params, pc.start_date, p.name
        FROM eschool.group as g INNER JOIN eschool.profession_class as pc
        ON g.table_pk = pc.id INNER JOIN eschool.profession as p ON pc.profession_id = p.id
        WHERE g.table_id = 2 AND g.table_pk = $id;";

        $rows = $this->db->query($query);
        while($row = $rows->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }

    function getSchoolGroup(){
        $result = array();
        $query = "SELECT g.id, g.table_id, g.table_pk, g.params, s.name, s.description FROM eschool.group as g
        INNER JOIN eschool.school as s
        ON g.table_pk = s.id 
        WHERE g.table_id = 1;";
        $rows = $this->db->query($query);
        while($row = $rows->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }
    function getProfessionGroup(){
        $result = array();
        $query = "SELECT g.id, g.table_id, g.table_pk, g.params, pc.start_date, p.name
        FROM eschool.group as g INNER JOIN eschool.profession_class as pc
        ON g.table_pk = pc.id INNER JOIN eschool.profession as p ON pc.profession_id = p.id
        WHERE g.table_id = 2 ;";
        $rows = $this->db->query($query);
        while($row = $rows->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }
    function getSchoolUser($id){
        $result = array();
        $query = "SELECT * FROM school_user as su INNER JOIN user as u ON su.user_id = u.id
        WHERE school_id=$id";
        $rows = $this->db->query($query);
        while($row = $rows->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }
    
    function getProfessionUser($id){
        $result = array();
        $query = "SELECT * FROM eschool.school_user as su INNER JOIN eschool.user as u ON su.user_id = u.id
        WHERE su.profession_class_id IS NOT NULL AND su.profession_class_id = $id;";
        $rows = $this->db->query($query);
        while($row = $rows->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }
   
    function getName($id){
        $query = "SELECT name FROM eschool.table
        WHERE id = $id; ";
        $result = $this->db->query($query);
        return $result;
    }
   

    function getAll($id, $pk){
        // $table = $this->getName($id)->name;
        if($id == 1){
            $table = 'school';
            $query = "SELECT g.id, g.table_id, g.table_pk, g.params, s.name, s.description FROM eschool.group as g
            INNER JOIN eschool.$table as s
            ON g.table_pk = s.id 
            WHERE s.id = $pk and g.table_id = $id;";
        }else if($id == 2){
            $table = 'profession_class';
            $query = "SELECT g.id, g.table_id, g.table_pk, g.params, pc.start_date, p.name
            FROM eschool.group as g INNER JOIN eschool.profession_class as pc
            ON g.table_pk = pc.id INNER JOIN eschool.profession as p ON pc.profession_id = p.id
            WHERE pc.id = $pk and g.table_id = $id ;";
        }else if($id == 3){
            $table = 'lesson';
            $query = "SELECT * FROM eschool.group as g
            INNER JOIN eschool.$table as s
            ON g.table_pk = s.id 
            WHERE s.id = $pk and g.table_id = $id;";
        }
        $result = array();
        
        $rows = $this->db->query($query);
        while($row = $rows->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }

    function edit($id, $path){
        $query = "UPDATE eschool.group SET params='$path' WHERE id=$id;";
        // $res = $this->db->query($query);
        return $this->db->query($query); // query ajilluulna
    }
}
