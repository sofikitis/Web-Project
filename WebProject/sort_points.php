<?php 
	
	/*$i=0;
	$j=0;
	$array = array();
	$array_length = mt_rand(1,1);
	$counter = 0;
	for($i=0;$i<$array_length;$i++){
		$array[$i] = array();
		$sub_array_length = mt_rand(3,10);
		for($j=0;$j<$sub_array_length;$j++){
			$array[$i][$j]= array($counter,mt_rand(0,99),mt_rand(0,99));
			$counter++;
		}
	}
	print_r($array);
	echo "<br/>";
	echo "<br/>";
	sort_points($array);*/
	
	function sort_points($array){
		$i = 0;
		$j = 0;
		$al = sizeof($array);
		$ratio = array();
		$temp_array = array();
		$new_array = array();
		for($i = 0; $i < $al; $i++){
			$sal = sizeof($array[$i]);
			$avg_x = 0;
			$avg_y = 0;
			$q0 = 0;
			$q1 = 0;
			$q2 = 0;
			$q3 = 0;
			$temp_array[$i] = array();
			$new_array[$i] = array();
			$ratio[$i] = array(
				array(array()),
				array(array()),
				array(array()),
				array(array())
			);
			for($j = 0; $j < $sal; $j++){
				$avg_x += $array[$i][$j][1];
				$avg_y += $array[$i][$j][2];
			}
			$avg_x = $avg_x/$sal;
			$avg_y = $avg_y/$sal;
			for($j = 0; $j < $sal; $j++){
				$point_x = $array[$i][$j][1];
				$point_y = $array[$i][$j][2];
				if($point_x>=$avg_x && $point_y>$avg_y){
					$a = abs($point_x - $avg_x);
					$b = abs($point_y - $avg_y);
					$ratio[$i][0][$q0] = array($array[$i][$j][0],($a/$b));
					$q0++;
				}elseif($point_x>$avg_x && $point_y<=$avg_y){
					$a = abs($point_x - $avg_x);
					$b = abs($point_y - $avg_y);
					if($b==0){
						$b=0.0000005;//--------
					}
					$ratio[$i][1][$q1] = array($array[$i][$j][0],($a/$b));
					$q1++;
				}elseif($point_x<=$avg_x && $point_y<$avg_y){
					$a = abs($point_x - $avg_x);
					$b = abs($point_y - $avg_y);
					$ratio[$i][2][$q2] = array($array[$i][$j][0],($a/$b));
					$q2++;
				}elseif($point_x<$avg_x && $point_y>=$avg_y){
					$a = abs($point_x - $avg_x);
					$b = abs($point_y - $avg_y);
					if($b==0){
						$b=0.0000005;//--------
					}
					$ratio[$i][3][$q3] = array($array[$i][$j][0],($a/$b));
					$q3++;
				}elseif($point_x==$avg_x && $point_y==$avg_y){
					$ratio[$i][0][$q0] = array($array[$i][$j][0],0);
					$q0++;
				}
			}
			if($q0>0){
				usort($ratio[$i][0],function ($a, $b){
					if($a[1]<$b[1]) return -1; 
					if($a[1]>$b[1]) return 1;
					if($a[1]==$b[1]) return 0;
				});
			}
			if($q1>0){
				usort($ratio[$i][1],function ($a, $b){
					if($a[1]<$b[1]) return 1; 
					if($a[1]>$b[1]) return -1;
					if($a[1]==$b[1]) return 0;
				});
			}
			if($q2>0){
				usort($ratio[$i][2],function ($a, $b){
					if($a[1]<$b[1]) return -1; 
					if($a[1]>$b[1]) return 1;
					if($a[1]==$b[1]) return 0;
				});
			}
			if($q3>0){
				usort($ratio[$i][3],function ($a, $b){
					if($a[1]<$b[1]) return 1; 
					if($a[1]>$b[1]) return -1;
					if($a[1]==$b[1]) return 0;
				});
			}
			//print_r($ratio[$i]);
			$temp_array[$i] = array_merge(
				($q0>0)?$ratio[$i][0]:array(),($q1>0)?$ratio[$i][1]:array(),($q2>0)?$ratio[$i][2]:array(),($q3>0)?$ratio[$i][3]:array()
			);
			
			$k = 0;
			$index = -1;
			for($j = 0; $j < $sal; $j++){
				for($k = 0; $k < $sal; $k++){
					if($temp_array[$i][$j][0]==$array[$i][$k][0]){$index = $k;}
				}
				$new_array[$i][$j] = $array[$i][$index];
			}
		}
		//print_r($new_array);
		return $new_array;
	}
		
	/*function my_sort($a,$b){
		if ($a==$b) return 0;
		return ($a<$b)?-1:1;
	}*/

?>