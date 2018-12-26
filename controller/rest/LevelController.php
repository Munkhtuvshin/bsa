<?php
require_once ROOT . '/model/exam/Level.php';

class LevelController {
    
    public function index() {
        $model = new Level();
        echo json_encode($model->getAll(), JSON_UNESCAPED_UNICODE);
    }
}