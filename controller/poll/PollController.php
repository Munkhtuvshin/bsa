<?php
    require_once ROOT.'/model/poll/Poll.php';
    class PollController{
        function index(){
            $model  = new Poll();
            $datas = $model->pollList();
            // if(!$datas){
            //     echo 'poll controller error';
            // }
            // var_dump($dat);
            require ROOT.'/view/poll/polls.php';
        }
        function create(){
            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                require ROOT.'/view/poll/poll-create.php';
            }
            else if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if($_POST['can_add_option'] == 1 || $_POST['has_multi_choise'] == 1){
                    $options = array();
                    $question = $_POST['question'];
                    $start_date = $_POST['start_date'];
                    $end_date = $_POST['end_date'];
                    $can_add_option = $_POST['can_add_option'];
                    $has_multi_choise = $_POST['has_multi_choise'];
                    // $add_option = $_POST['option_plus'];
                    foreach ($_POST['options'] as $key => $value) {
                        $options[] = $value;
                    }
                    $model  = new Poll();
                    // question,start_date,end_date, created_user_id, created_date, has_multi_choise, can_add_option, table_id, table_pk
                    $result = $model->create($question,$start_date,$end_date,$can_add_option, $has_multi_choise, $options);
                    if($result)
                        header("location: /poll/poll");   
                }
                else{
                    $options = array();
                    $question = $_POST['question'];
                    $start_date = $_POST['start-date'];
                    $end_date = $_POST['end_date'];
                    $can_add_option = 0;
                    $has_multi_choise = 0;
                    // $add_option = $_POST['option_plus'];
                    // foreach ($_POST['options'] as $key => $value) {
                    //     $options[] = $value;
                    // }
                    $model  = new Poll();
                    // question,start_date,end_date, created_user_id, created_date, has_multi_choise, can_add_option, table_id, table_pk
                    $result = $model->create($question,$start_date,$end_date,$can_add_option, $has_multi_choise, $options);
                    if($result)
                        header("location: /poll/poll");
                }
                
            }   
        }
        function edit($id){
            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                $model = new Poll();
                $datas = $model->edit($id);
                require ROOT.'/view/poll/poll-edit.php';
            }
            else if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $question = $_POST['question'];
                $model  = new Poll();
                $result = $model->editPoll($id,$question);
                if($result)
                    header("location: /poll/poll");   
            }   
            $model = new Poll();
            $datas = $model->edit($id);

            
        }
        function delete($id){
            $model = new Poll();
            $datas = $model->delete($id);
            if($datas){
                header("location: /poll/poll");   
            }
            else{
                echo 'poll delete data error';
            }
        }
    }

?>
