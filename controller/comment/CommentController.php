<?php

require_once ROOT . '/model/comments/Comment.php';
require_once ROOT . '/model/user/User.php';
class CommentController{
    function index() {
        $model = new Comment();
        $comments = $model->getAll();
        require ROOT.'/view/comment/comment-index.php';
    }
 function add() {
    if($_SERVER['REQUEST_METHOD']=='GET')
    {
        require ROOT.'/view/comment/add.php';
    }
    else if($_SERVER['REQUEST_METHOD']=='POST'){
        $model = new Comment();
        $user = new User();
        
        if($user != null){
            $result = $model->add($_POST["comment"], $user->getMe()->id);
            if($result) {
                header('location: /comment/comment');
            }
        }
        else{
            echo "newtreh heregtee";
        }
       
    } else {
        echo "wrong request";
    }
    
}
function edit($commentId) {
    $model = new Comment();
    // $comment = array();
    if($_SERVER['REQUEST_METHOD']=='GET'){
        $comment = $model->getComment($commentId);
        // var_dump($comment);
        require ROOT.'/view/comment/edit.php';
    } else if($_SERVER['REQUEST_METHOD']=='POST'){
        var_dump($commentId);
        $result = $model->edit($commentId, $_POST["comment"]);
        if($result) {
            header('location: /comment/comment');
        }
    } else {
        echo "wrong request";
    }
}
function remove($id) {
    
    $model = new Comment();
    if($_SERVER['REQUEST_METHOD']=='GET'){
       
        $result = $model->remove($id);
        if($result) {
            header('location: /comment/comment');
        }
    } else {
        echo "wrong request";
    }
}
  function reply($id){
    if($_SERVER['REQUEST_METHOD']=='GET'){
        $model = new Comment();
        $result = $model->getComment($id);
        $getReplys = $model->getReply($id);
        // var_dump($getReplys);
        require ROOT.'/view/comment/reply.php';
    } else if($_SERVER['REQUEST_METHOD']=='POST'){
        $model = new Comment();
        $user = new User();
        $result = $model->addReply($_POST["comment"],$user->getMe()->id , $_POST["parent_id"]);
        if($result) {
            header("Refresh:0");
        }
    } else {
        echo "wrong request";
    }
  }
}
