<?php
	
	function getAreaOfPolygon($geo) {
		$area = 0;
	
		$vl=sizeof($geo);
		for ($vi=0; $vi<$vl; $vi++) {
			$thisx = $geo[ $vi ][0];
			$thisy = $geo[ $vi ][1];
			$nextx = $geo[ ($vi+1) % $vl ][0];
			$nexty = $geo[ ($vi+1) % $vl ][1];
			$area += ($thisx * $nexty) - ($thisy * $nextx);
		}

		//$area = abs(($area / 2));
		$area = $area / 2;
		/* 
		a city block should not have area 0 but if it has 
		this will save a division with 0 
		*/
		if($area==0){$area=0.00000000001;}     
		return $area;
	}

	/*
	calculate the centroid of a polygon
	return a 2-element list: array($x,$y)
	*/
	function getCentroid($geo) {
		$cx = 0;
		$cy = 0;

		$vl=sizeof($geo);
		for ($vi=0; $vi<$vl; $vi++) {
			$thisx = $geo[ $vi ][0];
			$thisy = $geo[ $vi ][1];
			$nextx = $geo[ ($vi+1) % $vl ][0];
			$nexty = $geo[ ($vi+1) % $vl ][1];

			$p = ($thisx * $nexty) - ($thisy * $nextx);
			$cx += ($thisx + $nextx) * $p;
			$cy += ($thisy + $nexty) * $p;
		}

		// last step of centroid: divide by 6*A
		$area = getAreaOfPolygon($geo);
		$cx = $cx / ( 6 * $area);
		$cy = $cy / ( 6 * $area);

		return array($cx,$cy);
	}

?>