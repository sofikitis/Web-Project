<?php

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "web_project";
	
	//sql_select("*", "square_points", "1", $servername, $username, $password, $dbname);
	
	function sql_select($columns, $table_name, $condition, $servername, $username, $password, $dbname){
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
		
		$sql = "SELECT ".$columns." FROM ".$table_name." WHERE ".$condition;
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) > 0) {
			$result_array = array();
			// output data of each row
			$iter = 0;
			while($row = mysqli_fetch_assoc($result)) {
				$result_array[$iter] = $row;
				//echo "id: " . $row["square_ID"] ." population: " . $row["population"] ." parking slots: " . $row["parking_slots"] ." x: " . $row["centroid_x"] ." y: " . $row["centroid_y"] ." type: " . $row["type"] . "<br>";
				$iter++;
			}
				
			/*foreach($result_array as $val){
				print_r($val);						
				echo "<br/>";
			}*/
			
		} else {
			//echo "0 results";
		}
			
		mysqli_close($conn);
		
		return $result_array;
		//echo json_encode($result_array);
	}

?>