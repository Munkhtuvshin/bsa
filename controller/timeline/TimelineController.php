<?php
require_once ROOT.'/model/user/user.php';

class TimelineController {
    public function index() {
        $model = new User();
        $page =$model-> getAll();
        require ROOT . '/view/timeline/profile.php';
    }

}