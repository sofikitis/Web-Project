<?php

	include 'sql_insert_queries_bulk.php';
	

	//Change post_max_size in php.ini to accept file>8M
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	echo '<br/>Begin Script <br/><hr/>';


	$polygonDataArray 	 = array();
	$populationDataArray = array();

	if( empty($_FILES["fileToUpload"]["name"]) ){	

		$kml = simplexml_load_file('mykmlFile.kml');

	}else{

		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;

		$kmlFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		if($kmlFileType != "kml" ) {
			echo "Sorry, only KML files are allowed.";
			$uploadOk = 0;
		}	
		
		move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],"uploads/".$_FILES["fileToUpload"]["name"]);
		$t = "uploads/" . $_FILES["fileToUpload"]["name"];
		$kml = simplexml_load_file($t);

	}

	foreach($kml->Document->Folder->Placemark as $pm){
	 
		if(isset($pm->MultiGeometry->Polygon) || isset($pm->MultiGeometry->MultiGeometry->Polygon)){
			
			//Process population data
			$populationTag = $pm->description;
			$populationStr = strip_tags($populationTag);
			$populationVal = strstr($populationStr, 'Population: ');	
			$populationArr = explode('Population: ', $populationVal);
			
			if( isset($populationArr[1]) ){
				$populationFNL = $populationArr[1];
			}else{
				$populationFNL = 0;
			}
			
			//Process polygon data	
			if( isset($pm->MultiGeometry->Polygon) ){
				
				$coordinates = $pm->MultiGeometry->Polygon->outerBoundaryIs->LinearRing->coordinates;
				
			}else{
				
				$coordinates = $pm->MultiGeometry->MultiGeometry->Polygon->outerBoundaryIs->LinearRing->coordinates;
				
			}
			
			
			
			//Process polygon data	
			$cordsData   = trim(((string) $coordinates));

			// check if coordinate data is available
			if(isset($cordsData) && !empty($cordsData)){
						
				$explodedData = explode("\n", $cordsData);
				$explodedData = array_map('trim', $explodedData);

				// next for each of the points build the polygon data    
				$points = "";
					
				
				foreach ($explodedData as $index => $coordinateString) {
					$coordinateSet = array_map('trim', explode(' ', $coordinateString));
				}

				array_push($polygonDataArray, $coordinateSet);
				array_push($populationDataArray, $populationFNL);
				
			}
		}
	}

	if( !empty($kml) ){
		//print_r($polygonDataArray);
		//print_r($populationDataArray);
	}else{
		echo "<br/>Please upload a KML file.<br/>";
	}


	$txtFileBlock = fopen('parsedPolygonData.txt', 'w');
	$txtFilePopul = fopen('parsedPopultionData.txt', 'w');

	fwrite($txtFileBlock, print_r($polygonDataArray, TRUE));
	fwrite($txtFilePopul, print_r($populationDataArray, TRUE));

	fclose($txtFileBlock);
	fclose($txtFilePopul);

	//insert_in_DB("localhost" ,"root" ,"" ,"web_project" ,$polygonDataArray ,$populationDataArray);//----for testing
	insert_values_in_DB("localhost" ,"root" ,"" ,"web_project" ,$polygonDataArray ,$populationDataArray);

?>