<?php
	
	include 'sql_select.php';
	
	function demand_curves_save(){
		$file_mame = "demand_curves.txt";
		
		$array = sql_select("*", "city_square_type", "1", $servername, $username, $password, $dbname);

		$file_pointer = fopen($file_mame,"w");
		$max_rows = sizeof($array);
		foreach($array as $i => $val){
			$values_string = implode("|",array_slice($val,1));
			$temp_array = array($val['name'],$values_string);
			$final_format = implode(":",$temp_array);
			fwrite($file_pointer,$final_format);
			if(!($i == $max_rows-1)){
				fwrite($file_pointer,"\n");
			}
		}
		fclose($file_pointer);
	}
	
?>