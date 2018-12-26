<?php
require_once ROOT.'/model/diploma/Diploma.php'; 

class StudentsController{
    function index(){
        $model = new Diploma();
        $page = $model->getAll();
        $title = 'Хамгаалагч оюутан';
        // var_dump($page);
        require ROOT . '/view/diploma/app-students.php';
    }
    function edit($id){
        $model = new Diploma();
        $title = 'Оюутны мэдээлэл засах';

        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $datas = $model->edit($id);
            require ROOT.'/view/diploma/app-students-edit.php';
        }
        else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $middle_name = $_POST['middle_name'];
            var_dump($middle_name);
            $last_name = $_POST['last_name'];
            $first_name = $_POST['first_name'];
            // $datas = 
            $datas = $model->editPost($id, $username, $middle_name, $last_name, $first_name);
            if($datas)
                header("location: /diploma/students");
            else
                echo('aldaa StudentsController.edit.post');
        }
        // require ROOT.'/view/diploma/app-students-edit.php';
    }
    function studentDetail($id){
        $model = new Diploma();
        $datas = $model->detail($id);
        $title = 'Оюутны мэдээлэл харах';
        require ROOT.'/view/diploma/app-student-detail.php';
    }
    function delete($id){
        $model = new Diploma();
        $datas = $model->delete($id);
        if($datas)
            header("location: /diploma/students");
        else
            echo("aldaa : student delete fucntion");
    }
}

?>