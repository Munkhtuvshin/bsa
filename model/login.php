<?php
require_once ROOT . '/model/Model.php';
class Login extends Model{
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

 
public function register($user) {
     
    $query = 'INSERT INTO user (username, password, first_name, last_name, user_type_id)';
    $query .= 'values ("' . $user->username . '", "' . 
        $user->password . '", "' . $user->first_name . '", "' . 
        $user->last_name . '", "' . $user->user_type_id . '")';
    return $this->db->query($query); // query ajilluulna
}

	public function logout(){
		
	}

    public function get($id) {
        
    }
    public function add($user) {

    }
    public function edit($id, $user) {

    }
    public function remove($id) {

    }
}
