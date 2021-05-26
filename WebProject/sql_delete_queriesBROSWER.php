<?php

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "web_project";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
		
	$delete_rows = 	"DELETE FROM square_points; 
	DELETE FROM city_square;
	DELETE FROM city_square_type;
	ALTER TABLE square_points AUTO_INCREMENT = 0; 
	ALTER TABLE city_square AUTO_INCREMENT = 0; 
	ALTER TABLE city_square_type AUTO_INCREMENT = 0;";

	if ($conn->multi_query($delete_rows) === TRUE) {
		echo "Records deleted successfully";
	} else {
		echo "Error deleting records: " . $conn->error;
	}

	$conn->close();

?>