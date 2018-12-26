<?php
require_once ROOT . '/model/adviser/Adviser.php';
class AdviserController  {
    public function index() {
        $model = new Adviser();
        $results = $model->getall();
        require ROOT . '/view/adviser/home.php';
    }
}
