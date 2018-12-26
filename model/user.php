<?php
require_once ROOT . '/model/Model.php';
class User extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getAll() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM user'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function get($id) {

    }
    public function add($user) {
        $query = 'INSERT INTO user (username, password, first_name, last_name, middle_name, user_type_id, recovery_code)';
        $query .= 'values ("' . $user->username . '", "' . 
            $user->password . '", "' . $user->first_name . '", "' . 
            $user->last_name . '", "' . $user->middle_name . '", "' . 
            $user->user_type_id . '", "' . $user->recovery_code . '")';
        return $this->db->query($query); // query ajilluulna
    }
    public function report($report) {
        $query = 'INSERT INTO report (reported_date, description, report_reason_id, reported_by, user_id)';
        $query .= 'values ("' . $report->reported_date . '", "' . 
            $report->description . '", "' . $report->report_reason_id . '", "' . 
            $report->reported_by . '", "' . $report->user_id . '")';
        return $this->db->query($query); // query ajilluulna
    }
    public function edit($id, $user) {

    }
    public function remove($id) {

    }
}