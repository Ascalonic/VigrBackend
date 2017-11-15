<?php

	include 'dbconn.php';
	
	$response = array();
	
	// prepare and bind
	$stmt = $conn->prepare("INSERT INTO user_confirm (phone, ccode, tstamp) VALUES (?, ?, ?)");
	$stmt->bind_param("sii", $phno, $ccode, $tstamp);

	$phno = $_POST['phno'];
	$tstamp = time();
	$ccode = mt_rand(10000,99999);
	$stmt->execute();

	$response["success"] = true;  
	
	echo json_encode($response);
	
	// Authorisation details.
	$username = "ascalonichive1@gmail.com";
	$hash = "a4afa887a350034b2ed4d8467fee74a8abe38e52b2ec612f9bc9d7b626d96d0c";

	// Config variables. Consult http://api.textlocal.in/docs for more info.
	$test = "0";

	// Data for text message. This is the text message data.
	$sender = "TXTLCL"; // This is who the message appears to be from.
	$numbers = "91".(string)$phno; // A single number or a comma-seperated list of numbers
	$message = (string)$ccode;
	// 612 chars or less
	// A single number or a comma-seperated list of numbers
	$message = urlencode($message);
	$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
	$ch = curl_init('http://api.textlocal.in/send/?');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch); // This is the result from the API
	
	error_log($result, 0);
	
	//echo $result;
	
	curl_close($ch);

	$stmt->close();
	$conn->close();
	

?>