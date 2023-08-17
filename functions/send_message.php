<?php
	
	if(isset($_POST['send'])){

		session_start();

		require 'functions.php';

		$func = new functions($conn);

		$id = $conn->real_escape_string($_POST['id']);
		$userID = $conn->real_escape_string($_SESSION['user_id']);
		$message = $conn->real_escape_string($_POST['message']);
		$datez	= date("m-d-y h:i:s A");

		$selMessage = $conn->query("SELECT * FROM portal_messaging WHERE fromrecepient = \"$id\" AND torecepient = \"$userID\" OR fromrecepient = \"$userID\" AND torecepient = \"$id\" AND exchange != 0 AND messagestat != 0 ORDER BY id ASC");
		$exchangeData = $selMessage->fetch_assoc();

		if($exchangeData['exchange'] == 0 && $exchangeData['fromrecepient'] == $userID){

			$exchange = 0;

		} elseif($exchangeData['exchange'] == 0 && $exchangeData['fromrecepient'] == $id){

			$exchange = 1;

		} else {

			$exchange = 0;

		}

		$send = $func->send_message($id, $userID, $message, $exchange, $datez);

		if($send){

			$message = true;

		} else {

			$message = false;

		}

	} else {

		$message = false;

	}
	echo json_encode($message);


?>