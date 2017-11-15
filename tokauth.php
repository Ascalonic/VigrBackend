<?php

	include 'dbconn.php';
	include 'userinfo.php';
	
	$response = array();
	
	$phone_num = $_POST['phno'];
	$token = $_POST['token'];
	
	$response['success'] = verifyUserTok($phone_num, $token);
	
	echo json_encode($response);

?>