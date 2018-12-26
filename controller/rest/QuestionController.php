<?php
require_once ROOT . '/model/exam/Question.php';

class QuestionController {
    
    public function index() {
        switch($_SERVER['REQUEST_METHOD']) {
            case 'POST': $this->add(); break;
            case 'PUT': $this->edit(); break;
            case 'DELETE': $this->remove(); break;
        }
    }
    private function add() {
        $result = new stdClass();
        $request_body = file_get_contents('php://input');
        if($request_body) {
            $model = new Question();
            $question = json_decode($request_body);
            $result->result = $model->add($question);
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    private function remove() {
        $result = new stdClass();
        $request_body = file_get_contents('php://input');
        if($request_body) {
            $model = new Question();
            $question = json_decode($request_body);
            $result->result = $model->remove($question->id);
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    private function edit() {
        $result = new stdClass();
        $request_body = file_get_contents('php://input');
        if($request_body) {
            $model = new Question();
            $question = json_decode($request_body);
            $result->result = $model->edit($question->id, $question);
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    public function topic($id) {
        $model = new Question();
        $result = $model->getByTopicId($id);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}