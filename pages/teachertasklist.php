<?php

  session_start();

  if(isset($_SESSION['user_id'])){

    require 'teacher-header.php';

?>

  <?php require 'header.php'; ?>
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.css">

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
          <div class="col-sm-6">
            <h4 class="m-0 text-dark">Performance Tasks</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Performance Tasks</li>
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
          <?php

          if(isset($_GET['classkey']) && isset($_GET['key'])){

            $user_id = $_SESSION['user_id'];
            $classId = $conn->real_escape_string($_GET['classkey']);
            $secId = $conn->real_escape_string($_GET['seckey']);
            $subId = $conn->real_escape_string($_GET['key']);

            $select_sub = $conn->query("SELECT * FROM tblschool_subjects WHERE subjectid = \"$subId\"");
            $subdesc = $select_sub->fetch_assoc();

            $subdesc = $subdesc['description'];

            $acctype = "1";
            $announcement = $_SESSION['fname']." ".$_SESSION['lname']." uploaded a new task on ".$subdesc." subject.";

            $qtype = "creator";

            $modId = 'perfTask_'.rand(2,65484215);

            $subDet = $func->subject_details($classId,$subId);

            $value = $subDet->fetch_assoc();

            $filename = "Algebra Expressions";


            //Upload module
            if(isset($_POST['uploadFile'])){

              $filename = $conn->real_escape_string($_POST['filename']);

              $target_dir = "../uploads/performance tasks/";
              $target_file = $target_dir . basename($_FILES["file"]["name"]).rand(4,9814345);
              $uploadOk = 1;
              $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

              if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){

                $insert = $conn->query("INSERT INTO portal_performance_task (gradeid,sectionid,subjectid,quizzId,filename,filepath,uploadedby,acctype, quiztype)
                                        VALUES (\"$classId\",\"$secId\",\"$subId\",\"$modId\",\"$filename\",\"$target_file\",\"$user_id\",\"$acctype\",\"$qtype\")");

                if($insert == true){

                  $query = $conn->query("INSERT INTO portal_announcement (announcement, audience, announcedBy) VALUES(\"$announcement\",\"$secId\",\"$user_id\")");

                  if($query == true){

                    echo '<script>alert("Performance Tasks Uploaded")</script>';

                  } else {

                    echo $conn->error;

                  }

                } else {

                  echo 'Error '.$conn->error;

                }

              } else {

                echo 'Error Uploading File';
                echo '<script>alert("Error Uploading File "'.$conn->error.')</script>';

              }

            } else {

              //echo 'Failed to upload file';

            }


            //delete Task
            if(isset($_GET['deleteid'])){

              $delId = $conn->real_escape_string($_GET['deleteid']);

              $deleteModule = $conn->query("UPDATE portal_performance_task SET stat = 0 WHERE quizzId = \"$delId\" AND quiztype = \"creator\"");

              if($deleteModule){

                echo '<script>alert("Performance Task Deleted Successfuly");</script>';

              } else {

                echo $conn->error;

              }

            }


            //Close Task
            if(isset($_GET['closeid'])){

              $closeId = $conn->real_escape_string($_GET['closeid']);

              $deleteModule = $conn->query("UPDATE portal_performance_task SET stat = 3 WHERE quizzId = \"$closeId\" AND quiztype = \"creator\"");

              if($deleteModule){

                echo '<script>alert("Task Closed Successfuly");</script>';

              } else {

                echo $conn->error;

              }

            }


            //Check Task
            /*if(isset($_GET['checkedstudId'])){

              $id = $conn->real_escape_string($_GET['qid']);
              $checkedstudId = $conn->real_escape_string($_GET['checkedstudId']);

              $deleteModule = $conn->query("UPDATE portal_quizzes SET stat = 2 WHERE quizzId = \"$id\" AND uploadedby = \"$checkedstudId\" AND quiztype = \"respondent\"");

              if($deleteModule){

                echo '<script>alert("Quiz Checked Successfuly");</script>';

              } else {

                echo $conn->error;

              }

            }*/

            //Delete Task Answer
            if(isset($_GET['deletedstudId'])){

              $id = $conn->real_escape_string($_GET['qid']);
              $deletedstudId = $conn->real_escape_string($_GET['deletedstudId']);

              $deleteModule = $conn->query("UPDATE portal_performance_task SET stat = 0 WHERE quizzId = \"$id\" AND uploadedby = \"$deletedstudId\" AND quiztype = \"respondent\"");

              if($deleteModule){

                echo '<script>alert("Task Answer Deleted Successfuly, Student can re-upload his/her answer. Thank you.");</script>';

              } else {

                echo $conn->error;

              }

            }

            //Upload Checked File
            if(isset($_POST['upCheckedFile'])){

              $qid  = $conn->real_escape_string($_GET['qid']);

              $answerId  = $conn->real_escape_string($_POST['ansId']);
              $studId = $conn->real_escape_string($_POST['studId']);
              $acctype = "2";

              $qDet = $conn->query("SELECT * FROM portal_performance_task WHERE quizzId = \"$qid\" AND uploadedby = \"$studId\"");
              $data = $qDet->fetch_assoc();

              $filename = $data['filename'];

              $target_dir = "../uploads/checked/";
              $target_file = $target_dir . basename($_FILES["checkedFile"]["name"]);
              $uploadOk = 1;
              $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
              $qtype = "checked";

              if(move_uploaded_file($_FILES["checkedFile"]["tmp_name"], $target_file)){

                $insert = $conn->query("INSERT INTO portal_performance_task (id,gradeid,sectionid,subjectid,quizzId,filename,filepath,uploadedby,acctype, quiztype)
                                        VALUES (\"$answerId\",\"$classId\",\"$secId\",\"$subId\",\"$qid\",\"$filename\",\"$target_file\",\"$studId \",\"$acctype\",\"$qtype\")");

                  if($insert == true){


                    $deleteModule = $conn->query("UPDATE portal_performance_task SET stat = 2 WHERE id = \"$answerId\" AND quizzId = \"$qid\" AND uploadedby = \"$studId \"");

                    if($deleteModule){

                      echo '<script>alert("Task Checked Successfuly and Checked file Uploaded successfully  ");</script>';

                    } else {

                      echo $conn->error;

                    }


                  } else {

                    echo $conn->error;

                  }

              } else {

                echo 'Error Uploading File';
                echo '<script>alert("Error Uploading File "'.$conn->error.')</script>';

              }

            } else {

              //echo 'Failed to upload file';

            }

            //Section Details
            $section = $conn->query("SELECT * FROM tblschool_section WHERE sectionid = \"$secId\"");

            if($section->num_rows > 0){

              $section = $section->fetch_assoc();

              $section = $section['description'];

            } else {

              $section = "";

            }


        ?>
        <div class="row">
          <div class="col-lg-12">
            <h5 class="alert alert-success"> Section: <?= $section ?> | Subject: <?= $value['description'] ?> </h5>
          <?php

          $subId = $conn->real_escape_string($value['subjectid']);
          $secId = $conn->real_escape_string($_GET['seckey']);

          $modulesdetails = $func->task_details($subId, $secId);

          if($modulesdetails->num_rows > 0){

            while($modesc = $modulesdetails->fetch_assoc()){

              if($modesc['stat'] == 1){

                $quizStat = '<label> Task Status: <i class="text-yellow"> Open </i> </label>';

              } elseif($modesc['stat'] == 3){

                $quizStat = '<label> Task Status: <i class="text-danger"> Close </i> </label>';
                
              }

          ?>
            <div class="col-lg-3 col-sm-12 mods">
              <!-- small card -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h5><?= $modesc['filename'] ?></h5>
                  <?= $quizStat ?><br>
                </div>
                <div class="icon">
                  <i class="fa fa-file"></i>
                </div>
                <a href="<?= $modesc['filepath'] ?>" target="_blank" class="small-box-footer">
                  View File <i class="fas fa-arrow-circle-right"></i>
                </a>
                <a href="?classkey=<?= $classId ?>&seckey=<?= $secId ?>&key=<?= $subId ?>&qid=<?= $modesc['quizzId'] ?>" class="small-box-footer">
                  View Respondents <i class="fas fa-users"></i>
                </a><hr>
                <a href="?classkey=<?= $classId ?>&seckey=<?= $secId ?>&key=<?= $subId ?>&closeid=<?= $modesc['quizzId'] ?>" class="small-box-footer text-danger">
                  Close Task <i class="fas fa-minus"></i>
                </a>
                <a href="?classkey=<?= $classId ?>&seckey=<?= $secId ?>&key=<?= $subId ?>&deleteid=<?= $modesc['quizzId'] ?>" class="small-box-footer text-danger">
                  Delete Task <i class="fas fa-trash"></i>
                </a>
              </div>
            </div>
          <?php

            }

          } else {

          ?>

            <h5> No Task Uploaded in this subject </h5>

          <?php

          }

          ?>
          </div>
        </div><hr>

        <!-- Respondent View -->
        <?php

          if(isset($_GET['qid'])){

            $id = $conn->real_escape_string($_GET['qid']);

            $qdet = $conn->query("SELECT * FROM portal_performance_task WHERE quizzId = \"$id\"");

            $qdet = $qdet->fetch_assoc();

        ?>
        <div class="row">
          <div class="col-lg-12 res">
            <h5 class="alert alert-success"> Respondents for: <i class="text-yellow"> <?= $qdet['filename'] ?> </i> </h5>
            <table id="naniz" class="table table-hover table-striped">
              <thead>
                <tr>
                  <td> <b> Fullname </b> </td>
                  <td> <b> Status </b> </td>
                  <td class="text-center"> <b> Upload Checked File </b> </td>
                  <td> <b> Answer File </b> </td>
                  <td> <b> Checked File </b> </td>
                  <!--<td colspan="3"> <b> Action </b> </td>-->
                </tr>
              </thead>
              <tbody>
          <?php

          $subId = $conn->real_escape_string($value['subjectid']);
          $secId = $conn->real_escape_string($_GET['seckey']);

          $modulesdetails = $func->task_answer_details($subId, $secId, $id);

          if($modulesdetails->num_rows > 0){

            while($modesc = $modulesdetails->fetch_assoc()){

              if($modesc['stat'] == 1){

                $ansstat = '<i class="text-danger"> Not Checked </i>';

              } elseif($modesc['stat'] == 2){

                $ansstat = '<i class="text-success"> Checked </i>';

              } else {

                $ansstat = '<i> For Re-upload </i>';

              }

              $studId = $modesc['uploadedby'];
              $ansID = $modesc['id'];
              $qid = $conn-> real_escape_string($_GET['qid']);

              $studData = $conn->query("SELECT * FROM portal_user_details WHERE userId = \"$studId\"");

              $checked = $conn->query("SELECT * FROM portal_performance_task WHERE id = \"$ansID\" AND uploadedby = \"$studId\" AND quizzId = \"$qid\" AND quiztype = \"checked\"");

              if($checked->num_rows > 0){

                $CheckedData = $checked->fetch_assoc();

                $checkedFile = '<a class="btn btn-xs btn-success" href="'.$CheckedData['filepath'].'" target="_blank"> View </a>';

              } else {

                $checkedFile = '<i> No Checked File Uploaded </i>';

              }

              $CheckedData = $checked->fetch_assoc();

              $dets = $studData->fetch_assoc();

              $studfname = strtolower($dets['firstname']);
              $studlname = strtolower($dets['lastname']);
              $studfnames = ucfirst($studfname);
              $studlnames = ucfirst($studlname);
              $studfullname = $studfnames.' '.$studlnames;

          ?>

              <tr>
                <td> <?= $studfullname ?> </td>
                <td> <?= $ansstat ?> </td>
                <td>
                  <form action="" method="POST" enctype="multipart/form-data">
                      <input type="hidden" value="<?= $studId  ?>" class="form-control" name="studId">
                      <input type="hidden" value="<?= $modesc['id']  ?>" class="form-control" name="ansId">
                      <input type="file" placeholder="Upload Checked File" name="checkedFile" required>
                      <input type="submit" class="btn btn-xs btn-success" value="Upload and Check" name="upCheckedFile">
                  </form>
                </td>
                <td> <a class="btn btn-xs btn-primary" href="<?= $modesc['filepath'] ?>" target="_blank"> View </a> </td>
                <td> <?= $checkedFile; ?> </td>
                <!--<td> <a class="btn btn-xs btn-success" href="?classkey=<?= $classId ?>&seckey=<?= $secId ?>&key=<?= $subId ?>&qid=<?= $modesc['quizzId'] ?>&checkedstudId=<?= $modesc['uploadedby'] ?>"> Check </a> </td>
                <td> | </td>
                <td> <a class="btn btn-xs btn-danger" href="?classkey=<?= $classId ?>&seckey=<?= $secId ?>&key=<?= $subId ?>&qid=<?= $modesc['quizzId'] ?>&deletedstudId=<?= $modesc['uploadedby'] ?>"> Delete Answer </a> </td>
              </tr>-->

          <?php

            }

          ?>
              </tbody>
            </table>

          <?php

          } else {

          ?>

            <h5> No Respondents </h5>

          <?php

          }

          ?>
          </div>
        </div><hr>
        <?php } ?>

        <div class="row">
          <div class="col-lg-12">
            <h4> Upload Task </h4>
            <form action="" method="post" enctype="multipart/form-data">
              <div class="row">
                <div class="col-lg-6">
                  <input type="text" class="form-control" name="filename" placeholder="Filename" required>
                </div>
                <div class="col-lg-6" style="overflow:hidden;">
                  <input type="file" name="file" id="exampleInputFile">
                </div>
              </div><br>
              <div class="row">
                <div class="col-lg-12 text-right">
                  <input type="submit" name="uploadFile" value="Upload File" class="btn btn-sm btn-success">
                </div>
              </div>
            </form><br>
          </div>
        </div>
        <?php } ?>
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
<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
  $(function(){

    console.log("nani");

    $("#naniz").DataTable();

  });

</script>
<?php

  require 'footer.php';

  }

?>
