<?php
    require '../functions/functions.php';

    $func = new functions($conn);

    $data = $func->stud_info($_SESSION['user_id']);

      if($data->num_rows > 0){  

        $data = $data->fetch_assoc();

        $fullname = $data['firstname'].' '.$data['lastname'];
        $gradeId = $data['gradeId'];
        $sectionid = $data['sectionid'];
        $TeacherId = $data['TeacherId'];

        //Select grade description
        $selgrade = $func->selectGrade($gradeId);

        if($selgrade->num_rows > 0){

          $gdata = $selgrade->fetch_assoc();

          $glevel = $gdata['description'];

        } else {

          $glevel = "";

        }


        //Select section description
        $selsection = $func->selectSection($sectionid);

        if($selsection->num_rows > 0){

          $sdata = $selsection->fetch_assoc();

          $slevel = $sdata['description'];

        } else {

          $slevel = "";

        }

      } else {

        echo $conn->error;

      }


    $subjectdet = $func->stud_subject($gradeId, $sectionid, $TeacherId);

    if($subjectdet->num_rows > 0){

      $subjectid = $subjectdet->fetch_assoc();

      $subjectid = $subjectid['subjectid'];


    } else {

      $subjectid = '';

    }


    $subject = $func->student_subject_count($gradeId);

    if($subject->num_rows > 0){

      $subcount = $subject->fetch_row();

      $subcount = $subcount[0];


    } else {

      $subcount = 0;

    }


    $modules = $func->student_module_count($gradeId);

    if($modules->num_rows > 0){

      $modcount = $modules->fetch_row();

      $modcount = $modcount[0];


    } else {

      $modcount = 0;

    }

    $syear = $func->syear();

    if($syear->num_rows > 0){

      $syear = $syear->fetch_assoc();

      $syear = $syear['description'];

    } else {

      $syear = "School Year not started";

    }

  ?>