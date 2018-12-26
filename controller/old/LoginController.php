<?php
require_once ROOT . '/model/login.php';   
class LoginController {
    public function index() {
        $model = new Login();
        $users = $model->getAll();
        $edit_state = false;
        require ROOT . '/view/login/index.php';
    }
   
    public function register() {
        $model = new Login();
        $message = null;
        $users = $model->getAll();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['first_name']) &&
                isset($_POST['last_name']) &&
                isset($_POST['username']) &&
                isset($_POST['password']) &&
                isset($_POST['user_type_id'])){
                $user = new stdClass();
                $user->first_name = $_POST['first_name'];
                $user->last_name = $_POST['last_name'];
                $user->username = $_POST['username'];
                $user->password = $_POST['password'];
                $user->user_type_id = $_POST['user_type_id'];
                $result = $model->register($user);
                if ($result > 0){
                    
                    $message = 'Амжилттай бүртгэгдлээ';
                    
                } else {
                    $message = 'Бүртгэж чадсангүй';
                }
            } else {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
        require ROOT . '/view/login/register.php';
    }  
}
    ?>