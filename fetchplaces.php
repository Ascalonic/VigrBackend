<?php

	include 'dbconn.php';
	
	$response = array();
	
	//-----------------------------------------------------------------------

	$stmt = $conn->prepare("SELECT name FROM dist_info");			
		
	$stmt->execute();

    /* bind variables to prepared statement */
    $stmt->bind_result($dist_name);

    /* fetch values */
    while($stmt->fetch())
	{
		$response[] = array('dist_name' => $dist_name);
	}
	
	$stmt->close();
    
    echo json_encode($response);

?>