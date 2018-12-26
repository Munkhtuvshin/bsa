<?php
require_once ROOT.'/model/diploma/Diploma.php'; 

class TeachersController{
    function index(){
        $model = new Diploma();
        $page = $model->getAll();
        $title = 'Диплом удирдагч багш';
        // var_dump($page);
        require ROOT . '/view/diploma/app-teacher.php';
    }
}

?>