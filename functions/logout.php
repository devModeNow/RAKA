<?php
	
	session_start();

	if(isset($_SESSION['user_id'])){

		@session_unset($_SESSION['user_id']);
		@session_unset($_SESSION['username']);
		@session_unset($_SESSION['access']);
		session_destroy();

		header('location:../');

	} else {

		header('location:../404.php');

	}

?>