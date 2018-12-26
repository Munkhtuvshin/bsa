<?php
require_once ROOT . '/controller/Controller.php';
require_once ROOT . '/model/todo/Todo.php';
class TodoController extends Controller {
    public function __construct() {
		parent::__construct();
    }
    public function index() {
        $model = new Todo();
        $categories = $model->getAllCategories();
        $todos = $model->getAllTodos();
        $totalTasks = $model->getTotalTasks();
        $totalTodos = $model->getTotalTodos();
        $totalCategories = $model->getTotalCategories();
        $totalDoneTodos = $model->getTotalDoneTodos();
        $totalCategories = $model->getTotalCategories();
        $totalDoneTodos = $model->getTotalDoneTodos();
        require ROOT . '/view/todo/dashboard.php';
    }
    public function getList() {
        $model = new Todo();
        $totalTasks = $model->getTotalTasks();
        $totalTodos = $model->getTotalTodos();
        $totalCategories = $model->getTotalCategories();
        $totalDoneTodos = $model->getTotalDoneTodos();
        $categories = $model->getAllCategories();
        $todos = $model->getAllTodos();
        require ROOT . '/view/todo/index.php';
    }
    public function addTodo() {
    	$model = new Todo();
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['todoName']) &&
                isset($_POST['catName'])){
                $todo = new stdClass();
                $todo->todoName = $_POST['todoName'];
                $todo->catName = $_POST['catName'];
                $todo->created_user_id = 1;
                $result = $model->addTodo($todo);
                $this->index();
                if ($result > 0){
                    $message = 'Амжилттай нэмэгдлээ';
                } else {
                    $message = 'Нэмж чадсангүй';
                }
            } else {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
        $totalTasks = $model->getTotalTasks();
        $totalTodos = $model->getTotalTodos();
        $totalCategories = $model->getTotalCategories();
        $totalDoneTodos = $model->getTotalDoneTodos();
        $categories = $model->getAllCategories();
        require ROOT . '/view/todo/addTdo.php';
    }

    public function getTodoList($id){
    	$model = new Todo();
    	$todos = $model->getTodoTask($id);
        $totalTasks = $model->getTotalTasks();
        $totalTodos = $model->getTotalTodos();
        $totalCategories = $model->getTotalCategories();
        $totalDoneTodos = $model->getTotalDoneTodos();
    	$categories = $model->getAllCategories();
        require ROOT . '/view/todo/getTodo.php';
    }

    public function edit($id)
    {
        $model = new Todo();
        $message = null;
        $todos = $model->getTodo($id);
        $totalTasks = $model->getTotalTasks();
        $totalTodos = $model->getTotalTodos();
        $totalCategories = $model->getTotalCategories();
        $totalDoneTodos = $model->getTotalDoneTodos();
        $categories = $model->getAllCategories();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['todoName']) &&
                isset($_POST['catName'])){
                $todo = new stdClass();
                $todo->todoName = $_POST['todoName'];
                $todo->catName = $_POST['catName'];
                $todo->created_user_id = 1;
                $result = $model->edit($id, $todo);
                $this->index();
                if ($result > 0){
                    $message = 'Амжилттай засагдлаа';
                } else {
                    $message = 'Засаж чадсангүй';
                }
            } else {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
        require ROOT . '/view/comment/editTodo.php';
    }

    public function remove($id)
    {
        if ($id > 0) {
            $model = new Todo();
            $result = $model->remove($id);
            $this->index();
        }  
    }
    
}