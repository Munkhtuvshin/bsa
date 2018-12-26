<?php
require_once ROOT . '/model/user/User.php';
require_once ROOT . '/model/course/CourseClass.php';

class CourseClassController {
    
    public function my() {
        $model = new CourseClass();
        $me = User::getMe();
        echo json_encode($model->getByInstructerId($me->id), JSON_UNESCAPED_UNICODE);
    }
}