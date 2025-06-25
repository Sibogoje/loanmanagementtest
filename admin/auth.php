<?php
//session_start();
// Change this to your connection info.
$DATABASE_HOST = '194.5.156.43';
$DATABASE_USER = 'u747325399_mcenge';
$DATABASE_PASS = 'Mcenge!5474';
$DATABASE_NAME = 'u747325399_mcenge';
// Try and connect using the info above.
$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
?>