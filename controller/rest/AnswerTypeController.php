<?php
require_once ROOT . '/model/exam/AnswerType.php';

class AnswerTypeController {
    
    public function index() {
        $model = new AnswerType();
        $answerTypes = $model->getAll();
        echo json_encode($answerTypes, JSON_UNESCAPED_UNICODE);
    }
}