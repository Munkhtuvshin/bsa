<?php 

	require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
 $mail = PHPMailer();
 $mail->isSMTP();
 $mail->SMTPAuth=true;
 $mail->SMTPSecure='ssl';
 $mail->Host ='smtp.gmail.com';
 $mail->Port = '465';
 $mail->isHTML();
 $mail->Username='monhood34@gmail.com';
 $mail->Password ='alskdjfhg!@#123';
 $mail->SetForm('vsvs');
 $mail->Subject='Hello world';
 $mail->Body='Atestss';

 $mail->AddAddress('B150920009@mymust.net');
 $mail->Send();
?>
