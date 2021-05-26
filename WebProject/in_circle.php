<?php

	/*$circle = array(0,0);
	$point = array(1,0);
	$area = 0.9;
	
	$check = in_circle($circle, $point, $area);
	$msg = "";
	if($check){$msg = "true";}
	if(!$check){$msg = "false";}
	print_r($msg);*/
	
	function in_circle($circle_center,$point,$area){
			
			$flag = false; 
			$x = abs($circle_center[0]-$point[0]);
			$y = abs($circle_center[1]-$point[1]);
			$distance = sqrt($x**2 + $y**2);
			if($distance <= $area){$flag = true;}
			return $flag;
			
	}

?>