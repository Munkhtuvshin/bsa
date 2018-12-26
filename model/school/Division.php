<?php
require_once ROOT . '/model/Model.php';
class Division extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getBySchoolId($school_id) {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM division ';
        $query.= 'WHERE school_id = ' . intVal($school_id); // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function get($id) {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM division ';
        $query.= 'WHERE id = ' . intVal($id); // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        if ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            return $row;
        }
    }
    public function add($division) {
        $query = 'INSERT INTO division (name, description, division_type_id, school_id, parent_id)';
        $query .= 'values ("' . $division->name . '", "';
        $query .= $division->description . '", ';
        $query .= $division->division_type_id . ', ';
        $query .= $division->school_id . ', ';
        $query .= $division->parent_id > 0 ? $division->parent_id . ')':
            'NULL)';
        return $this->db->query($query); // query ajilluulna
    }
    public function edit($id, $division){
        $query = 'UPDATE division SET ';
        $query .= 'name = "' . $division->name . '",
                    description = "' . $division->description . '",
                    division_type_id = ' .$division->division_type_id . ',
                    school_id = ' .$division->school_id;
        $query .= $division->parent_id > 0 ? ', parent_id = ' . $division->parent_id : '';
        $query .= ' WHERE id =  ' . intVal($id);
        return $this->db->query($query);
    }
    public function remove($id) {
        $query = 'DELETE FROM division WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna
    }
}