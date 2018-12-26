<?php
require_once ROOT . '/model/user/User.php';
// require_once ROOT.'/controller/user/Mail/Mail.php';
// require_once ROOT.'/controller/user/Mail/Mail/smtp.php';
// require_once ROOT . '/controller/user/PHPMailer/src/PHPMailer.php';
// require_once ROOT . '/controller/user/PHPMailer/src/SMTP.php';
// require_once ROOT . '/controller/user/PHPMailer/src/Exception.php';
// require_once ROOT."/controller/user/gmailLoginPHP/GoogleAPI/vendor/autoload.php";

$te='sd sain uu';
date_default_timezone_set('Asia/Shanghai');
class UserController {
    // public static $gClient ;
    
    public function index() {
    }

    public function signIn() {
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $model = new User();
            // var_dump($model);
            $result=$model->check($_POST["uname"],$_POST["pass"]);
            // var_dump($result);
            // var_dump($model);
            if(isset($result)){
                // $model = new User();
                $_SESSION['USER_ID']=$result->id;
                $model->setMe($result);
                // $reportReason = $model->getReportReason();
                // var_dump($reportReason);
                header("Location: /");
                return;
            }
            else{
                $error="Хэрэглэгчийн нэр эсвэл нууц үг буруу байна.";
                require ROOT.'/view/user/sign-in.php';
            }
        }
        // $gClient = new Google_Client();
        // var_dump($te);
        // $loginURL = $gClient->createAuthUrl();
        // $_SESSION['ggclient']=$gClient;
        require ROOT . '/view/user/sign-in.php';
         //**************************PHPMailer ashiglasan :
         // $mail = new PHPMailer\PHPMailer\PHPMailer();
         // $mail->isSMTP();
         // $mail->SMTPAuth=true;
         // $mail->SMTPSecure='ssl';
         // $mail->Host ='smtp.gmail.com';
         // $mail->Port = '587';
         // $mail->isHTML();
         // $mail->Username='monhood34';
         // $mail->SMTPDebug = 2;
         // $mail->Password ='alskdjfhg!@#123';
         // $mail->SetFrom('monhood34@gmail.com');
         // $mail->Subject='Hello world';
         // $mail->Body='Atestss';

         // $mail->AddAddress('B150920009@mymust.net','cn');
         // if(!$mail->Send()) {
         //    // echo "Mailer Error:     .................//////////     " . $mail->ErrorInfo;
         // } else {
         //    echo "Message has been sent";
         // }

        //*********************Pear php ashiglasan:
        // $from = '<monhood34@gmail.com>';
        // $to = '<>';
        // $subject = 'Hi!';
        // $body = "Hi,\n\nHow are you?";

        // $headers = array(
        //     'From' => $from,
        //     'To' => $to,
        //     'Subject' => $subject
        // );

        // $smtp = Mail::factory('smtp', array(
        //         'host' => 'ssl://smtp.gmail.com',
        //         'port' => '465',
        //         'auth' => true,
        //         'username' => '',
        //         'password' => ''
        //     ));

        // $mail = $smtp->send($to, $headers, $body);

        // if (PEAR::isError($mail)) {
        //     echo('<p>' . $mail->getMessage() . '</p>');
        // } else {
        //     echo('<p>Message successfully sent!</p>');
        // }
    }

    public function signOut(){
        session_destroy();
        header("Location: /");
    }

    public function list(){
        $model = new User();
        $me=$model->getMe();
        $users = $model->getAll();
        $reportReason = $model->getReportReason();
        $current_user_id=$model->getMe()->id;
        if(isset($_SESSION['USER_ID']) && $me->user_type_id==3){
            require ROOT.'/view/user/userList.php';
        }
        else{
            header("Location: /");
        }
    }
    
    public function signUp(){
        if($_SERVER['REQUEST_METHOD']=='GET'){
            // Мэдээлэл оруулах хуудас харуулна
            $model = new User();
            $users_type=$model->getUserType();
            // var_dump($users_type);
            require ROOT . '/view/user/sign-up.php';
        } else if($_SERVER['REQUEST_METHOD']=='POST'){
            $model = new User();
            // var_dump($_POST["user_type"]);
            if($_POST["password"]!=$_POST["re-pass"]){
                $model = new User();
                $users_type=$model->getUserType();
                // var_dump($users_type);
                $passequ="Нууц үг таарахгүй байна.";
                require ROOT . '/view/user/sign-up.php';
            }else{
                $result = $model->add($_POST["first_name"],$_POST["last_name"],$_POST["email_phone"],$_POST["username"],$_POST["password"], $_POST["user_type"]);
                if($result) {
                    $lastuser=$model->getLastUser();
                    $_SESSION['USER_ID']=$lastuser->id;
                    $model->setMe($lastuser);
                    header('location: /');
                    exit();
                    // die();
                }
            }
        } else {
            echo "wrong request";
        }
    }

    function edit($id) {
        // Модел классын обьектыг үүсгэнэ
        $model = new User();
        if($_SERVER['REQUEST_METHOD']=='GET'){
            $user = $model->get($id);
            // var_dump($user);
            require ROOT.'/view/user/edit.php';
        } else if($_SERVER['REQUEST_METHOD']=='POST'){
            // Өгөгдлийн санд шинэ мэдээлэл оруулна
            // Модел классыг ашиглан өгөгдөл ачаална
            $result = $model->edit($id, $_POST["first_name"],$_POST["last_name"],$_POST["email_phone"],$_POST["username"],$_POST["password"]);
            if($result) {
                header('location: /user/user/list');
            }
        } else {
            echo "wrong request";
        }
    }

    function remove($id) {
        // Модел классын обьектыг үүсгэнэ
        $model = new User();
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $result = $model->remove($id);
            if($result) {
                header('location: /user/user/list');
            }
        } else {
            echo "wrong request";
        }
    }

    public function report(){
        $model = new User();
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $model = new User();
            // var_dump($_POST["reason_id"],$_POST["report_u_id"],$_POST["u_id"], $_POST["description"]);
            $tl=$model->setReport($_POST["reason_id"],$_POST["report_u_id"],$_POST["u_id"], $_POST["description"],date('Y-m-d H:i:s', time()) );
            if($tl){
                // $info='Амжилттай report хийлээ!!!';
                header('location: /user/user/list');
            }
            else{
                $info='Report Амжилтгүй боллоо.';
                require ROOT.'/view/user/userList.php';
            }
        } else {
            echo "wrong request";
        }
    }

    public function reportList($id){
        // var_dump($id);
        $model = new User();
        $reports=$model->getReports($id);
        // var_dump($reports);
        if($reports){
            require ROOT.'/view/user/userReportList.php';
        }
        else{
            require ROOT.'/view/user/userReportList.php';
            //ene hereglegchid report baihgvi bn geed ene huudsand ni haruulna.
        }
    }

    public function forget(){

        if($_SERVER['REQUEST_METHOD']=='POST'){
            $model = new User();    
            // var_dump($model->checkEmail($_POST['email']));
            if($model->checkEmail($_POST['email'])){
                $from = '<monhood34@gmail.com>';
                $to = '<'.$_POST["email"].'>';
                $subject = 'Password recovery!';

                $random=rand(999,9999);
                $body = "Hi,\n\nHow are you? Your recovery code: ".$random;

                $headers = array(
                    'From' => $from,
                    'To' => $to,
                    'Subject' => $subject
                );

                $smtp = Mail::factory('smtp', array(
                        'host' => 'ssl://smtp.gmail.com',
                        'port' => '465',
                        'auth' => true,
                        'username' => 'monhood34@gmail.com',
                        'password' => 'alskdj'
                    ));

                $mail = $smtp->send($to, $headers, $body);

                if (PEAR::isError($mail)) {
                    echo('<p>' . $mail->getMessage() . '</p>');
                } else {
                    $model->setRecoveryCode($_POST['email'], $random);
                    // var_dump($_SESSION['recoveryMail']);
                    require ROOT.'/view/user/mailconfirm.php';
                } 
            }
            else{
                $error='Таны имейл бүртгэлгүй байна.';
                require ROOT.'/view/user/recovery.php';
            }
        }
        else{
            require ROOT.'/view/user/recovery.php';
        }
    }
    public function mailConfirm(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $model = new User();
            // session_start();
            // var_dump($_SESSION['recoveryMail']);
            if($model->checkRecoveryCode($_POST['verificationCode'])){
                require ROOT.'/view/user/newpassword.php';
            }
            else{
                $error='Таны оруулсан баталгаажуулах код буруу байна.';
                require ROOT.'/view/user/mailconfirm.php';
            }
        }

    }
    public function newpassword(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            if($_POST['re-newpassword'] == $_POST['newpassword']){
                $model = new User();
                if($model->setNewPassword($_POST['newpassword'])){
                    header('location: /user/user/sign-in');
                }
            }
            else{
                $error='Нууц үг ижил биш байна.';
                require ROOT.'/view/user/newpassword.php';
            }
        }
        else{
            require ROOT.'/view/user/newpassword.php';
        }
    }

    public function block(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $model = new User();
            $res=$model->setBlock($_POST["reason_id"],$_POST["report_u_id"], $_POST["description"],date('Y-m-d H:i:s', time()) );
            header('location: /user/user/blockedusers');
        }
        else{
            echo 'wrong request';
        }
    }

    public function blockedusers(){
        if($_SERVER['REQUEST_METHOD']=='GET'){
            $model =new User();
            $results=$model->getBlockedUsers();
            // var_dump($results);
            $unBlockReasons=$model->getUnBlockReason();
            require ROOT.'/view/user/blocked_users.php';
        }
        if($_SERVER['REQUEST_METHOD']=='POST'){
                
        }
    }

    public function unblock(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $model = new User();
            // var_dump($_POST['block_id'],$_POST['reason_id']);
            $check=$model->unblock($_POST['block_id'],$_POST['reason_id']);
            if($check){
                header('location: /user/user/list');
            }
            else{
                
            }
        }
        else{
            echo 'wrong request!!!';
        }
    }

    public function glogin(){
        require_once ROOT . '/controller/user/gmailLoginPHP/config.php'; //require once-iig zzaawal end
        if (isset($_GET['code'])) {
            $token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
        }

        $oAuth = new Google_Service_Oauth2($gClient);
        $userData = $oAuth->userinfo_v2_me->get();
        // var_dump($userData);
        $model = new User();
        $zow = $model->gmailSignUp($userData);
        // var_dump($zow);
        if($zow){
            $me = $model->getLastSocialUser($userData['id']);
            $_SESSION['USER_ID']=$me->id;
            $model->setMe($me);
            header('location: /');
            // echo 'timi';
        }else{
            echo 'timi bish';
        }
    }

    public function fbLogin(){
        require_once ROOT . '/controller/user/fbLoginPHP/config.php'; //require once-iig zzaawal end
        $accessToken = $helper->getAccessToken();
        $oAuth2Client = $FB->getOAuth2Client();
        if (!$accessToken->isLongLived())
            $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);

        $response = $FB->get("/me?fields=id, first_name, last_name, email, picture.type(large)", $accessToken);
        $userData = $response->getGraphNode()->asArray();
        // var_dump($userData);
        $model = new User();
        $zow = $model->fbSignUp($userData);
        if($zow){
            $me = $model->getLastSocialUser($userData['id']);
            $_SESSION['USER_ID']=$me->id;
            $model->setMe($me);
            header('location: /');
            // echo 'timi';
        }else{
            echo 'timi bish';
        }
    }


}