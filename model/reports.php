<?php
require_once ROOT . '/model/Model.php';
class Reports extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getAll() {
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
    public function get($id) {
        
    }
    public function report($report) {
        $query = 'INSERT INTO report (reported_date, description , report_reason_id, reported_by, user_id)';
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