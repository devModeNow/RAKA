<?php

  session_start();
  //error_reporting(0);

  if(isset($_SESSION['user_id'])){

    require 'student-header.php';


?>

  <?php require 'header.php'; ?>

  <style>
      
      .mods{
        position:relative;
        display:inline-table;
      }

  </style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-10">
            <h5 class="m-0 alert alert-success">Subjects</h5>
          </div><!-- /.col -->
          <div class="col-sm-2">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Subjects</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          
          <?php

          $subjectsdetails = $func->stud_subject($gradeId, $sectionid, $TeacherId);

          if($subjectsdetails->num_rows > 0){

            while($subdesc = $subjectsdetails->fetch_assoc()){

          ?>
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="fa fa-book"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><?= $subdesc['description'] ?></span>
                <span class="info-box-number"> <a href="?gkey=<?= $subdesc['gradeid'] ?>&seckey=<?= $subdesc['sectionid'] ?>&subkey=<?= $subdesc['subjectid'] ?>" class="btn btn-xs btn-info"> View Modules </a> </span>
                <span class="info-box-number"> <a href="?gkey=<?= $subdesc['gradeid'] ?>&seckey=<?= $subdesc['sectionid'] ?>&quizkey=<?= $subdesc['subjectid'] ?>"class="btn btn-xs btn-danger"> View Quizzes </a> </span>
                <span class="info-box-number"> <a href="?gkey=<?= $subdesc['gradeid'] ?>&seckey=<?= $subdesc['sectionid'] ?>&taskkey=<?= $subdesc['subjectid'] ?>"class="btn btn-xs btn-success"> View Task </a> </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        <?php 

            }

          } else {

        ?>

          <div class="col-12">
            <div>
              <h3 class="alert alert-info text-center"> You Have No Subject </h3>
            </div>
            <!-- /.info-box -->
          </div>

        <?php } ?>
        </div><hr>
        <!-- /.row -->
        <?php 

          //Module's
          if(isset($_GET['subkey']) && isset($_GET['gkey'])){

            $user_id = $_SESSION['user_id'];

            $gradeid = $conn->real_escape_string($_GET['gkey']);
            $seckey = $conn->real_escape_string($_GET['seckey']);
            $subId = $conn->real_escape_string($_GET['subkey']);
            $acctype = "2";

            $modId = 'module_'.rand(2,12345);

            $subDet = $func->subject_details($gradeid, $subId);

            $value = $subDet->fetch_assoc();

            $filename = "Algebra Expressions";

            if(isset($_POST['uploadFile'])){

              $filename = $conn->real_escape_string($_POST['filename']);

              $target_dir = "../uploads/modules/";
              $target_file = $target_dir . basename($_FILES["file"]["name"]).rand(4,6541324);
              $uploadOk = 1;
              $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

              if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){

                $insert = $conn->query("INSERT INTO portal_modules (gradeid,sectionid,subjectid,moduleId,filename,filepath,uploadedby,acctype)
                                        VALUES (\"$gradeid\",\"$seckey\",\"$subId\",\"$modId\",\"$filename\",\"$target_file\",\"$user_id\",\"$acctype\")");

                if($insert == true){

                  echo '<script>alert("Module Uploaded")</script>';

                } else {

                  echo 'Error '.$conn->error;

                }

              } else {

                echo 'Error Uploading File';
                echo '<script>alert("Error Uploading File "'.$conn->error.')</script>';

              }

            } else {

              

            }

        ?>
        <div class="row">
          <div class="col-md-12">
            <h5 class="alert alert-info"> <?= $value['description'] ?> Modules </h5>
          <?php

          $subId = $conn->real_escape_string($_GET['subkey']);
          $seckey = $conn->real_escape_string($_GET['seckey']);

          $modulesdetails = $func->module_details($subId, $seckey);

          $filename = "";

          if($modulesdetails->num_rows > 0){

            while($modesc = $modulesdetails->fetch_assoc()){

              $filename = $modesc['filename'];

          ?>
            <div class="col-lg-3 col-6 mods">
              <!-- small card -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h5><?= $modesc['filename'] ?></h5><br><br>
                </div>
                <div class="icon">
                  <i class="fa fa-file"></i>
                </div>
                <a href="<?= $modesc['filepath'] ?>" target="_blank" class="small-box-footer">
                  View File <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
          <?php

            }

          ?>
        </div><br>
        </div><hr>
        <!--<h5 class="alert alert-info"> Upload Assignment Module </h5>
        <form action="" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-lg-6">
              <input type="text" class="form-control" value="" name="filename" placeholder="Filename Eg. Response for module name and fullname" required>
            </div>
            <div class="col-lg-6">
              <input type="file" required class="form-control" name="file" id="exampleInputFile">
            </div>
          </div><br>
          <div class="row">
            <div class="col-lg-12 text-right">
              <input type="submit" name="uploadFile" value="Upload File" class="btn btn-sm btn-success">
            </div>
          </div>
        </form><br>-->

          <?php

          } else {

          ?>

            <h5> No Module Uploaded in this subject </h5>

          <?php

          }

       } //End for modules  ?>



        <?php 

          //Quizzes
          if(isset($_GET['quizkey']) && isset($_GET['gkey'])){

            $user_id = $_SESSION['user_id'];

            $gradeid = $conn->real_escape_string($_GET['gkey']);
            $seckey = $conn->real_escape_string($_GET['seckey']);
            $subId = $conn->real_escape_string($_GET['quizkey']);
            $acctype = "2";
            $qupload_message = "";

            $qtype = "respondent";

            @$quiId = $conn->real_escape_string($_GET['qId']);

            $subDet = $func->subject_details($gradeid, $subId);

            $value = $subDet->fetch_assoc();

            $filename = "Algebra Expressions";

            if(isset($_POST['uploadFile'])){

              $filename = $conn->real_escape_string($_POST['filename']);

              $checkDuplexSubmision = $conn->query("SELECT * FROM portal_quizzes WHERE 
                                                    gradeid = \"$gradeid\" AND sectionid = \"$seckey\" AND subjectid = \"$subId\" AND quizzId = \"$quiId\" AND uploadedby = \"$user_id\" AND quiztype = \"$qtype\" AND stat = \"1\" OR
                                                    gradeid = \"$gradeid\" AND sectionid = \"$seckey\" AND subjectid = \"$subId\" AND quizzId = \"$quiId\" AND uploadedby = \"$user_id\" AND quiztype = \"$qtype\" AND stat = \"2\"");

              if($checkDuplexSubmision->num_rows <= 0){

                $file = $_FILES["file"];

                foreach ($file['name'] as $main => $filenamez) {
                  
                $target_dir = "../uploads/quizzes/";
                $target_file = $target_dir.rand(4,1236845).$file["name"][$main];
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                  if(move_uploaded_file($_FILES["file"]["tmp_name"][$main], $target_file)){

                    $insert = $conn->query("INSERT INTO portal_quizzes (gradeid,sectionid,subjectid,quizzId,filename,filepath,uploadedby,acctype, quiztype)
                                            VALUES (\"$gradeid\",\"$seckey\",\"$subId\",\"$quiId\",\"$filename\",\"$target_file\",\"$user_id\",\"$acctype\",\"$qtype\")");

                    if($insert == true){

                      $qupload_message = '<script>alert("Quiz Answer File Uploaded")</script>';

                    } else {

                      echo 'Error '.$conn->error;

                    }

                  } else {

                    $qupload_message = 'Error Uploading File';
                    $qupload_message = '<script>alert("Error Uploading File "'.$conn->error.')</script>';

                  }

                }

              } else {

                $qupload_message = '<script>alert("Oops! It seems like you already uploaded your answer. Please message or contact your teacher If you need some changes. Thank you.")</script>';

              }

              echo $qupload_message;

            } else {

              

            }

        ?>
        <div class="row">
          <div class="col-md-12">
            <h5 class="alert alert-danger"> <?= $value['description'] ?> Quizzes </h5>
          <?php
          $gradeid = $conn->real_escape_string($_GET['gkey']);
          $subId = $conn->real_escape_string($_GET['quizkey']);
          $seckey = $conn->real_escape_string($_GET['seckey']);

          $modulesdetails = $func->quiz_details($subId, $seckey);

          $filename = "";

          if($modulesdetails->num_rows > 0){

            while($modesc = $modulesdetails->fetch_assoc()){

              if($modesc['stat'] == 1){

                $quizStat = '<label> Quiz Status: <i class="text-yellow"> Open </i> </label>';

              } else {

                $quizStat = '<label> Quiz Status: <i class="text-danger"> Close </i> </label>';
                
              }

              $filename = $modesc['filename'];

          ?>
            <div class="col-lg-3 col-sm-12 mods">
              <!-- small card -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h5><?= $modesc['filename'] ?></h5>
                  <?= $quizStat ?><br>
                </div>
                <div class="icon">
                  <i class="fa fa-file"></i>
                </div>
                <a href="<?= $modesc['filepath'] ?>" target="_blank" class="small-box-footer">
                  View Quiz File <i class="fas fa-arrow-circle-right"></i>
                </a>
                <a href="?gkey=<?= $gradeid ?>&seckey=<?= $seckey ?>&quizkey=<?= $subId ?>&qId=<?= $modesc['quizzId'] ?>&#qres" class="small-box-footer">
                  Upload/View Answer File <i class="fas fa-upload"></i>
                </a>
              </div>
            </div>
          <?php

            }

          ?>
        </div><br>
        </div><hr>

        <!-- Answer Uploaded -->
        <?php

          if(isset($_GET['qId'])){

            $user_id = $_SESSION['user_id'];
            $gradeid = $conn->real_escape_string($_GET['gkey']);
            $subId = $conn->real_escape_string($_GET['quizkey']);
            $seckey = $conn->real_escape_string($_GET['seckey']);
            @$id = $conn->real_escape_string($_GET['qId']);

            $qdet = $conn->query("SELECT * FROM portal_quizzes WHERE quizzId = \"$id\" AND quiztype = \"creator\"");

            if($qdet->num_rows > 0){

              $qname = $qdet->fetch_assoc();

              $qnamez = $qname['filename'];
              $qstat = $qname['stat'];

            } else {

              $qname = "";

            }

        ?>

        <div class="row">
          <div class="col-md-12">
            <h5 class="alert alert-danger"> Answer Uploaded for <i class="text-yellow"><?= $qnamez ?></i> </h5>
          <?php

          $answersdetails = $conn->query("SELECT * FROM portal_quizzes WHERE
                                          gradeid = \"$gradeid\" AND sectionid = \"$seckey\" AND subjectid = \"$subId\" AND quizzId = \"$id\" AND uploadedby = \"$user_id\" AND quiztype = \"respondent\" AND stat = \"1\" OR
                                          gradeid = \"$gradeid\" AND sectionid = \"$seckey\" AND subjectid = \"$subId\" AND quizzId = \"$id\" AND uploadedby = \"$user_id\" AND quiztype = \"respondent\" AND stat = \"2\"");

          $filename = "";

          if($answersdetails->num_rows > 0){

            while($ansdesc = $answersdetails->fetch_assoc()){

              $ansid = $ansdesc['id'];

              $CFile = $conn->query("SELECT * FROM portal_quizzes WHERE id = \"$ansid\" AND quizzId = \"$id\" AND uploadedby = \"$user_id\" AND quiztype = \"checked\"");

              if($CFile->num_rows > 0){

                  $file = $CFile->fetch_assoc();

                  $CFileRes = '<a href="'.$file['filepath'].'" target="_blank" class="small-box-footer">View Checked File <i class="fas fa-arrow-circle-right"></i></a>';

              } else {

                  $CFileRes = '';

              }

              $filename = $ansdesc['filename'];

              $stat = $ansdesc['stat'];

              if($stat == 1){

                $ansstat = '<label> Answer Status: <i class="text-yellow"> Not Checked </i> </label>';
                $quizdelBut = '<a href="?gkey='.$_GET['gkey'].'&seckey='.$_GET['seckey'].'&quizkey='.$_GET['quizkey'].'&qId='.$_GET['qId'].'&delQKey='.$_GET['qId'].'&ansId='.$ansdesc['id'].'" class="small-box-footer">
                      Delete Answer File <i class="fas fa-trash"></i>
                    </a>'; 

              } else {

                $ansstat = '<label> Answer Status: <i class="text-suucess"> Checked </i> </label>';
                $quizdelBut = "";

              }

              //Delete Quiz
                if(isset($_GET['delQKey'])){

                    $delid = $conn->real_escape_string($_GET['delQKey']);
                    $answerID = $conn->real_escape_string($_GET['ansId']);
                    $userid = $_SESSION['user_id'];

                    $delyt = $conn->query("DELETE FROM portal_quizzes WHERE id = \"$answerID\" AND quizzId = \"$delid\" AND uploadedby = \"$userid\" AND quiztype = \"respondent\"");

                    if($delyt){
    
                        echo '<script>alert("Quiz Deleted Successfuly");location.href="?gkey='.$_GET['gkey'].'&seckey='.$_GET['seckey'].'&quizkey='.$_GET['quizkey'].'&qId='.$_GET['qId'].'"</script>';
                        //echo 'Deleted ' .$delid.' '.$userid.' '.$conn->error;

                    } else {

                        echo $conn->error;
    
                    }
    
                }
              // End for Delete Quiz

          ?>
            <div class="col-lg-3 col-sm-12 mods">
              <!-- small card -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h5> Answer for: <?= $ansdesc['filename'] ?></h5><br>
                  <?= $ansstat ?>
                </div>
                <div class="icon">
                  <i class="fa fa-file"></i>
                </div>
                <a href="<?= $ansdesc['filepath'] ?>" target="_blank" class="small-box-footer">
                  View Answer File <i class="fas fa-arrow-circle-right"></i>
                </a>
                <?= $quizdelBut ?>
                <?= $CFileRes ?>
              </div>
            </div>
          <?php

            }

          } else {

          ?>

            <h5> You don't have any answers uploaded for this quiz yet. Upload your answer now. </h5>

          <?php

          }

          ?>
        </div><br>
        </div><hr>


        <?php

            if($qstat == 1){

        ?>
          <h5 id="qres" class="alert alert-danger"> Upload Quiz Response for <i class="text-yellow"> <?= $qnamez ?> </i> </h5>
          <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
              <div class="col-lg-6">
                <input type="hidden" class="form-control" value="<?= $qnamez ?>" name="filename" placeholder="Filename Eg. Response for module name and fullname" required>
              </div>
              <div class="col-lg-12">
                <input type="file" multiple required class="form-control" name="file[]" id="exampleInputFile">
              </div>
            </div><br>
            <div class="row">
              <div class="col-lg-12 text-right">
                <input type="submit" name="uploadFile" value="Upload File" class="btn btn-sm btn-success">
              </div>
            </div>
          </form><br>

          <?php

              } else {

          ?>

              <label> Uploading of answer file is not available when quiz is already closed. Thank you. </label><hr>

          <?php

              }

            }  

          } else {

          ?>

            <h5> No Quizzes Uploaded in this subject </h5>

          <?php

          }

       } //End for Quiz


          //Performance Task
          if(isset($_GET['taskkey']) && isset($_GET['gkey'])){

            $user_id = $_SESSION['user_id'];

            $gradeid = $conn->real_escape_string($_GET['gkey']);
            $seckey = $conn->real_escape_string($_GET['seckey']);
            $subId = $conn->real_escape_string($_GET['taskkey']);
            $acctype = "2";
            $tupload_message = "";

            $qtype = "respondent";

            @$quiId = $conn->real_escape_string($_GET['qId']);

            $subDet = $func->subject_details($gradeid, $subId);

            $value = $subDet->fetch_assoc();

            $filename = "Algebra Expressions";

            if(isset($_POST['uploadFile'])){

              $filename = $conn->real_escape_string($_POST['filename']);

              $checkDuplexSubmision = $conn->query("SELECT * FROM portal_performance_task WHERE 
                                                    gradeid = \"$gradeid\" AND sectionid = \"$seckey\" AND subjectid = \"$subId\" AND quizzId = \"$quiId\" AND uploadedby = \"$user_id\" AND quiztype = \"$qtype\" AND stat = \"1\" OR
                                                    gradeid = \"$gradeid\" AND sectionid = \"$seckey\" AND subjectid = \"$subId\" AND quizzId = \"$quiId\" AND uploadedby = \"$user_id\" AND quiztype = \"$qtype\" AND stat = \"2\"");

              if($checkDuplexSubmision->num_rows <= 0){

                $file = $_FILES["file"];

                foreach ($file['name'] as $main => $filenamez) {

                $target_dir = "../uploads/performance tasks/";
                $target_file = $target_dir .rand(4,6154854).$file["name"][$main];
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                  if(move_uploaded_file($_FILES["file"]["tmp_name"][$main], $target_file)){

                    $insert = $conn->query("INSERT INTO portal_performance_task (gradeid,sectionid,subjectid,quizzId,filename,filepath,uploadedby,acctype, quiztype)
                                            VALUES (\"$gradeid\",\"$seckey\",\"$subId\",\"$quiId\",\"$filename\",\"$target_file\",\"$user_id\",\"$acctype\",\"$qtype\")");

                    if($insert == true){

                      $tupload_message = '<script>alert("Tasks Answer File Uploaded")</script>';

                    } else {

                      $tupload_message = 'Error '.$conn->error;

                    }

                  } else {

                    $tupload_message = 'Error Uploading File';
                    $tupload_message = '<script>alert("Error Uploading File "'.$conn->error.')</script>';

                  }

                }

              } else {

                $tupload_message = '<script>alert("Oops! It seems like you already uploaded your task. Please message or contact your teacher If you need some changes. Thank you.")</script>';

              }

              echo $tupload_message;

            } else {

              

            }

        ?>
        <div class="row">
          <div class="col-md-12">
            <h5 class="alert alert-success"> <?= $value['description'] ?> Tasks </h5>
          <?php
          $gradeid = $conn->real_escape_string($_GET['gkey']);
          $subId = $conn->real_escape_string($_GET['taskkey']);
          $seckey = $conn->real_escape_string($_GET['seckey']);

          $modulesdetails = $func->task_details($subId, $seckey);

          $filename = "";

          if($modulesdetails->num_rows > 0){

            while($modesc = $modulesdetails->fetch_assoc()){

              if($modesc['stat'] == 1){

                $quizStat = '<label> Task Status: <i class="text-yellow"> Open </i> </label>';

              } else {

                $quizStat = '<label> Task Status: <i class="text-danger"> Close </i> </label>';
                
              }

              $filename = $modesc['filename'];

          ?>
            <div class="col-lg-3 col-sm-12 mods">
              <!-- small card -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h5><?= $modesc['filename'] ?></h5>
                  <?= $quizStat ?><br>
                </div>
                <div class="icon">
                  <i class="fa fa-file"></i>
                </div>
                <a href="<?= $modesc['filepath'] ?>" target="_blank" class="small-box-footer">
                  View Task File <i class="fas fa-arrow-circle-right"></i>
                </a>
                <a href="?gkey=<?= $gradeid ?>&seckey=<?= $seckey ?>&taskkey=<?= $subId ?>&qId=<?= $modesc['quizzId'] ?>&#qres" class="small-box-footer">
                  Upload/View Answer File <i class="fas fa-upload"></i>
                </a>
              </div>
            </div>
          <?php

            }

          ?>
        </div><br>
        </div><hr>

        <!-- Answer Uploaded -->
        <?php

          if(isset($_GET['qId'])){

            $user_id = $_SESSION['user_id'];
            $gradeid = $conn->real_escape_string($_GET['gkey']);
            $subId = $conn->real_escape_string($_GET['taskkey']);
            $seckey = $conn->real_escape_string($_GET['seckey']);
            @$id = $conn->real_escape_string($_GET['qId']);

            $qdet = $conn->query("SELECT * FROM portal_performance_task WHERE quizzId = \"$id\" AND quiztype = \"creator\"");

            if($qdet->num_rows > 0){

              $qname = $qdet->fetch_assoc();

              $qnamez = $qname['filename'];
              $qstat = $qname['stat'];

            } else {

              $qname = "";

            }

        ?>

        <div class="row">
          <div class="col-md-12">
            <h5 class="alert alert-success"> Answer Uploaded for <i class="text-yellow"><?= $qnamez ?></i> </h5>
          <?php

          $answersdetails = $conn->query("SELECT * FROM portal_performance_task WHERE
                                          gradeid = \"$gradeid\" AND sectionid = \"$seckey\" AND subjectid = \"$subId\" AND quizzId = \"$id\" AND uploadedby = \"$user_id\" AND quiztype = \"respondent\" AND stat = \"1\" OR
                                          gradeid = \"$gradeid\" AND sectionid = \"$seckey\" AND subjectid = \"$subId\" AND quizzId = \"$id\" AND uploadedby = \"$user_id\" AND quiztype = \"respondent\" AND stat = \"2\"");

          $filename = "";

          if($answersdetails->num_rows > 0){

            while($ansdesc = $answersdetails->fetch_assoc()){

              $ansid = $ansdesc['id'];

              $CFile = $conn->query("SELECT * FROM portal_performance_task WHERE id = \"$ansid\" AND quizzId = \"$id\" AND uploadedby = \"$user_id\" AND quiztype = \"checked\"");

              if($CFile->num_rows > 0){

                  $file = $CFile->fetch_assoc();

                  $CFileRes = '<a href="'.$file['filepath'].'" target="_blank" class="small-box-footer">View Checked File <i class="fas fa-arrow-circle-right"></i></a>';

              } else {

                  $CFileRes = '';

              }

              $filename = $ansdesc['filename'];

              $stat = $ansdesc['stat'];

              if($stat == 1){

                $ansstat = '<label> Answer Status: <i class="text-danger"> Not Checked </i> </label>';
                $taskdelBut = '<a href="?gkey='.$_GET['gkey'].'&seckey='.$_GET['seckey'].'&taskkey='.$_GET['taskkey'].'&qId='.$_GET['qId'].'&delTKey='.$_GET['qId'].'&tanswerId='.$ansdesc['id'].'" class="small-box-footer">
                      Delete Answer File <i class="fas fa-trash"></i>
                    </a>'; 

              } else {

                $ansstat = '<label> Answer Status: <i class="text-yellow"> Checked </i> </label>';
                $taskdelBut = "";

              }

              //Delete Task
                if(isset($_GET['delTKey'])){

                    $delid = $conn->real_escape_string($_GET['delTKey']);
                    $TanswerID = $conn->real_escape_string($_GET['tanswerId']);
                    $userid = $_SESSION['user_id'];

                    $delyt = $conn->query("DELETE FROM portal_performance_task WHERE id = \"$TanswerID\" AND quizzId = \"$delid\" AND uploadedby = \"$userid\" AND quiztype = \"respondent\"");

                    if($delyt){
    
                        echo '<script>alert("Task Deleted Successfuly");location.href="?gkey='.$_GET['gkey'].'&seckey='.$_GET['seckey'].'&taskkey='.$_GET['taskkey'].'&qId='.$_GET['qId'].'"</script>';
                        //echo 'Deleted ' .$delid.' '.$userid.' '.$conn->error;

                    } else {

                        echo $conn->error;
    
                    }
    
                }
              // End for Delete Task

          ?>
            <div class="col-lg-3 col-sm-12 mods">
              <!-- small card -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h5> Answer for: <?= $ansdesc['filename'] ?></h5><br>
                  <?= $ansstat ?>
                </div>
                <div class="icon">
                  <i class="fa fa-file"></i>
                </div>
                <a href="<?= $ansdesc['filepath'] ?>" target="_blank" class="small-box-footer">
                  View Answer File <i class="fas fa-arrow-circle-right"></i>
                </a>
                <?= $taskdelBut ?>
                <?= $CFileRes ?>
              </div>
            </div>
          <?php

            }

          } else {

          ?>

            <h5> You don't have any answers uploaded for this task yet. Upload your answer now. </h5>

          <?php

          }

          ?>
        </div><br>
        </div><hr>


        <?php

            if($qstat == 1){


        ?>
          <h5 id="qres" class="alert alert-success"> Upload Task Response for <i class="text-yellow"> <?= $qnamez ?> </i> </h5>
          <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
              <div class="col-lg-6">
                <input type="hidden" class="form-control" value="<?= $qnamez ?>" name="filename" placeholder="Filename Eg. Response for task name and fullname" required>
              </div>
              <div class="col-lg-12">
                <input type="file" required class="form-control" name="file[]" multiple id="exampleInputFile">
              </div>
            </div><br>
            <div class="row">
              <div class="col-lg-12 text-right">
                <input type="submit" name="uploadFile" value="Upload File" class="btn btn-sm btn-success">
              </div>
            </div>
          </form><br>

          <?php

              } else {

          ?>

              <label> Uploading of answer file is not available when task is already closed. Thank you. </label><hr>

          <?php

              }

            }  

          } else {

          ?>

            <h5> No Tasks Uploaded in this subject </h5>

          <?php

          }

       } //End for quiz  

        ?>


      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2020 <a href="#">RJL Software Development</a>.</strong>
    All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php

  require 'footer.php';

  } else {

    header('location:../404.php');

  }


  ?>
