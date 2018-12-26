<?php
	require_once "Facebook/autoload.php";
	if (!session_id()) { session_start(); }
	$FB = new \Facebook\Facebook([
		'app_id' => '207295163534446',
		'app_secret' => '598b1bae2f65137f41396b5a4b0f14c6',
		'default_graph_version' => 'v2.10'
	]);

	$helper = $FB->getRedirectLoginHelper();
?>