<?php

	$conn = new mysqli('127.0.0.1','root','','school');
	// $conn = new mysqli('127.0.0.1','TniLC','TniLC2019','school');

	if(!$conn->connect_errno > 0){

		//echo 'Database Connected Successfully';

	} else {

		echo 'Failed to connect '.$conn->error;

	}

?>