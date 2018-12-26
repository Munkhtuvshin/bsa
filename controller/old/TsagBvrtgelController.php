<?php
require_once ROOT . '/model/TsagBvrtgel.php';
class TsagBvrtgelController {
    public function index() {
        $model = new TsagBvrtgel();
        $teacherTsag = $model->getAll();
        require ROOT . '/view/TsagBvrtgel/index.php';
    }
    public function tsagDetail(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['id']) && isset($_POST['name'])){
                $id = $_POST['id'];
                $name = $_POST['name'];
                $code = $_POST['code'];
                $model = new TsagBvrtgel();
                $teacherTsag = $model->getOne($id);
            }
        }
        require ROOT . '/view/TsagBvrtgel/tsagDetail.php';
    }
}