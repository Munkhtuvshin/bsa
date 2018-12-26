<?php
require_once ROOT . '/model/PostType.php';
class PostTypeController {
    public function index() {
        $model = new PostType();
        $postTypes = $model->getAll();
        require ROOT . '/view/PostType/index.php';
    }
    public function add() {
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['name'])){
                $model = new PostType();
                $postType = new stdClass();
                $postType->name = $_POST['name'];
                $result = $model->add($postType);
                if ($result > 0){
                    $message = 'Амжилттай нэмэгдлээ';
                } else {
                    $message = 'Нэмж чадсангүй';
                }
            } else {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
        require ROOT . '/view/PostType/add.php';
    }
    public function edit($id) {
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['name'])){
                $model = new PostType();
                $postType = new stdClass();
                $postType->name = $_POST['name'];
                $result = $model->edit($id, $postType);
                if ($result > 0){
                    $message = 'Амжилттай нэмэгдлээ';
                } else {
                    $message = 'Нэмж чадсангүй';
                }
            } else {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
        require ROOT . '/view/PostType/add.php';
    }
    public function remove($id) {
        $message = null;
        if ($id > 0) {
            $model = new PostType();
            $result = $model->remove($id);
            $this->index();
        }   
    }
}