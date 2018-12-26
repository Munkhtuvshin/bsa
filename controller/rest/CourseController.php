<?php
require_once ROOT . '/model/user/User.php';
require_once ROOT . '/model/course/Course.php';

class CourseController {
    
    public function my() {
        $model = new Course();
        $me = User::getMe();
        echo json_encode($model->getByInstructerId($me->id), JSON_UNESCAPED_UNICODE);
    }
}