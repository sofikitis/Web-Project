<?php

include 'centroid.php';
include 'demand_curves_file_parser.php';

function insert_values_in_DB($servername ,$username ,$password ,$dbname ,$polygonDataArray, $populationDataArray){
	
	$park_slots_min = 5;
	$park_slots_max = 100;
	$max_query_values_size = 100000;
	$max_point_queries = intval(strlen(serialize($polygonDataArray)) / $max_query_values_size) + 1;
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	if (!$conn->set_charset("utf8")) {
		//printf("Error loading character set utf8: %s\n", $conn->error);
		//echo "<br/>";
	} else {
		//printf("Current character set: %s\n", $conn->character_set_name());
		//echo "<br/>";
	}

	// Check connection
	if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

	$city_square_type_query = "INSERT INTO city_square_type VALUES ";
	$city_square_type_values = '';
	
	$demand_curves_array = parse_demand_curves_file('demand_curves.txt');
	
	//--------------------------- city_square_type query
	for($k = 0; $k < sizeof($demand_curves_array); $k++){
		$type_name = $demand_curves_array[$k][0];
		$city_square_type_values = '';
		$city_square_type_values .= "('$type_name',";
		for($n = 0;$n < 23; $n++){
			$temp = $demand_curves_array[$k][1][$n];
			$city_square_type_values .= "$temp,";
		}
		$temp = $demand_curves_array[$k][1][23];
		$city_square_type_values .= "$temp)";
		$city_square_type_query .= $city_square_type_values;
		
		if ($conn->query($city_square_type_query) === TRUE) {
			//echo "City square type row inserted.<br/>";
		} else {
			//echo "Error inserting records: " . $conn->error;
		}
		
		$city_square_type_query = "INSERT INTO city_square_type VALUES ";
	}
	//-------------------------------------------------
	
	//------------------------------------------- city_square and square_points queries
	
	$city_square_query = "INSERT INTO city_square (population, parking_slots, centroid_x, centroid_y, type) VALUES ";
	$city_square_values = '';
	
	$point_query = "INSERT INTO square_points (city_square_ID, point_x, point_y) VALUES ";
	$point_values = array_fill(0,$max_point_queries,'');

	$number_of_squares = sizeof($polygonDataArray);
	$counter = 0 ; 
	$iteration = 0 ;
	foreach($polygonDataArray as $i => $cPolygon){
		
		
		for($j = 0;$j < sizeof($cPolygon); $j++){
			$exploded_cordinates[$j] = explode(",", $cPolygon[$j]);
		}
		$newPolygon[$i] = array_slice($exploded_cordinates,0,sizeof($cPolygon),FALSE);
		$centroid_array = getCentroid($newPolygon[$i]);
		
		$pop = $populationDataArray[$i];
		$park_slots = mt_rand($park_slots_min,$park_slots_max);
		$center_x = $centroid_array[0]; 
		$center_y = $centroid_array[1]; 
		$random_type = mt_rand(0,sizeof($demand_curves_array)-1);
		$type = $demand_curves_array[$random_type][0];
		$city_square_values .= "($pop,$park_slots,$center_x,$center_y,'$type')";
		
		if($i == ($number_of_squares-1)){
			$city_square_values .= "";
		}else{
			$city_square_values .= ",";
		}
		
		$number_of_points = sizeof($cPolygon);
		$byte_flag = 0;
		
		for($l = 0; $l < $number_of_points; $l++){
			
			$ccity_square_ID = $iteration+1; //------------its assumed that always city_square_ID is the same as $iteration+1 this does not allow to add extra city_squares with this function (auto increment must be 0) 
			$x = $newPolygon[$i][$l][0];
			$y = $newPolygon[$i][$l][1];
			$temp_b = "($ccity_square_ID,$x,$y)";
			$point_values[$counter] .= $temp_b;
			
			if(strlen($point_values[$counter]) > $max_query_values_size){ 
				$byte_flag = 1;
			}
			
			if(($i == $number_of_squares-1) && ($l == $number_of_points-1) || $byte_flag == 1){
				$counter+=1;
				$byte_flag = 0;
				
			}else{
				$point_values[$counter] .= ",";
			}
		}
		$iteration+=1;
	}
	
	$city_square_query .= $city_square_values;
	
	if ($conn->query($city_square_query) === TRUE) {
		//echo "City square rows inserted.<br/>";
	} else {
		//echo "Error inserting records: " . $conn->error;
	}
	
	foreach($point_values as $o => $pv){
		$point_query_array[$o] = $point_query.$pv;
		if(strlen($pv) > 1){
			if ($conn->query($point_query_array[$o]) === TRUE) {
				//echo "Square points rows inserted. $o <br/>";
			} else {
				//echo "Error inserting records: $o <br/>" . $conn->error;
			}
		}
	}
	/*if ($conn->query($point_query) === TRUE) {
		echo "Square points rows inserted<br/>";
	} else {
		echo "Error inserting records: " . $conn->error;
	}*/
	//----------------------------------------------------
	
	//echo "New records created successfully.<br/>";
	$conn->close();
}

?>