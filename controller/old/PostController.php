<?php
require_once ROOT . '/model/Post.php';
class UserController {
    public function index() {
        $model = new User();
        $users = $model->getAll();
        require ROOT . '/view/Post/index.php';
    }
    public function add() {
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['username']) &&
                isset($_POST['password']) &&
                isset($_POST['first_name']) &&
                isset($_POST['middle_name']) &&
                isset($_POST['last_name']) &&
                isset($_POST['user_type_id']) &&
                isset($_POST['recovery_code'])){
                $model = new User();
                $user = new stdClass();
                $user->username = $_POST['username'];
                $user->password = $_POST['password'];
                $user->first_name = $_POST['first_name'];
                $user->middle_name = $_POST['middle_name'];
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
        require ROOT . '/view/Post/add.php';
    }
}