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
	
	$sql_points = "SELECT * FROM square_points WHERE 1";
	$result_points = mysqli_query($conn, $sql_points);
	if (mysqli_num_rows($result_points) > 0) {
		$result_array_points = array();
		// output data of each row
		$iter = 0;
		while($row_points = mysqli_fetch_assoc($result_points)) {
				$result_array_points[$iter] = $row_points;
				//echo "id: " . $row["square_ID"] ." population: " . $row["population"] ." parking slots: " . $row["parking_slots"] ." x: " . $row["centroid_x"] ." y: " . $row["centroid_y"] ." type: " . $row["type"] . "<br>";
				$iter++;
		}
				
	} else {
		echo "0";
	}
	
	
	$sql_squares = "SELECT * FROM city_square WHERE 1";
	$result_squares = mysqli_query($conn, $sql_squares);
	if (mysqli_num_rows($result_squares) > 0) {
		$result_array_squares = array();
		// output data of each row
		$iter = 0;
		while($row_squares = mysqli_fetch_assoc($result_squares)) {
				$result_array_squares[$iter] = $row_squares;
				//echo "id: " . $row["square_ID"] ." population: " . $row["population"] ." parking slots: " . $row["parking_slots"] ." x: " . $row["centroid_x"] ." y: " . $row["centroid_y"] ." type: " . $row["type"] . "<br>";
				$iter++;
		}
				
	} else {
		echo "0";
	}
			
	$result_array = array($result_array_points, $result_array_squares);
	mysqli_close($conn);
		
	//return $result_array;
	echo json_encode($result_array);
	
?>
	
	
	
