<?php
require_once ROOT.'/model/diploma/Diploma.php'; 
class ViewController{
    function index(){
        $model = new Diploma();
        $page = $model->getAll();
        $title = 'Үзлэгийн хуваарь';
        require ROOT . '/view/diploma/app-view.php';
    }
    function sedev(){
        $title = 'Сэдэв';
        require ROOT . '/view/diploma/uzleg/sedev.php';
    }
    function view1(){
        $title = 'Үзлэг 1';
        require ROOT . '/view/diploma/uzleg/uzleg.php';
    }
    function view2(){
        $title = 'Үзлэг 2';
        require ROOT . '/view/diploma/uzleg/uzleg.php';
    }
    function view3(){
        $title = 'Үзлэг 3';
        require ROOT . '/view/diploma/uzleg/uzleg.php';
    }
    function uridchilsan(){
        $title = 'Урьдчилсан хамгаалалт';
        require ROOT . '/view/diploma/uzleg/uridchilsan.php';
    }
    function jinhene(){
        $title = 'Жинхэнэ хамгаалалт';
        require ROOT . '/view/diploma/uzleg/jinhene.php';
    }
}

?>