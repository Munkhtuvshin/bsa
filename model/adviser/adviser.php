<?php
require_once ROOT . '/model/Model.php';
class Adviser extends Model{

    public function __construct() {
		parent::__construct();
    }
    public function getAll() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT user.id, user.last_name, user.first_name, user.username FROM user LEFT JOIN user_detail ON user.id = user_detail.user_id GROUP BY user.id' ; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        // var_dump($res);
        
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    function get($id){
        $results = array();
        $query = "SELECT * FROM user WHERE id = " . $id;
        $rows = $this->db->query($query);
        if($row = $rows->fetch_object()){
          $results[] = $row;
        }
        return $results;
    }

    public function add(
        $username,
        $password, 
        // $password_again, 
        $f_name,
        $m_name,
        $l_name,
        $type,
        $recovery_code,
        $birthday,
        $family_type,
        $phone,
        $email,
        $address,
        $worship,
        $language,
        $sex,
        $profile_photo,
        $cover_photo){

        // $model = getUserId();
        // var_dump($model);
        $user_id = 0;
        $user_detail_id = 0;
        $error = array();
        $query = '';
            $profile_tmp = explode('.',$profile_photo['name']);
            $profile_ext = strtolower(end($profile_tmp));
            $cover_tmp = explode('.',$cover_photo['name']);
            $cover_ext =  strtolower(end($cover_tmp));

        $expensions= array("jpeg","jpg","png");
        if($username != '' && $password != '' && $type != ''){
            $user = new User();
            $user_id = $user->getMe()->id;
            $profile_img_path = ROOT."/assets/img/adviser/profile/".$profile_photo['name'];
            $cover_img_path = ROOT."/assets/img/adviser/cover/".$cover_photo['name'];  
            //user id query     
            //$user_query = 'SELECT id FROM user ORDER BY id DESC LIMIT 1;';//user husnegtees hamgiin suuliin id iiig unshina;        
            //$data = $this->db->query($user_query); //query ajilluulna 
            // while ($row = $data->fetch_object()) {
            //     $user_id = $row->id;
            // }
            // $user_detail_query = 'SELECT id FROM user_detail ORDER BY id DESC LIMIT 1;'; 
            // $b = $this->db->query($user_detail_query); //query ajilluulna 
            // while ($row = $b->fetch_object()) {
            //     $user_detail_id = $row->id;
            // }

            // $user_id += 1;
            // $user_detail_id += 1;
            // $datas = [$birthday, $family_type, $phone, $email, $address, $worship, $language, $sex, $profile_img_path, $cover_img_path];
           
            $query = "INSERT INTO user(username, password, first_name, middle_name, last_name,
            user_type_id, recovery_code) VALUES ('".$username."', '".$password."', '".$f_name."', '".$m_name."', '".$l_name."',".$type.",".$recovery_code.")";

            $user = $this->db->query($query);
            $query1 = "INSERT INTO user_detail(user_id,user_field_id,value) VALUES (".$user_id.", 1, '".$birthday."'),
                                                     (".$user_id.", 2, '".$family_type."'),
                                                     (".$user_id.", 3, ".$phone."),
                                                     (".$user_id.", 4, '".$email."'),
                                                     (".$user_id.", 5, '".$sex."'),
                                                     (".$user_id.", 6, '".$worship."'),
                                                     (".$user_id.", 7, '".$language."'),
                                                     (".$user_id.", 8, '".$profile_img_path."'),
                                                     (".$user_id.", 9, '".$cover_img_path."')";   
                                                    
                                                    //  var_dump($user, $query1);
        }
        return $this->db->query($query1);         
    }
    public function report($report) {
        $query = 'INSERT INTO report (reported_date, description, report_reason_id, reported_by, user_id)';
        $query .= 'values ("' . $report->reported_date . '", "' . 
            $report->description . '", "' . $report->report_reason_id . '", "' . 
            $report->reported_by . '", "' . $report->user_id . '")';
        return $this->db->query($query); // query ajilluulna
    }
    
    function edit($id, $f_name,$l_name,$email_phone,$username,$password){
        // $query = "UPDATE user SET fname = ".$name.", lname=".$l_name.", email_phone=".$email_phone.", username=".$username.", password=.".$password WHERE id = $id";
        
        $query='UPDATE user SET first_name="' . $f_name . '", last_name="' . 
            $l_name . '", middle_name="' . $email_phone . '", username="' . 
            $username . '", password="' . $password . '", user_type_id=1'.' where id='.$id;
            // var_dump($query);

        $result = $this->db->query($query);
        if(!$result){
            echo $this->db->error;
        }
        return $result;
    }
    function remove($id){
        $query = "DELETE FROM user WHERE id = " . $id;
        $query1 = " DELETE FROM user_detail WHERE user_id =".$id;
        $resp = $this->db->query($query1);
        $result = $this->db->query($query);
        if(!$result){
            echo $this->db->error;
        }
        return $result;
    }
    function useDatas(){
        
    }
}