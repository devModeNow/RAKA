<?php

	session_start();

	if(isset($_SESSION['user_id'])){

		if($_SESSION['acc_stat'] == 1){

			if($_SESSION['access'] == 1){

				require 'teacher.php';

			} elseif($_SESSION['access'] == 2) {

				require 'student.php';

			} else {

				header('location:../inactive.php');
				//echo 'nani';

			}

		} else {

			header('location:../inactive.php');

		}

	} else {

		header('location:../404.php');

	}

?>

