<?php

	if(!empty($_POST['data'])){
		$data = $_POST['data'];
		$fname = "timelapse.txt";

		$file = fopen($fname, 'w');//creates new file
		fwrite($file, $data);
		fclose($file);
	}

?>