<?php
require_once ROOT . '/model/file.php';
class FileController {
    public function index() {
        $model = new File();
        $files = $model->getAllFile();
        $users = $model->getAllUser();
        $ownerTypes = $model->getAllOwnerType();
        require ROOT . '/view/lesson/file.php';
    }

      public function getAllFile(){
        $model = new  File();
        $files = $model->getAllFile();
        #$categories = $model->getAllCategories();
        require ROOT . '/view/lesson/file.php';
    }

    public function add() {
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
         {
            if(isset($_POST['path']) &&
                isset($_POST['description'])&&
                isset($_POST['user_id']) &&
                isset($_POST['owner_type_id']) &&
                isset($_POST['owner_id']))
            {
                $model = new File();
                $file = new stdClass();
                $file->path = $_POST['path'];
                $file->description = $_POST['description'];
                $file->user_id = $_POST['user_id'];
                $file->owner_type_id = $_POST['owner_type_id'];
                $file->owner_id = $_POST['owner_id'];
                
                $result = $model->add($file);
                if ($result > 0)
                {
                   echo "<script>alert('Файл нэмэгдлээ'); window.location='getAllFile';</script>";
                   # $this->index();
                } else {
                    $message = 'Нэмж чадсангүй';
                }
            } else 
            {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
        $model = new File();
        $files = $model->getAllFile();
         $users = $model->getAllUser();
        $ownerTypes = $model->getAllOwnerType();
        require ROOT . '/view/lesson/addFile.php';
        #redirect("/view/lesson/index.php");
    }

    public function remove($id) {
        if ($id > 0) {
            $model = new File();
            $result = $model->remove($id);
            $this->index();
            #require ROOT . '/view/lesson/add.php';
            #redirect("http://localhost:8081");
        }
    }

    public function edit($id) {
        $message = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
         {
           if(isset($_POST['path']) &&
                isset($_POST['description'])&&
                isset($_POST['user_id']) &&
                isset($_POST['owner_type_id']) &&
                isset($_POST['owner_id']))
            {
                $model = new File();
                $file = new stdClass();
                $file->path = $_POST['path'];
                $file->description = $_POST['description'];
                $file->user_id = $_POST['user_id'];
                $file->owner_type_id = $_POST['owner_type_id'];
                $file->owner_id = $_POST['owner_id'];
                $result = $model->edit($id, $file);
                if ($result > 0)
                {
                    #echo "<script>alert('Мэдээ засагдлаа'); window.location='getAll';</script>";
                    $message = 'Амжилттай засагдлаа';
                   # $this->index();
                } else {
                    $message = 'Засч чадсангүй';
                }
            } else 
            {
                $message = 'Мэдээллээ бүрэн оруулна уу';
            }
        }
        $model = new File();
        $files = $model->getAllFile();
         $users = $model->getAllUser();
        $ownerTypes = $model->getAllOwnerType();
        require ROOT . '/view/lesson/editFile.php';
        #redirect("/view/lesson/index.php");
    }
     public function getAllDownload(){
       if (isset($_GET['path'])) {
           $model = new File();
                $file = new stdClass();
                $file->path = $_GET['path'];
                $result = $model->download($id);
                if ($result > 0)
                {
                    #echo "<script>alert('Мэдээ засагдлаа'); window.location='getAll';</script>";
                    $message = 'Амжилттай засагдлаа';
                   # $this->index();
                } else {
                    $message = 'Засч чадсангүй';
                }
       }
       
        #$categories = $model->getAllCategories();
        require ROOT . '/view/lesson/file.php';
    }
     

}