<?php

$servername = "mitscse.hosting.acm.org";
$username = "mitscseh_vigr";
$password = "Fucksenseai1";
$dbname = "mitscseh_vigr";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

?>