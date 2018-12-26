<?php 
require_once ROOT . '/model/Model.php';
require_once ROOT. '/model/user/User.php';
class Poll extends Model{
    public function __construct(){
        parent::__construct();
    }
    function pollList(){
        $result = array();
        $query = 'SELECT * FROM poll';
        $response = $this->db->query($query);
        while($row = $response->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }
    function create($question,$start_date,$end_date,$can_add_option, $has_multi_choise, array $options){
        $today = date("Y-m-d");      
        $user = new User();
        $user_id = $user->getMe()->id;
        if($options != null){
            // var_dump($start_date,$user_id, $can_add_option, $options);
            $query = "INSERT INTO poll(question, created_user_id,created_date,has_multi_choise,table_id, table_pk) VALUES(\"$question\", \"$user_id\",'".$today."', \"$has_multi_choise\",1,1)";
            // $query = "SELECT LAST_INSERT_ID()';
            $result = $this->db->query($query);
            // var_dump($result);
            return $result;
        }
        else{
            echo "dddd";
        }
        // else{
        //     $query = "INSERT INTO poll(question,start_date,end_date, created_user_id, created_date, has_multi_choise, can_add_option, table_id, table_pk) VALUES($question, $start_date,$end_date,$user_id,$today, $has_multi_choise,$can_add_option)";
        // }
        // $result = $this->db->query($query);
        // if(!$result){
        //     echo $this->db->error;
        // }
        // return $result;
    }
    function delete($id){
        $result = array();
        $query = 'DELETE FROM poll where id ='.$id;
        $result = $this->db->query($query);
        if(!$result){
            echo $this->$res->error;
        }
        return $result;
    }
    function edit($id){
        $result = array();
        $query = 'SELECT * FROM poll where id='.$id;
        $res = $this->db->query($query);
        while($row = $res->fetch_object()){
            $result[] = $row;
        }
        return $result;
    }
    function editPoll($id,$question){
        $result = array();
        $query = "UPDATE poll SET question=\"$question\" where id=".$id;
        $result = $this->db->query($query);
        if(!$result){
            echo $this->db->error;
        }
        return $result;
    }
}

?>