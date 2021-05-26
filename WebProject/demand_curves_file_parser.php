<?php
	
	function parse_demand_curves_file($file){
		
		$curves_file = file_get_contents ($file, FALSE, NULL, 0, 1000);
		$rows = explode("\n", $curves_file);
		
		for($i = 0; $i < sizeof($rows); $i++){ 
			$temp = explode(":",$rows[$i]);
			$type_name = $temp[0];
			$values = explode("|",$temp[1]);
			for($j = 0; $j < sizeof($values); $j++){
				$float_values[$j] = floatval($values[$j]); 
			}
			$exploded_data[$i] = array($type_name,$float_values);
		}
		
		return $exploded_data;
	}

?>