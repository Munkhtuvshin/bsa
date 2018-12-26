<?php
	// session_start();/controller/user/gmailLoginPHP/config.php
	require_once "GoogleAPI/vendor/autoload.php";
	$gClient = new Google_Client();
	$gClient->setClientId("715512699996-92jjdc52ocq23lbgcu4lmofeieknvb33.apps.googleusercontent.com");
	$gClient->setClientSecret("vVz1NLuustRiu7qTT5TJHT3e");
	$gClient->setApplicationName("CPI Login Tutorial own");
	$gClient->setRedirectUri("http://localhost:8000/user/user/glogin");
	$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");
?>
