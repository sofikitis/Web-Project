<?php

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "web_project";

	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	
	if (!$conn->set_charset("utf8")) {
			//printf("Error loading character set utf8: %s\n", $conn->error);
			//echo "<br/>";
	} else {
			//printf("Current character set: %s\n", $conn->character_set_name());
			//echo "<br/>";
	}

	$sql = "SELECT city_square.centroid_x, city_square.centroid_y FROM city_square";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		$result_array = array();
		// output data of each row
		$iter = 0;
		while($row = mysqli_fetch_assoc($result)) {
				$result_array[$iter] = $row;
				$iter++;
		}
				
	} else {
		echo "0 results";
	}
			
	mysqli_close($conn);

	echo json_encode($result_array);
	
?>
	
	
	
