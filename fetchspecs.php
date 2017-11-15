<?php

	include 'dbconn.php';
	
	$response = array();
	
	//-----------------------------------------------------------------------

	$stmt = $conn->prepare("SELECT spec_name FROM spec_info");					
		
	$stmt->execute();

    /* bind variables to prepared statement */
    $stmt->bind_result($spec_name);

    /* fetch values */
    while($stmt->fetch())
	{
		$response[] = array('spec_name' => $spec_name);
	}
	
	$stmt->close();
    
    echo json_encode($response);

?>