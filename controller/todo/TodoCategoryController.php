<?php
require_once ROOT . '/model/todo/TodoListCategory.php';
class TodoCategoryController extends Controller {
    public function __construct() {
		parent::__construct();
    }
	public function index() {
        $model = new TodoListCategory();
        $totalTasks = $model->getTotalTasks();
        $totalTodos = $model->getTotalTodos();
        $totalCategories = $model->getTotalCategories();
        $totalDoneTodos = $model->getTotalDoneTodos();
        $categories = $model->getAllCategories();
        require ROOT . '/view/todo/addCategory.php';
    }

    public function addCategory() {
    	$model = new TodoListCategory();
        $message = null;
        $totalTasks = $model->getTotalTasks();
        $totalTodos = $model->getTotalTodos();
        $totalCategories = $model->getTotalCategories();
        $totalDoneTodos = $model->getTotalDoneTodos();
        $categories = $model->getAllCategories();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['todoCatName'])){
                $category = new stdClass();
                $category->catName = $_POST['todoCatName'];
                $category->created_user_id = 1;
                $result = $model->addCat($category);
                $this->index();
                if ($result > 0){
                    $message = 'Амжилттай нэмэгдлээ';
                }
            } else {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
        
        require ROOT . '/view/todo/addCategory.php';
    }
    public function edit($id)
    {
        $model = new TodoListCategory();
        $message = null;
        $totalTasks = $model->getTotalTasks();
        $totalTodos = $model->getTotalTodos();
        $totalCategories = $model->getTotalCategories();
        $totalDoneTodos = $model->getTotalDoneTodos();
        $getCategories = $model->getCategory($id);
        $categories = $model->getAllCategories();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['todoCatName'])){
                $category = new stdClass();
                $category->name = $_POST['todoCatName'];
                $category->created_user_id = 1;
                $result = $model->edit($id, $category);
                $this->index();
                if ($result > 0){
                    $message = 'Амжилттай нэмэгдлээ';
                }
            } else {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
        
        require ROOT . '/view/todo/editCategory.php';
    }
    public function remove($id)
    {
        if ($id > 0) {
            $model = new TodoListCategory();
            $result = $model->remove($id);
            $this->index();
        }  
    }
}