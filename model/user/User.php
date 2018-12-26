<?php
require_once ROOT . '/model/Model.php';
class User extends Model{
    private static $me;
    public static function loadCurrentUser() {
        // Сешнийг асаана.
        // Ингэснээр сешинд хадгалсан өгөгдөлтэй харьцах боломжтой болно
        session_start();
        // Нэвтэрсэн хэрэглэгчийн мэдээллийг авч ME гэсэн тогтмолд хадгална
        // Хэрвээ зочин бол ME тогтмол нь NULL утгатай байна
        if (array_key_exists('USER_ID', $_SESSION) && $_SESSION['USER_ID'] > 0) {
            $model = new User();
            self::$me = $model->get($_SESSION['USER_ID']);
        } else {
            self::$me = null;
        }
    }
    public function check($uname, $pass){
        $password=md5($pass);
        $query="call checkUser('$password','$uname');";
        $rows = $this->db->query($query); // query ajilluulna
        if($row = $rows->fetch_object()){
            return $row;
        }

    }
    public function getLastUser(){
        $rows= $this->db->query('SELECT * FROM user ORDER BY id DESC LIMIT 1;');
        if($row = $rows->fetch_object()){
            return $row;
        }
    }
    public static function getMe() {
        return self::$me;
    }
    public static function setMe($setme) {
        self::$me=$setme;
    }
    public function __construct() {
		parent::__construct();
    }
    public function getAll() {
        $result = array(); // butsaah utga hadgalna
        $query = 'SELECT * FROM temp_users where blocked_date is null || unblocked_date is not null;'; // select query
        $res = $this->db->query($query); // query ajilluulna
        // irsen ugugdluudiig mur muruur n unshij avna
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }
    function get($id){
        $query = "SELECT * FROM user WHERE id = " . $id;
        $rows = $this->db->query($query);
        if($row = $rows->fetch_object()){
            return $row;
        }
    }

    public function add($f_name,$l_name,$email_phone,$username,$password,$user_type_id) {
        $query = 'INSERT INTO user (username, password, first_name, last_name, middle_name, user_type_id)';
        $query .= ' values ("' . $username . '", "' . 
            md5($password) . '", "' . $l_name . '", "' . 
            $f_name . '", "' . $email_phone . '",'.$user_type_id.')';
        return $this->db->query($query); // query ajilluulna
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
        $result = $this->db->query($query);
        if(!$result){
            echo $this->db->error;
        }
        return $result;
    }

    public function getReportReason(){
        $query = "select * from report_reason;";
        $res = $this->db->query($query);
        while ($row = $res->fetch_object()) {
            $result[] = $row;
        }
        return $result;
    }

    public function setReport($reason_id,$u_id,$report_u_id,$description,$time){
        $query = "INSERT INTO `report` (`reported_date`, `description`, `report_reason_id`, `reported_by`, `user_id`) VALUES ('$time', '$description', $reason_id, $report_u_id, $u_id );";
        // var_dump($query);
        $result=$this->db->query($query);
        // var_dump($result);
        return $result; 
    }

    public function getReports($user_id){
        // var_dump($user_id);
        $query="SELECT report. *,user.*, report_reason.name as reasonName FROM (user inner join report on report.user_id=user.id) inner join report_reason on report_reason.id=report.report_reason_id where user.id=$user_id;";
        // var_dump($query);
        $res = $this->db->query($query);
        // return echo typeof($res);
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }

    public function checkEmail($mail){
        $query="select * from user where middle_name='$mail';";
        $res=$this->db->query($query);
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        if($result[0]){
            return true;
        }
        else{
            return false;
        }
    }

    public function setRecoveryCode($mail,$recovery_code){
        $query = "UPDATE `user` SET `recovery_code`='$recovery_code' WHERE `middle_name`='$mail';";
        $res = $this->db->query($query);
        $_SESSION['recoveryMail']=$mail;
        return $res;
    }

    public function checkRecoveryCode($verificationCode){
        $na=$_SESSION['recoveryMail'];
        $query="select recovery_code from user where middle_name='$na';";
        $res=$this->db->query($query);
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        // var_dump($result[0]->recovery_code);

        if(strcmp(result[0]->recovery_code , $verificationCode)){
        // var_dump($verificationCode);
            return true;
        }
        else{
            return false;
        }
    }

    public function setNewPassword($pass){
        $na=$_SESSION['recoveryMail'];
        $password=md5($pass);
        $query="UPDATE `user` SET `password`='$password' WHERE `middle_name`='$na';";
        return $res=$this->db->query($query);
    }

    public function setBlock($reason_id, $u_id, $para, $date){
        $query="INSERT INTO `block` (`user_id`, `report_reason_id`, `blocked_date`,`parameter`) VALUES ($u_id,$reason_id,'$date','$para' );";
        return $this->db->query($query);
    }

    public function getBlockedUsers(){
        $query="select block.id, user.first_name, user.last_name, user.middle_name, user.username from block inner join user on user.id=block.user_id where block.unblocked_date is null;";
        $res = $this->db->query($query);
        // return echo typeof($res);
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }

    public function getUnBlockReason(){
        $query = "select * from unblock_type;";
        $res = $this->db->query($query);
        // return echo typeof($res);
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }

    public function unblock($block_id, $reason_id){
        $date=date('Y-m-d H:i:s', time() );
        $query="UPDATE `block` SET `unblock_type_id`='$reason_id', unblocked_date='$date' WHERE `id`='$block_id';";
        // var_dump($query);
        return $res = $this->db->query($query);
    }

    public function getUserType(){
        $query=" select * from user_type;";
        $res = $this->db->query($query);
        // return echo typeof($res);
        while ($row = $res->fetch_object()) {
            // tuhain mur ugugdliig butsaah utgad nemne
            $result[] = $row;
        }
        return $result;
    }

    public function gmailSignUp($userData){
        $id = $userData['id'];
        $email = $userData['email'];
        $lastname = $userData['familyName'];
        $firstname = $userData['givenName'];
        $query = "INSERT INTO `eschool`.`user` (`username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`) VALUES ('$id', ' ', '$firstname', '$email', '$lastname', '1');";
        $res = $this->db->query($query);
        return $res;
    }

    public function fbSignUp($userData){
        $id = $userData['id'];
        $email = $userData['email'];
        $lastname = $userData['last_name'];
        $firstname = $userData['first_name'];
        $query = "INSERT INTO `eschool`.`user` (`username`, `password`, `first_name`, `middle_name`, `last_name`, `user_type_id`) VALUES ('$id', ' ', '$firstname', '$email', '$lastname', '1');";
        $res = $this->db->query($query);
        return $res;
    }

    public function getLastSocialUser($username){
        $query = "select * from user WHERE `username`='$username';";
        $rows = $this->db->query($query);
        if($row = $rows->fetch_object()){
            return $row;
        }  
    }

}