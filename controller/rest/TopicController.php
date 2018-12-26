<?php
require_once ROOT . '/model/exam/Topic.php';

class TopicController {
    
    public function course($courseId) {
        $model = new Topic();
        echo json_encode($model->getByCourseId($courseId), JSON_UNESCAPED_UNICODE);
    }
    
    public function questionCount($courseId) {
        $model = new Topic();
        echo json_encode($model->getQuestionCountByCourseId($courseId), JSON_UNESCAPED_UNICODE);
    }
}