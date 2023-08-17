<?php

	require 'functions.php';

	if(isset($_POST['updatez'])){

		$pass = $conn->real_escape_string($_POST['pass']);
		$userid = $conn->real_escape_string($_POST['userid']);

		$updatePass = $conn->query("UPDATE portal_users SET password =\"$pass\" WHERE userid = \"$userid\"");

		if($updatePass == true){

			$message = true;
			echo json_encode($message);

		} else {

			$message = false;
			echo json_encode($message);

		}

	} else {

		$message = false;
		echo json_encode($message);

	}

?>