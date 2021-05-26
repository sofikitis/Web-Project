<?php

	include 'dbscan.php';

	function get_clusters($points){
		$distance_matrix = calculate_distance_matrix($points);
		$array_length = sizeof($points);
			
		for($i = 0; $i < $array_length; $i++){
			$point_ids[$i]=$points[$i][0];
		}
			
		// Setup DBSCAN with distance matrix and unique point IDs
		$DBSCAN = new DBSCAN($distance_matrix, $point_ids);
		$epsilon = 0.0005; //-----
		$minpoints = 2;

		// Perform DBSCAN clustering
		$clusters = $DBSCAN->dbscan($epsilon, $minpoints);
		return $clusters;
	}

	function calculate_distance_matrix($points){
		
		//distance array init 2d
		//$distance = [];
		
		$max_points = sizeof($points);
		$distance = array_fill(0,$max_points,array_fill(0,$max_points,0));
		$i=0;
		$j=0;
		
		//distance upper triangular 
		for($i = 0; $i < $max_points-1; $i++){
			for($j = $i+1; $j < $max_points; $j++){
				//if($j<=$i){
					//$distance[$i][$j]=0;
				//}else{
				$distance[$i][$j] = sqrt(abs($points[$i][1] - $points[$j][1])**2 + abs($points[$i][2] - $points[$j][2])**2);
				//}
			}
		}
		//$distance[$max_points-1] = array_fill(0,$max_points,0);
		return $distance;
		
	}

?>