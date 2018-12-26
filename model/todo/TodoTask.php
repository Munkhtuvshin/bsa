<?php
require_once ROOT . '/model/Model.php';
class TodoTask extends Model{
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
    public function getAllUsers(){
        $result = array(); // butsaah utga hadgalna
        $query = "SELECT * FROM user"; // select query
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
    public function getAllTodos() {
        $result = array(); // butsaah utga hadgalna
        $query = "SELECT todo_list.id, todo_list.created_user_id as tdUser, todo_list.todo_list_category_id, todo_list.name AS todoName, todo_list_category.name AS catName , todo_list_category.id as catId, todo_list_category.created_user_id as tcUser FROM todo_list INNER JOIN todo_list_category
        ON todo_list.todo_list_category_id=todo_list_category.id ORDER BY todo_list.id, todo_list.name"; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function getImportantTasks()
    {
        $result = array();
        $query = "SELECT t.id, t.priority, u.id AS uId, td.id AS tId, tdc.name as catName, td.name AS todoName, t.name AS taskName, t.start_date, t.end_date, u.username AS userName, cu.username AS createdUserName FROM task AS t INNER JOIN todo_list AS td ON t.todo_list_id = td.id INNER JOIN user AS u ON t.user_id = u.id INNER JOIN user AS cu ON t.created_user_id = cu.id INNER JOIN todo_list_category AS tdc ON td.todo_list_category_id = tdc.id";
        $res = $this->db->query($query);
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function updateDoneTask($id, $currentTime)
    {
        $query = 'UPDATE task SET ended_date="'.$currentTime.'" WHERE id=$id';
        return $this->db->query($query); // query ajilluulna
    }
    public function addTask($task) {
        $query = 'INSERT INTO task (name, priority, start_date, end_date, started_date, ended_date, todo_list_id, user_id, created_user_id)';
        $query .= 'values ("' . $task->name . '", "' . 
            $task->priority . '", "' . $task->start_date . '", "' . 
            $task->end_date . '" , NULL, NULL, "' . $task->todo_list_id . '", "' . 
            $task->user_id . '", "' . $task->created_user_id . '")';
        return $this->db->query($query); // query ajilluulna
    }
    public function getTodoTask($id)
    {
        $result = array();
        $query = "SELECT t.id, t.priority, u.id AS uId, td.id AS tId, td.name AS todoName, t.name AS taskName, t.start_date, t.end_date, u.username AS userName, cu.username AS createdUserName FROM task AS t INNER JOIN todo_list AS td ON t.todo_list_id = td.id INNER JOIN USER AS u ON t.user_id = u.id INNER JOIN USER AS cu ON t.created_user_id = cu.id WHERE t.id = $id";
        $res = $this->db->query($query);
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }

    public function getDoneTasks(){
        $result = array();
        $query = "SELECT t.id, t.priority, u.id AS uId, td.id AS tId, tdc.name as catName, td.name AS todoName, t.name AS taskName, t.start_date, t.end_date, t.ended_date, u.username AS userName, cu.username AS createdUserName FROM task AS t INNER JOIN todo_list AS td ON t.todo_list_id = td.id INNER JOIN user AS u ON t.user_id = u.id INNER JOIN user AS cu ON t.created_user_id = cu.id INNER JOIN todo_list_category AS tdc ON td.todo_list_category_id = tdc.id WHERE t.ended_date IS NOT NULL";
        $res = $this->db->query($query);
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }

    public function edit($id, $task) {
        $query = 'UPDATE task SET ';
        $query .= 'name = "' . $task->name . '",';
        $query .= 'priority = "' . $task->priority . '",';
        $query .= 'start_date = "' . $task->start_date . '",';
        $query .= 'end_date = "' . $task->end_date . '",';
        $query .= 'started_date = NULL,';
        $query .= 'ended_date = NULL,';
        $query .= 'todo_list_id = "' . $task->todo_list_id . '",';
        $query .= 'user_id = "' . $task->user_id . '",';
        $query .= 'created_user_id = "' . $task->created_user_id . '"';
        $query .= ' WHERE id = ' . intVal($id);
        return $this->db->query($query); // query ajilluulna
    }
    public function editTask($id) {
        $result = array();
        $query = 'UPDATE todo_list SET name="'. $todo->todoName .'",created_user_id="'.$todo->created_user_id.'",
        todo_list_category_id="'.$todo->catName.'" WHERE id=$id';
        $res = $this->db->query($query);
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    public function remove($id) {
        $query = "DELETE FROM task WHERE id=$id;";
        return $this->db->query($query); // query ajilluulna
    }
}