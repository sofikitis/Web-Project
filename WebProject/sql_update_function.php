<?php
	
	function sql_update($query){
		
		$conn = mysqli_connect("localhost", "root", "", "web_project");
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		mysqli_set_charset($conn, "utf8");
		
		$sql = $query;
		
		if (mysqli_query($conn, $sql)) {
			$result = "Success";
		} else {
			$result = "Οι τιμές που εισάγατε δεν είναι ορθές. Ελέγξτε την ορθογραφία ή τον τύπο της τιμής.";
		}
		
		mysqli_close($conn);
		return $result;
		
	}

?>