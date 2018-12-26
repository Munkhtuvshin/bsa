<?php
require_once ROOT . '/model/Model.php';
class Category extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getAll() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM todo_list_category'; // select query
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
    // public function add($catName) {
    //     $stmt = $this->conn->prepare("INSERT INTO `todo_list_category` (`name, created_user_id`) VALUES (?,?)") or die($this->conn->error);
    //     $stmt->bind_param("ss",$catName);
    //     if($stmt->execute()){
    //         $stmt->close();
    //         $this->conn->close();
    //         return true;
    //     }
    // }

    public function edit($id, $category) {

    }
    public function remove($id) {

    }
}