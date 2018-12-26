<?php
// Модел классаа оруулж ирнэ
require_once ROOT . '/model/example/UserType.php';
class HelloController{
    // route: /example/hello
    function index() {
        // Модел классын обьектыг үүсгэнэ
        $model = new UserType();
        // Модел классыг ашиглан өгөгдөл ачаална
        $userTypes = $model->getAll();
        // Загвар ашиглан өгөгдлөө хэвлэнэ
        require ROOT.'/view/example/index.php';
    }
    // route: /example/hello/add
    function add() {
        if($_SERVER['REQUEST_METHOD']=='GET'){
            // Мэдээлэл оруулах хуудас харуулна
            require ROOT.'/view/example/add.php';
        } else if($_SERVER['REQUEST_METHOD']=='POST'){
            // Өгөгдлийн санд шинэ мэдээлэл оруулна
            // Модел классын обьектыг үүсгэнэ
            $model = new UserType();
            // Модел классыг ашиглан өгөгдөл ачаална
            $result = $model->add($_POST["name"]);
            if($result) {
                header('location: /example/hello');
            }
        } else {
            echo "wrong request";
        }
    }
    // route: /example/hello/edit/[id]
    function edit($id) {
        // Модел классын обьектыг үүсгэнэ
        $model = new UserType();
        if($_SERVER['REQUEST_METHOD']=='GET'){
            $name = $model->getName($id);
            // Мэдээлэл оруулах хуудас харуулна
            require ROOT.'/view/example/edit.php';
        } else if($_SERVER['REQUEST_METHOD']=='POST'){
            // Өгөгдлийн санд шинэ мэдээлэл оруулна
            // Модел классыг ашиглан өгөгдөл ачаална
            $result = $model->edit($id, $_POST["name"]);
            if($result) {
                header('location: /example/hello');
            }
        } else {
            echo "wrong request";
        }
    }
    // route: /example/hello/remove/[id]
    function remove($id) {
        // Модел классын обьектыг үүсгэнэ
        $model = new UserType();
        if($_SERVER['REQUEST_METHOD']=='POST'){
            // Өгөгдлийн санд шинэ мэдээлэл оруулна
            // Модел классыг ашиглан өгөгдөл ачаална
            $result = $model->remove($id);
            if($result) {
                header('location: /example/hello');
            }
        } else {
            echo "wrong request";
        }
    }
}