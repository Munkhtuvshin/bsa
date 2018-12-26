<?php
require_once ROOT . '/model/schedule/TeacherSchedule.php';

class TeacherScheduleController {
    
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
            $model = new TeacherSchedule();
            $schedule = json_decode($request_body);
            $result->result = $model->add($schedule);
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    private function remove() {
        $result = new stdClass();
        $request_body = file_get_contents('php://input');
        if($request_body) {
            $model = new TeacherSchedule();
            $schedule = json_decode($request_body);
            $result->result = $model->remove($schedule->id);
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    private function edit() {
        $result = new stdClass();
        $request_body = file_get_contents('php://input');
        if($request_body) {
            $model = new TeacherSchedule();
            $schedule = json_decode($request_body);
            $result->result = $model->edit($schedule->id, $schedule);
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
    public function my() {
        $model = new TeacherSchedule();
        $me = User::getMe();
        echo json_encode($model->getByInstructerId($me->id), JSON_UNESCAPED_UNICODE);
    }
}