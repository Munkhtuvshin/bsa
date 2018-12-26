<?php 
    require_once ROOT.'/model/adviser/Adviser.php';
    class StudentController {
        function index(){
             require ROOT.'/view/adviser/addStudent.php';
        }
        public function add(){
            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                // $model = new Adviser();
                // $datas = $model->useDatas();
                $title = 'Оюутан нэмэх';
                require ROOT.'/view/adviser/addStudent.php';
            }
            else if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $results = array();
                $model = new Adviser();
                $results = $model->add($_POST['username'], 
                    $_POST['password'], 
                    // $_POST['password_again'], 
                    $_POST['first_name'],
                    $_POST['middle_name'],
                    $_POST['last_name'],
                    $_POST['type'],
                    $_POST['recovery_code'],
                    $_POST['birthday'],
                    $_POST['family_type'],
                    $_POST['phone'],
                    $_POST['email'],                    
                    $_POST['address'],
                    $_POST['worship'],
                    $_POST['language'],
                    $_POST['sex'],
                    $_FILES['profile_photo'],
                    $_FILES['cover_photo']
                );
                
                if(!$results){
                    echo 'adviser.studentController.aldaa';
                }
                // var_dump($results);
                 header("location: /adviser/adviser");
            }
        }
        function delete($id){
            $results = array();
            $model = new Adviser();
            $results = $model->remove($id);
            
            if(!$results){
                echo 'adviser.studentController.aldaa';
            }
            header("location: /adviser/adviser");
        }
        function edit($id){
            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                $title = 'Оюутны мэдээлэл засах';
                $model = new Adviser();
                $result = $model->get($id);
                // var_dump($result);
                require ROOT.'/view/adviser/editStudent.php';
            }
            else if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $results = array();
                $model = new Adviser();
                $delete = $model->remove($id);
                $results = $model->add($_POST['username'], 
                    $_POST['password'], 
                    // $_POST['password_again'], 
                    $_POST['first_name'],
                    $_POST['middle_name'],
                    $_POST['last_name'],
                    $_POST['type'],
                    $_POST['recovery_code'],
                    $_POST['birthday'],
                    $_POST['family_type'],
                    $_POST['phone'],
                    $_POST['email'],                    
                    $_POST['address'],
                    $_POST['worship'],
                    $_POST['language'],
                    $_POST['sex'],
                    $_FILES['profile_photo'],
                    $_FILES['cover_photo']
                );
                
                if(!$results){
                    echo 'adviser.studentController.aldaa';
                }
                // var_dump($results);
                 header("location: /adviser/adviser");
            }
        }
    }
?>