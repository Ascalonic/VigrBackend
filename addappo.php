<?php

	include 'dbconn.php';
	include 'patientinfo.php';
	
	$response = array();
	
	$phno = $_POST['phno'];
	$acctok = $_POST['acctok'];
	$patname = $_POST['patname'];
	$patdob = $_POST['patdob'];
	$appodate = $_POST['appodate'];
	$docid = $_POST['docid'];
	
	$patid=0;

	if(patientExists($phno, $patname)) {
		$patid = patientID($phno, $patname);
		addAppointment($patid, $docid, $appodate);
	}
	else
	{
		addPatient($phno, $patname, $patdob);
		$patid = patientID($phno, $patname);
		addAppointment($patid, $docid, $appodate);
	}
	
	$response['success']=true;
	$response['appoid']=getAppoID($patid);
	
	echo json_encode($response);
	
	
?>