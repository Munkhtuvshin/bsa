<?php
require_once ROOT . '/model/lessonAdmin.php';
class LessonAdminController extends Controller {
    public function __construct() {
		parent::__construct();
    }
    public function index() {
        $model = new LessonAdmin();
        $teacher_schedules = $model->getAll();
        require ROOT . '/view/lessonAdmin/index.php';
    }
    public function getAllLessonAdmin(){
        $model = new  LessonAdmin();
        $teacher_schedules = $model->getAllLessonAdmin();
        #$categories = $model->getAllCategories();
        require ROOT . '/view/lessonAdmin/index.php';
    }


}