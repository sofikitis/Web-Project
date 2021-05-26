<?php

	/*include 'dbscan_function.php'; //40.642615 22.928309
	include 'sort_points.php';
	include 'centroid.php';
	
	$output = destination_function(40.642615,22.928309,120,"h12");
	echo "result:<br/>";
	print_r($output);
	echo "<br/>";*/
	
	function destination_function($circle_ltd,$circle_lng,$range,$time){ 
	
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "web_project";

		$conn = mysqli_connect($servername, $username, $password, $dbname);
		if(!$conn){
			die("Connection failed: " . mysqli_connect_error());
		}
			
		if(!$conn->set_charset("utf8")){
			//printf("Error loading character set utf8: %s\n", $conn->error);
			//echo "<br/>";
		}//else{
			//printf("Current character set: %s\n", $conn->character_set_name());
			//echo "<br/>";
		//}
			
		$sql = "SELECT city_square.square_ID, city_square.population, city_square.parking_slots,
			city_square_type.".$time.", city_square.centroid_x, city_square.centroid_y
			FROM city_square 
			INNER JOIN city_square_type ON city_square.type = city_square_type.name ORDER BY city_square.square_ID";
			
		$result = mysqli_query($conn, $sql);
			
		if (mysqli_num_rows($result) > 0) {
			$city_squares = array();
				// output data of each row
			$iter = 0;
			while($row = mysqli_fetch_assoc($result)) {
				$city_squares[$iter] = $row;
				$iter++;
			}
		} else {
			echo "0 results";
		}
				
		mysqli_close($conn);
			
		$csal = sizeof($city_squares);
		
		$in_circle = array();
		$i = 0;
		$in_index = 0;
		for($i = 0; $i < $csal; $i++){
			
			$parking_slots = $city_squares[$i]["parking_slots"];
			$taken_slots = $city_squares[$i]["population"]*0.20 + $parking_slots*$city_squares[$i]["$time"];
			if($taken_slots>$parking_slots){
				$available_slots = 0;
			}else{
				$available_slots = floor($parking_slots - $taken_slots);
			}	
			
			if(measure($circle_ltd, $circle_lng, $city_squares[$i]["centroid_y"],$city_squares[$i]["centroid_x"]) <= $range){
				$in_circle[$in_index] = array($city_squares[$i]["centroid_y"],$city_squares[$i]["centroid_x"],$available_slots);
				$in_index++;				
			}
			
		}
		
		$ical = sizeof($in_circle);
		if($ical==0){
			return -1;
		}
		$sum = 0;
		for($j = 0; $j < $ical; $j++){
			$sum+=$in_circle[$j][2];
		}
		if($sum == 0){
			return -1;
		}
		$index = 0;
		$points = array();
		$degrees_to_m_ltd = abs($circle_ltd + 26118.11897637629)/0.2362204724409298;
		$degrees_to_m_lng = (90-abs($circle_ltd))/0.0006264727948904; //0.0008084727948904
		$offset_ltd = 50/$degrees_to_m_ltd;
		$offset_lng = 50/$degrees_to_m_lng;
		//$time_start = microtime(true);
		for($j = 0; $j < $ical; $j++){
			
			for($i = 0; $i < $in_circle[$j][2]; $i++){
				$max = $in_circle[$j][0]+$offset_ltd;
				$min = $in_circle[$j][0]-$offset_ltd;
				$Ltd = mt_rand()/mt_getrandmax() * ($max-$min) + $min;
				$R = (1-abs($Ltd-$in_circle[$j][0])/abs($max-$in_circle[$j][0]))*abs($offset_ltd - $offset_lng) + $offset_ltd;
				$temp_x = sqrt(abs($R**2 - ($Ltd-$in_circle[$j][0])**2));
				$temp_x = $temp_x + $in_circle[$j][1];
				$max = $temp_x; 
				$min = 2*$in_circle[$j][1] - $temp_x;
				$Lng = mt_rand()/mt_getrandmax() * ($max-$min) + $min;
				$points[$index] = array($index,$Ltd,$Lng);
				$index++;
			}
			
		}
		//$time_end = microtime(true);
		//$execution_time = ($time_end - $time_start);
		//print_r($execution_time);

		$clusters = get_clusters($points);
		$index_of_max = array();
		$size_of_index = 0;
		$max = sizeof($clusters[0]);
		$index_of_max[$size_of_index] = 0;
		$array_size = sizeof($clusters);
		for($i = 1;$i < $array_size; $i++){
			if( sizeof($clusters[$i]) > $max ){
				$max = sizeof($clusters[$i]);
				$size_of_index = 0;
				$index_of_max = array();
				$index_of_max[$size_of_index] = $i;
			}elseif(sizeof($clusters[$i]) == $max){
				$size_of_index++;
				$index_of_max[$size_of_index] = $i; 
			}
		}
		
		$max_clusters = array(array());
		$number_of_maxs = sizeof($index_of_max);
		for($j = 0; $j < $number_of_maxs; $j++){
			$array_size = sizeof($clusters[$index_of_max[$j]]);
			for($i = 0; $i < $array_size; $i++){
				$max_clusters[$j][$i] = $points[$clusters[$index_of_max[$j]][$i]];
			}
		}
		
		$p_array = array(array());
		$p_array = $max_clusters;
		
		$max_clusters = sort_points($p_array);
		
		$max_clusters_raw = array(array());
		
		for($i=0;$i<$number_of_maxs;$i++){
			$array_size = sizeof($max_clusters[$i]);
			for($j = 0;$j < $array_size; $j++){
				$max_clusters_raw[$i][$j] = array($max_clusters[$i][$j][1],$max_clusters[$i][$j][2]);
			}
		}
		
		$destinations = array();
		for($i=0;$i<$number_of_maxs;$i++){
			$destinations[$i] = getCentroid($max_clusters_raw[$i]);
		}
		return $destinations;
	}
	
	function measure($lat1, $lon1, $lat2, $lon2){
		$R = 6378.137; // Radius of earth in KM
		$dLat = $lat2 * pi() / 180 - $lat1 * pi() / 180;
		$dLon = $lon2 * pi() / 180 - $lon1 * pi() / 180;
		$a =sin($dLat/2) * sin($dLat/2) + cos($lat1 * pi() / 180) * cos($lat2 * pi() / 180) * sin($dLon/2) * sin($dLon/2);
		$c = 2 * atan2(sqrt($a), sqrt(1-$a));
		$d = $R * $c;
		return $d * 1000; // meters
	}

?>