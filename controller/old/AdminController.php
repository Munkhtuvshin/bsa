<?php
require_once ROOT . '/model/admin.php';
class AdminController {
    public function index() {
        $model = new Admin();
        $users = $model->getAll();
        require ROOT . '/view/admin/index.php';
    }
    public function report() {
        $model = new Admin();
        $reports = $model->reportAll();
        require ROOT . '/view/admin/report.php';
    }
    
    public function block() {
        $model = new Admin();
        $blocks = $model->blockAll();
        require ROOT . '/view/admin/block.php';
    }
    public function add() {
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['username']) &&
                isset($_POST['password']) &&
                isset($_POST['first_name']) &&
                isset($_POST['last_name']) &&
                isset($_POST['user_type_id']) &&
                isset($_POST['recovery_code'])){
                $model = new Admin();
                $user = new stdClass();
                $user->username = $_POST['username'];
                $user->password = $_POST['password'];
                $user->first_name = $_POST['first_name'];
                $user->last_name = $_POST['last_name'];
                $user->user_type_id = $_POST['user_type_id'];
                $user->recovery_code = $_POST['recovery_code'];
                $result = $model->add($user);
                if ($result > 0){
                    $message = 'Амжилттай нэмэгдлээ';
                } else {
                    $message = 'Нэмж чадсангүй';
                }
            } else {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
        require ROOT . '/view/admin/add.php';
    }
    public function remove($id) {
        $message = null;
        if ($id > 0) {
            $model = new Admin();
            $result = $model->remove($id);
            $this->index();
        }   
    }
 
}