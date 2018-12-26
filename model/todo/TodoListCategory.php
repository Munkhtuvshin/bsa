<?php
require_once ROOT . '/model/Model.php';
class TodoListCategory extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getAllCategories(){
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
    public function getTotalTasks()
    {
        $result = array();
        $query = "SELECT count(id) AS totalTask FROM task";
        $res = $this->db->query($query);
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function getTotalTodos()
    {
        $result = array();
        $query = "SELECT count(id) AS totalTodo FROM todo_list";
        $res = $this->db->query($query);
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function getTotalCategories()
    {
        $result = array();
        $query = "SELECT count(id) AS totalCategory FROM todo_list_category";
        $res = $this->db->query($query);
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function getTotalDoneTodos()
    {
        $result = array();
        $query = "SELECT count(id) AS totalDoneTodo FROM task WHERE ended_date is NOT NULL";
        $res = $this->db->query($query);
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function getCategory($id)
    {
        $result = array(); // butsaah utga hadgalna
        $query = "SELECT * FROM todo_list_category WHERE id = $id"; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function addCat($category) {
        $query = 'INSERT INTO todo_list_category (name, created_user_id)';
        $query .= 'values ("' . $category->catName . '", "' . 
            $category->created_user_id . '")';
        return $this->db->query($query); // query ajilluulna
    }
    public function edit($id, $category) {
        $query = 'UPDATE todo_list_category SET ';
        $query .= 'name = "' . $category->name . '",';
        $query .= 'created_user_id = "' . $category->created_user_id . '"';
        $query .= ' WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna
    }
    public function remove($id) {
        $query = 'DELETE FROM todo_list_category WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna
    }
}