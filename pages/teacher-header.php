<?php 

    require '../functions/functions.php';

    $func = new functions($conn);

    $data = $func->user_info($_SESSION['user_id']);

      if($data->num_rows > 0){  

        $data = $data->fetch_assoc();

        $fullname = $data['firstname'].' '.$data['surname'];
        //$fullname = $data['accname'];

      } else {

        echo $conn->error;

      }

    $subject = $func->subject_count();

    if($subject->num_rows > 0){

      $subcount = $subject->fetch_row();

      $subcount = $subcount[0];


    } else {

      $subcount = 0;

    }


    $student = $func->stud_count();

    if($student->num_rows > 0){

      $studcount = $student->fetch_row();

      $studcount = $studcount[0];


    } else {

      $studcount = 0;

    }


    $classCount = $func->classCount();

    if($classCount->num_rows > 0){

      $classCount = $classCount->fetch_row();

      $classCount = $classCount[0];


    } else {

      $classCount = 0;

    }

    $syear = $func->syear();

    if($syear->num_rows > 0){

      $syear = $syear->fetch_assoc();

      $syear = $syear['description'];

    } else {

      $syear = "School Year not started";

    }


    //echo $_SESSION['user_id'];
    //echo $_SESSION['schoolyear'];

?>