<?php
require_once ROOT . '/model/Model.php';
class Admin extends Model{
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
        $result = array();
        $query = 'SELECT * FROM user WHERE id = ' . intVal($id); // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        if ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function index($id) {
        $result = array(); // butsaah utga hadgalna
        $query = "SELECT user_detail.id, user.id as uid , user_field.id as ufi, user_field.name ,user_detail.value FROM `user_detail` INNER JOIN user ON user_detail.user_id = user.id INNER JOIN user_field ON user_detail.user_field_id = user_field.id WHERE user_id = " . intVal($id); // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    
    public function add($user) {
        $query = 'INSERT INTO user (username, password, first_name, last_name, user_type_id, recovery_code)';
        $query .= 'values ("' . $user->username . '", "' . 
            $user->password . '", "' . $user->first_name . '", "' . 
            $user->last_name . '", "' . $user->user_type_id . '", 
            "'. $user->recovery_code . '")';
        return $this->db->query($query); // query ajilluulna
    }
    public function reportAll() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM report'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function blockAll() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM block'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function report($report) {
        $query = 'INSERT INTO report (reported_date, description, report_reason_id, reported_by, user_id)';
        $query .= 'values ("' . $report->reported_date . '", "' . 
            $report->description . '", "' . $report->report_reason_id . '", "' . 
            $report->reported_by . '", "' . $report->user_id . '")';
        return $this->db->query($query); // query ajilluulna
    }
    
    public function block($block) {
        $query = 'INSERT INTO block (user_id, report_reason_id, blocked_date, unblocked_date, parameter
        )';
        $query .= 'values ("' . $block->user_id . '", "' . 
            $block->report_reason_id . '", "' . $block->blocked_date . '", "' . 
            $block->unblocked_date . '", "' . $block->unblock_type_id . '", "' . $block->parameter
            . '")';
        return $this->db->query($query); // query ajilluulna
    }

    public function edit($id, $user) {

    }
    public function remove($id) {
        $query = 'DELETE FROM user WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna
    }
    
   
}