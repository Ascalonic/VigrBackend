<?php
session_start();

if(!isset($_SESSION['access_token'])) {
	header('Location: google-login.php');
	exit();	
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<body>

<?php

	include 'patientinfo.php';
	
	require_once('google-calendar-api.php');
	
	$capi = new GoogleCalendarApi();
	
	// Create event on primary calendar
	$event_id = $capi->CreateCalendarEvent('primary', 'Appointment with '.getAppoDocName(), 1, getAppoDate(), 'Asia/Kolkata', $_SESSION['access_token']);
	
	echo "<p>Event Created in your google calender!</p>";
	
	unset($_SESSION['access_token']);


?>

</body>
</html>