<?php
require_once ROOT . '/model/Model.php';
class Par extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getBySchoolId($school_id) {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM par WHERE school_id = ' . intVal($school_id); // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    //Дараах код нь address.php дээрх бүх утгыг харуулна
    public function getAllPar() {
        $result = array(); // butsaah utga hadgalna
        $query = "SELECT P.id as Pid, P.start_time, P.end_time , S.name AS Sname FROM par AS P INNER JOIN 
            school AS S ON P.school_id = S.id; ";
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    //Дараах код нь addAddress.php бүх утгыг нэмнэ
    public function add($par) {
        $query = 'INSERT INTO par (school_id, id, start_time, end_time)';
        $query .= 'values ("' . $par->school . '", "'. $par->id .'", ' .  $par->start_time . '" , "'. $par->end_time . '")';
        return $this->db->query($query); // query ajilluulna
    }
    //Дараах код нь address.php бүх утгыг устгана
    public function remove($id) {
        $query = 'DELETE FROM par WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna
    }

    public function edit($id, $par){
        $query = 'UPDATE par SET ';
        $query .= 'school_id = "' . $par->school . '",
                    start_time = "' . $par->start_time . '",
                    end_time ="' . $par->end_time .'"';
        $query .= 'WHERE id =  ' . intVal($id);
        return $this->db->query($query);
    }

    public function getAllSchool() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM school'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }

}