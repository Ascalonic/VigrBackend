<?php
	
	function patientExists($phno, $patname)
	{
		include 'dbconn.php';
		
		$stmt = $conn->prepare("SELECT id FROM patient_info WHERE name=? AND phid=(SELECT id FROM user_info WHERE phone=?)");
		$stmt->bind_param("ss", $patname, $phno);
		
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
	
	function patientID($phno, $patname)
	{
		include 'dbconn.php';
		
		$stmt = $conn->prepare("SELECT id FROM patient_info WHERE name=? AND phid=(SELECT id FROM user_info WHERE phone=?)");
		$stmt->bind_param("ss", $patname, $phno);
		
		$stmt->execute();
	
		/* bind variables to prepared statement */
		$stmt->bind_result($user_id);

		/* fetch values */
		$stmt->fetch();
		
		$stmt->close();
		$conn->close();
		
		return $user_id;
	}
	
	function addPatient($phno, $patname, $dob)
	{
		include 'dbconn.php';
		
		$stmt = $conn->prepare("SELECT id FROM user_info WHERE phone=?");
		$stmt->bind_param("s", $phno);
		
		$stmt->execute();
		
		/* bind variables to prepared statement */
		$stmt->bind_result($user_id);

		/* fetch values */
		$stmt->fetch();
		
		$stmt->close();

		
		// prepare and bind
		$stmt = $conn->prepare("INSERT INTO patient_info(name, phid, dob) VALUES(?, ?, ?)");
		$stmt->bind_param("sis", $patname, $user_id, $dob);

		$stmt->execute();
		
		$stmt->close();
		$conn->close();
	}
	
	function addAppointment($patid, $docid, $appodate)
	{
		include 'dbconn.php';
		
		// prepare and bind
		$stmt = $conn->prepare("INSERT INTO appointments(patid, docid, appodate) VALUES(?, ?, ?)");
		$stmt->bind_param("iis", $patid, $docid, $appodate);

		$stmt->execute();
		
		$stmt->close();
		$conn->close();
	}
	
	function getAppoID($patid)
	{
		include 'dbconn.php';
		
		$stmt = $conn->prepare("SELECT max(id) FROM appointments WHERE patid=?");
		$stmt->bind_param("i", $patid);
		
		$stmt->execute();
		
		/* bind variables to prepared statement */
		$stmt->bind_result($appoid);

		/* fetch values */
		$stmt->fetch();
		
		$stmt->close();

		return $appoid;
	}
	
	function getAppoDocName()
	{
		include 'dbconn.php';
		
		$stmt = $conn->prepare("SELECT name FROM doctor_info WHERE id=(SELECT docid FROM appointments WHERE id=(SELECT max(id) FROM appointments))");
		
		$stmt->execute();
		
		/* bind variables to prepared statement */
		$stmt->bind_result($name);

		/* fetch values */
		$stmt->fetch();
		
		$stmt->close();

		return $name;
	}
	
	function getAppoDate()
	{
		include 'dbconn.php';
		
		$stmt = $conn->prepare("SELECT appodate FROM appointments WHERE id=(SELECT max(id) FROM appointments)");
		
		$stmt->execute();
		
		/* bind variables to prepared statement */
		$stmt->bind_result($appodate);

		/* fetch values */
		$stmt->fetch();
		
		$stmt->close();

		return $appodate;
	}

?>