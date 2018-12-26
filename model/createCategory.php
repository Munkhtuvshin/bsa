<?php
	require_once 'view/tasks.php';
 
	if(ISSET($_POST['add_task'])){	
		$catname = $_POST['cat_name'];
		$conn = new Category();
		$conn->add($catname);
		header('location: view/tasks.php');
	}	
 
?>