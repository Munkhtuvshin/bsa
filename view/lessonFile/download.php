<?php

include('inc/model/model.php');

if (isset($_GET['dow'])) {
	$path = $_GET['dow'];

	$res = mysql_query("Select * from file where path='$path'");

	header('Content=Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="'.basename($path).'"');
	header('Content-Length: '.filesize($path));
	readfile($path);
	# code...
}
?>