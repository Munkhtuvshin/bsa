<?php
require_once ROOT . '/controller/Controller.php';
require_once ROOT . '/model/group/Group.php';
require_once ROOT . '/model/user/User.php';

class GroupController extends Controller{
    public function __construct() {
		parent::__construct();
    }
    public function index() {
        $model = new Group();
        // $schools = $model->loadUser();
        // echo $schools;

        $userModel = new User();
        $user = $userModel->getMe();
        if($user->user_type_id == '1'){
            $s_user = $model->getUserSchool($user->id);
            // var_dump($s_user);
            $schools = $model->getUserSchoolGroup($s_user->school_id);
            foreach ($schools as $s) { 
                $cover = json_decode($s->params);
                $s->params = $cover;
            }
            if($s_user->profession_class_id != null){
            var_dump($s_user);   
                $professions = $model->getUserProfessionGroup($s_user->profession_class_id);
                foreach($professions as $p) { 
                    $cover = json_decode($p->params);
                    $p->params = $cover;
                }
            }

            require ROOT . '/view/group/list.php';
        }else{
             $schools = $model->getSchoolGroup();
            foreach ($schools as $s) { 
                $cover = json_decode($s->params);
                $s->params = $cover;
            }
            $professions = $model->getProfessionGroup();
            foreach($professions as $p) { 
                $cover = json_decode($p->params);
                $p->params = $cover;
            }         
            require ROOT . '/view/group/list.php';
        }
        
       
    }
    public function discussion($content_type_id, $content_id) {
        switch ($content_type_id) {
            case 1: // surguuliin group
                $title = $content_id . ' gesen id-tai surguuliin group';
                $model = new Group();
                $groups = $model->getAll($content_type_id, $content_id);
                $members = $model->getSchoolUser($content_id);
                $m_count = count($members);
                foreach ($groups as $g) { 
                    $cover = json_decode($g->params);
                    $g->params = $cover;
                }
                break;
            case 2: // angiin group
                $title = $content_id . ' gesen id-tai angiin group';
                $model = new Group();
                $groups = $model->getAll($content_type_id, $content_id);
                $members = $model->getProfessionUser($content_id);
                $m_count = count($members);
                foreach ($groups as $g) { 
                    $cover = json_decode($g->params);
                    $g->params = $cover;
                }
                break;
            default:
                header('location: /group/group');// 404 redirect to /groups/group
                return;
        }
        require ROOT . '/view/group/discussion.php';
    }
    public function member($content_type_id, $content_id) {
        $model = new Group();
        switch ($content_type_id) {
            case 1:
                $groups = $model->getAll($content_type_id, $content_id);
                foreach ($groups as $g) { 
                    $cover = json_decode($g->params);
                    $g->params = $cover;
                }
                $members = $model->getSchoolUser($content_id);
                $m_count = count($members);
                break;
            case 2:
                $groups = $model->getAll($content_type_id, $content_id);
                foreach ($groups as $g) { 
                    $cover = json_decode($g->params);
                    $g->params = $cover;
                }
                $members = $model->getProfessionUser($content_id);
                $m_count = count($members);
                break;
        }
       
        require ROOT . '/view/group/member.php';
    }

    public function edit($id, $content_type_id, $content_id){
        $model = new Group();
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $name = $_FILES['file']['name'];
             $size = $_FILES['file']['size'];
             $type = $_FILES['file']['type'];
             $tmp_name = $_FILES['file']['tmp_name'];
             $uploaddir = getcwd()."/assets/upload/".$name;
             
            if (move_uploaded_file($tmp_name, $uploaddir)){
                echo "File are upload";
                $path = '{"cover":"/assets/upload/'.$name.'"}';
                $result = $model->edit($id, $path);
                header('location:/group/group/discussion/'.$content_type_id.'/'.$content_id);
            }else{
                header('location:/group/group/discussion/'.$content_type_id.'/'.$content_id);
                echo "Fail";
            }
        }
    }

    public function userSearch($content_type_id, $content_id){
        $model = new Group();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['str'])){
                
            }
        }
        header('location:/group/group/member/'.$content_type_id.'/'.$content_id);
    }
}