<?php

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "web_project";
	
	$parameter = $_REQUEST["q"];

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

	$sql = "SELECT city_square.square_ID, city_square.population, city_square.parking_slots, square_points.point_x, 
			square_points.point_y, city_square_type.".$parameter.", city_square_type.name , city_square.centroid_x, city_square.centroid_y
			FROM city_square 
			INNER JOIN square_points ON city_square.square_ID = square_points.city_square_ID
			INNER JOIN city_square_type ON city_square.type =  city_square_type.name ORDER BY square_points.point_ID, square_points.city_square_ID";
	$result = mysqli_query($conn, $sql);
	$result_array = array();
	if (mysqli_num_rows($result) > 0) {
		
		// output data of each row
		$iter = 0;
		while($row = mysqli_fetch_assoc($result)) {
				$result_array[$iter] = $row;
				//echo "id: " . $row["square_ID"] ." population: " . $row["population"] ." parking slots: " . $row["parking_slots"] ." x: " . $row["centroid_x"] ." y: " . $row["centroid_y"] ." type: " . $row["type"] . "<br>";
				$iter++;
		}
				
	} else {
		echo json_encode("");
	}
			
	mysqli_close($conn);
		
	//return $result_array;
	if(sizeof($result_array)>0){
		echo json_encode($result_array);
	}
	
?>
	
	
	
