<?php

	include 'dbconn.php';
	
	$place = $_POST["place"];
	$spec = $_POST["spec"];
	
	$response = array();
	
	//-----------------------------------------------------------------------

	$stmt = $conn->prepare("SELECT doctor_info.id, doctor_info.name, hospital_info.name, dist_info.name FROM doctor_info, hospital_info, 
	dist_info WHERE doctor_info.spec_id=(SELECT id FROM spec_info WHERE spec_name=?) AND doctor_info.hosp_id IN 
	(SELECT id FROM hospital_info WHERE hospital_info.dist_id=(SELECT id FROM dist_info WHERE dist_info.name=?)) 
	AND doctor_info.hosp_id=hospital_info.id");
								
	$stmt->bind_param("ss", $spec, $place);
		
	$stmt->execute();
	
	$confirm=false;

    /* bind variables to prepared statement */
    $stmt->bind_result($doc_id, $doc_name, $hosp_name, $dist_name);

    /* fetch values */
    while($stmt->fetch())
	{
		$response[] = array('doc_id' => $doc_id, 'doc_name' => $doc_name, 'hosp_name' => $hosp_name, 'dist_name' => $dist_name);
	}

	$stmt->close();
    
    echo json_encode($response);

?>