<?php
require_once ROOT . '/controller/Controller.php';
require_once ROOT . '/model/todo/TodoTask.php';
class TodoTaskController extends Controller {
    public function __construct() {
		parent::__construct();
    }
	public function index() {
        $model = new TodoTask();
        $totalTasks = $model->getTotalTasks();
        $totalTodos = $model->getTotalTodos();
        $totalCategories = $model->getTotalCategories();
        $totalDoneTodos = $model->getTotalDoneTodos();
        $categories = $model->getAllCategories();
        $todos = $model->getAllTodos();
        require ROOT . '/view/todo/index.php';
    }
    public function addTask() {
        $model = new TodoTask();
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['taskName']) &&
                isset($_POST['priority']) &&
                isset($_POST['startDate']) &&
                isset($_POST['endDate']) &&
                isset($_POST['todoList']) &&
                isset($_POST['assignUser'])){
                $task = new stdClass();
                $task->name = $_POST['taskName'];
                $task->priority = $_POST['priority'];
                $task->start_date = $_POST['startDate'];
                $task->end_date = $_POST['endDate'];
                $task->todo_list_id = $_POST['todoList'];
                $task->user_id = $_POST['assignUser'];
                $task->created_user_id = 1;
                $result = $model->addTask($task);
                $this->index();
                if ($result > 0){
                    $message = 'Амжилттай нэмэгдлээ';
                }
            } else {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
        $totalTasks = $model->getTotalTasks();
        $totalTodos = $model->getTotalTodos();
        $totalCategories = $model->getTotalCategories();
        $totalDoneTodos = $model->getTotalDoneTodos();
        $todos = $model->getAllTodos();
        $users = $model->getAllUsers();
        $categories = $model->getAllCategories();
        require ROOT . '/view/todo/addTask.php';
    }
    public function edit($id)
    {
        $model = new TodoTask();
        $message = null;
        $tasks = $model->getTodoTask($id);
        $totalTasks = $model->getTotalTasks();
        $totalTodos = $model->getTotalTodos();
        $totalCategories = $model->getTotalCategories();
        $totalDoneTodos = $model->getTotalDoneTodos();
        $categories = $model->getAllCategories();
        $todos = $model->getAllTodos();
        $users = $model->getAllUsers();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['taskName']) &&
                isset($_POST['priority']) &&
                isset($_POST['startDate']) &&
                isset($_POST['endDate']) &&
                isset($_POST['todoList']) &&
                isset($_POST['assignUser'])){
                $task = new stdClass();
                $task->name = $_POST['taskName'];
                $task->priority = $_POST['priority'];
                $task->start_date = $_POST['startDate'];
                $task->end_date = $_POST['endDate'];
                $task->todo_list_id = $_POST['todoList'];
                $task->user_id = $_POST['assignUser'];
                $task->created_user_id = 1;
                $result = $model->edit($id, $task);
                $this->index();
                if ($result > 0){
                    $message = 'Амжилттай засагдлаа';
                }
            } else {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
        require ROOT . '/view/todo/editTask.php';
    }

    public function remove($id){
        $message = null;
        if ($id > 0) {
            $model = new TodoTask();
            $result = $model->remove($id);
            $this->index();
        }  
    }

    public function importantTask(){
        $model = new TodoTask();
        $totalTasks = $model->getTotalTasks();
        $totalTodos = $model->getTotalTodos();
        $totalCategories = $model->getTotalCategories();
        $totalDoneTodos = $model->getTotalDoneTodos();
        $categories = $model->getAllCategories();
        $todos = $model->getImportantTasks();
        require ROOT . '/view/todo/importantTask.php';
    }
    public function doneTasks()
    {
        $model = new TodoTask();
        $totalTasks = $model->getTotalTasks();
        $totalTodos = $model->getTotalTodos();
        $totalCategories = $model->getTotalCategories();
        $totalDoneTodos = $model->getTotalDoneTodos();
        $categories = $model->getAllCategories();
        $todos = $model->getDoneTasks();
        require ROOT . '/view/todo/doneTask.php';
    }
    public function doneTodoTask($id){
        $model = new TodoTask();
        $totalTasks = $model->getTotalTasks();
        $totalTodos = $model->getTotalTodos();
        $totalCategories = $model->getTotalCategories();
        $totalDoneTodos = $model->getTotalDoneTodos();
        $categories = $model->getAllCategories();
        $currentTime = date("Y-m-d h:i:sa");
        $doneTodos = $model->updateDoneTask($id, $currentTime);
        $todos = $model->getDoneTasks();
        require ROOT . '/view/todo/doneTask.php';
    }
}