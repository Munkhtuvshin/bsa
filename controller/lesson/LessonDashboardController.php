<?php
require_once ROOT . '/controller/Controller.php';
require_once ROOT . '/model/lessonDashboard.php';
class LessonDashboardController extends Controller {
    public function __construct() {
		parent::__construct();
    }
    public function index() {
        $model = new LessonDashboard();
        $lessonDashboards = $model->getAllLessonDashboard();
         $users = $model->getAllUser();
        $files = $model->getAllFile();
        require ROOT . '/view/lessonAdmin/lessonDashboard.php';
    }

      public function getAllLessonDashboard(){
        $model = new  LessonDashboard();
        $lessonDashboards = $model->getAllLessonDashboard();
        $users = $model->getAllUser();
        $files = $model->getAllFile();
        #$categories = $model->getAllCategories();
        require ROOT . '/view/lessonAdmin/lessonDashboard.php';
    }
}
