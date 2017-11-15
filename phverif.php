<?php

	include 'dbconn.php';
	include 'userinfo.php';
	
	$response = array();
	
	$ph_inp = $_POST['phno'];
	$ccode_inp = $_POST['ccode'];
	
	$stmt = $conn->prepare("SELECT phone, ccode, tstamp FROM user_confirm WHERE ccode=? AND phone=?");
	$stmt->bind_param("is", $ccode_inp, $ph_inp);
		
	$stmt->execute();
	
	$confirm=false;

    /* bind variables to prepared statement */
    $stmt->bind_result($phone, $ccode, $tstamp);
	
	$confirm=false; $timeexp=false; $noentry=true;

    /* fetch values */
    while ($stmt->fetch()) {
		$noentry=false;
		if(time()-$tstamp<60) {
			$confirm=true;
		}
		else{
			$timeexp=true;
		}
    }
	
	$stmt->close();
	
	if($confirm==true) {
		
		$acc_tok = hash("ripemd160",(string)time());
		
		if(userExists($ph_inp))
		{
			error_log("Updating token ".$acc_tok." for ".$ph_inp, 0);
			updateAccTok($ph_inp,$acc_tok);
		}
		else
		{
			createAccTok($ph_inp, $acc_tok);
		}
		
		$response["success"] = true; 
		$response["message"] = $acc_tok; 
		
		//Delete the confirmation rows corresponding to the phone
		
		$stmt = $conn->prepare("DELETE FROM user_confirm WHERE phone=?");
		$stmt->bind_param("s", $ph_inp);
		
		$stmt->execute();
		
		$stmt->close();
		
	}
	else{
		
		$response["success"] = false; 
		if($noentry==true)
		{
			$response["message"] = "Invalid OTP. code is ".$_POST['ccode']." and phone " . $_POST['phno']; 
		}
		else if($timeexp==true)
		{
			$response["message"] = "Time expired"; 
		}
	}
	
	 echo json_encode($response);
	
	$conn->close();
	

?>