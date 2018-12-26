<?php
require_once ROOT . '/model/user/User.php';
require_once ROOT . '/controller/user/Mail/Mail.php';

class MeController {
    
    public function index() {
        $me = User::getMe();
        $data = new stdClass();
        if ($me) {
            $data->id = intVal($me->id);
            $data->userName = $me->username;
            $data->firstName = $me->first_name;
            $data->lastName = $me->last_name;
            $data->middleName = $me->middle_name;
            $data->userTypeId = intVal($me->user_type_id);
        } else {
            $data->id = -1;
            $data->userTypeId = -1;
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}