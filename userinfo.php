<?php

	
	function userExists($phno)
	{
		include 'dbconn.php';
		
		$stmt = $conn->prepare("SELECT id FROM user_info WHERE phone=?");
		$stmt->bind_param("s", $phno);
		
		$stmt->execute();

		$stmt->store_result();
		if($stmt->num_rows>0)
		{
			$stmt->close();
			$conn->close();
			
			return true;
		}
		
		$stmt->close();
		$conn->close();
		
		return false;
	}
	
	function updateAccTok($phno, $tok)
	{
		include 'dbconn.php';
		
		// prepare and bind
		$stmt = $conn->prepare("UPDATE user_info SET acctok=? WHERE phone=?");
		$stmt->bind_param("ss", $tok, $phno);

		$stmt->execute();
		
		$stmt->close();
		$conn->close();
	}
	
	function createAccTok($phno, $tok)
	{
		include 'dbconn.php';
		
		// prepare and bind
		$stmt = $conn->prepare("INSERT INTO user_info(phone, acctok) VALUES(?, ?)");
		$stmt->bind_param("ss", $phno, $tok);

		$stmt->execute();
		
		$stmt->close();
		$conn->close();
	}
	
	function verifyUserTok($phno, $tok)
	{
		include 'dbconn.php';
		
		$stmt = $conn->prepare("SELECT id FROM user_info WHERE phone=? AND acctok=?");
		$stmt->bind_param("ss", $phno, $tok);
		
		$stmt->execute();

		$stmt->store_result();
		if($stmt->num_rows>0)
		{
			$stmt->close();
			$conn->close();
			
			return true;
		}
		
		$stmt->close();
		$conn->close();
		
		return false;
	}

?>