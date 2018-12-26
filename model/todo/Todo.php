<?php
require_once ROOT . '/model/Model.php';
class Todo extends Model{
    public function __construct() {
		parent::__construct();
    }
    public function getAllTodos() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT todo_list.id, todo_list.created_user_id as tdUser, todo_list.todo_list_category_id, todo_list.name AS todoName, todo_list_category.name AS catName , todo_list_category.id as catId, todo_list_category.created_user_id as tcUser FROM todo_list INNER JOIN todo_list_category
        ON todo_list.todo_list_category_id=todo_list_category.id ORDER BY todo_list.id, todo_list.name'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
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
    public function addTodo($todo) {
        $query = 'INSERT INTO todo_list (name, created_user_id, todo_list_category_id)';
        $query .= 'values ("' . $todo->todoName . '", "' . 
            $todo->created_user_id . '", "' . $todo->catName . '")';
        return $this->db->query($query); // query ajilluulna
    }
    public function getTodoTask($id)
    {
        $result = array();
        $query = "SELECT t.id, td.name AS todoName, t.name AS taskName, t.start_date, t.end_date, t.ended_date, u.username AS userName, cu.username AS createdUserName FROM task AS t INNER JOIN todo_list AS td ON t.todo_list_id = td.id INNER JOIN USER AS u ON t.user_id = u.id INNER JOIN USER AS cu ON t.created_user_id = cu.id WHERE t.todo_list_id = $id AND t.ended_date IS NULL";
        $res = $this->db->query($query);
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function getTodo($id)
    {
        $result = array();
        $query = "SELECT todo_list.id, todo_list.created_user_id as tdUser, todo_list.todo_list_category_id, todo_list.name 
        AS todoName, todo_list_category.name AS catName , todo_list_category.id AS catId, todo_list_category.created_user_id AS tcUser 
        FROM todo_list INNER JOIN todo_list_category
        ON todo_list.todo_list_category_id=todo_list_category.id WHERE todo_list.id = $id"; // select query
        $res = $this->db->query($query);
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function edit($id, $todo) {
        $query = 'UPDATE todo_list SET ';
        $query .= 'name = "' . $todo->todoName . '",';
        $query .= 'created_user_id = "' . $todo->created_user_id . '",';
        $query .= 'todo_list_category_id = "' . $todo->catName . '"';
        $query .= ' WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna
    }
    public function remove($id) {
        $query = 'DELETE FROM todo_list WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna
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
    // public function getDoneTasks()
    // {
    //     $result = array();
    //     $query = "";
    //     $res = $this->db->query($query);
    //     // irsen ugugdluudiig mur muruur n unshij avna
    //     while ($row = $res->fetch_object()) {
    //         // tuhain mur ugugdliig butsaah utgad nemne
    //         $result[] = $row;
    //     }
    //     return $result;
    // }
}
