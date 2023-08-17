<?php

	require 'db.php';
	require 'functions.php';

	$func = new functions($conn);

	if(isset($_POST['login'])){

		$username = $conn->real_escape_string($_POST['username']);
		$password = $conn->real_escape_string($_POST['password']);

		$login = $conn->query("SELECT * FROM tblusers WHERE username = \"$username\" AND userpassword = PASSWORD(\"$password\")");

		if($login->num_rows > 0){

			$data = $login->fetch_assoc();

			$userData = $conn->query("SELECT * FROM tblhr_personalinfo a, tblaccounts b WHERE a.accid = ".$data['employeeid']." AND a.accid = b.accid");

			$syear = $func->syear();

			$userData = $userData->fetch_assoc();
			$syear = $syear->fetch_assoc();

			session_start();
			$_SESSION['user_id'] = $data['employeeid'];
			$_SESSION['username'] = $data['username'];
			$_SESSION['access'] = $userData['acctype'];
			$_SESSION['acc_stat'] = $data['activestatus'];
			$_SESSION['schoolyear'] = $syear['sy_ayid'];
			$_SESSION['fname'] = $userData['firstname'];
			$_SESSION['mname'] = $userData['middlename'];
			$_SESSION['lname'] = $userData['surname'];

			$rem = array('res'=>true);
			echo json_encode($rem);

		} else {

			$login = $conn->query("SELECT * FROM portal_users WHERE username = \"$username\" AND password = binary(\"$password\")");

			if($login->num_rows > 0){

				$data = $login->fetch_assoc();

				$userData = $conn->query("SELECT * FROM portal_users a, portal_user_details b WHERE a.userId = ".$data['userId']." AND a.userId = b.userId");

				$syear = $func->syear();

				$userData = $userData->fetch_assoc();
				$syear = $syear->fetch_assoc();

				session_start();
				$_SESSION['user_id'] = $data['userId'];
				$_SESSION['username'] = $data['username'];
				$_SESSION['access'] = $userData['acc_type'];
				$_SESSION['acc_stat'] = $data['status'];
				$_SESSION['schoolyear'] = $syear['sy_ayid'];
				$_SESSION['fname'] = $userData['firstname'];
				$_SESSION['mname'] = $userData['middlename'];
				$_SESSION['lname'] = $userData['lastname'];

				$rem = array('res'=>true);
				echo json_encode($rem);

			} else {

				$rem = array('res'=>false);
				echo json_encode($rem);

			}

		}

	} else {

		header('location:../');

	}

?>