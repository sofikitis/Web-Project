<?php

	include 'centroid.php';
	include 'dbscan_function.php';
	include 'sort_points.php';
	include 'sql_update_function.php';
	//include 'destination_calc.php';
	include 'destination_function.php';
	include 'sql_delete_queries.php';
	
	$a = $_REQUEST["a"];
	$array = json_decode($a);
	$f = $_REQUEST["f"];
	$function_name = json_decode($f);
	

	switch ($function_name) {
		case "get_centroid":
			$result = getCentroid($array);
			break;
		case "get_clusters":
			$result = get_clusters($array);
			break;
		case "sort_points":
			$result = sort_points($array);
			break;
		case "sql_update":
			$result = sql_update($array);
			break;
		case "destination":
			$result = destination($array);
			break;
		case "destination_function":
			$result = destination_function($array[0],$array[1],$array[2],$array[3]);
			break;
		case "empty_DB":
			$result = empty_DB();
			break;
		default:
			$result = "Error: function $function_name doesn't exists";
	}
	
	echo json_encode($result);
	
?>