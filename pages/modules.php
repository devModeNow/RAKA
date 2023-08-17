<?php

  session_start();

  if(isset($_SESSION['user_id'])){

    require 'teacher-header.php';

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
          <div class="col-sm-6">
            <h4 class="m-0 text-dark">Modules</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Modules</li>
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
            $acctype = "1";

            $modId = 'module_'.rand(2,12345);

            $subDet = $func->subject_details($classId,$subId);

            $value = $subDet->fetch_assoc();

            $filename = "Algebra Expressions";


            //Upload module Old
            /*if(isset($_POST['uploadFile'])){

              $filename = $conn->real_escape_string($_POST['filename']);

              $target_dir = "../uploads/modules/";
              $target_file = $target_dir . basename($_FILES["file"]["name"]);
              $uploadOk = 1;
              $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

              if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){

                $insert = $conn->query("INSERT INTO portal_modules (gradeid,sectionid,subjectid,moduleId,filename,filepath,uploadedby,acctype)
                                        VALUES (\"$classId\",\"$secId\",\"$subId\",\"$modId\",\"$filename\",\"$target_file\",\"$user_id\",\"$acctype\")");

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

              //echo 'Failed to upload file';

            }*/
            //End Of old upload module


            //Upload module Old
            if(isset($_POST['uploadFile'])){

              $filename = $conn->real_escape_string($_POST['filename']);
              $target_file = $conn->real_escape_string($_POST['file']);

              $insert = $conn->query("INSERT INTO portal_modules (gradeid,sectionid,subjectid,moduleId,filename,filepath,uploadedby,acctype)
                                      VALUES (\"$classId\",\"$secId\",\"$subId\",\"$modId\",\"$filename\",\"$target_file\",\"$user_id\",\"$acctype\")");

              if($insert == true){

                echo '<script>alert("Module Uploaded")</script>';

              } else {

                echo 'Error '.$conn->error;

              }

            } else {

              //echo 'Failed to upload file';

            }
            //End Of old upload module


            //delete Module
            if(isset($_GET['deleteid'])){

              $delId = $conn->real_escape_string($_GET['deleteid']);

              $deleteModule = $conn->query("UPDATE portal_modules SET stat = 0 WHERE moduleId = \"$delId\"");

              if($deleteModule){

                echo '<script>alert("Module Deleted Successfuly");</script>';

              } else {

                echo $conn->error;

              }

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

          $modulesdetails = $func->module_details($subId, $secId);

          if($modulesdetails->num_rows > 0){

            while($modesc = $modulesdetails->fetch_assoc()){

              $uploadBy = $func->personuploaded($modesc['uploadedby']);

              if($uploadBy->num_rows > 0){

                $uploadbyData = $uploadBy->fetch_assoc();

                $uploadPerson = 'Uploaded by: '.$uploadbyData['firstname'].' '.$uploadbyData['lastname'];

              } else {

                $uploadPerson = "";

              }

          ?>
            <div class="col-lg-3 col-sm-12 mods">
              <!-- small card -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h5><?= $modesc['filename'] ?></h5>
                  <label> <?= $uploadPerson ?> </label><br><br>
                </div>
                <div class="icon">
                  <i class="fa fa-file"></i>
                </div>
                <a href="<?= $modesc['filepath'] ?>" target="_blank" class="small-box-footer">
                  View File <i class="fas fa-arrow-circle-right"></i>
                </a>
                <a href="?classkey=<?= $_GET['classkey'] ?>&seckey=<?= $_GET['seckey'] ?>&key=<?= $_GET['key'] ?>&deleteid=<?= $modesc['moduleId'] ?>" class="small-box-footer text-danger">
                  Delete File <i class="fas fa-trash"></i>
                </a>
              </div>
            </div>
          <?php

            }

          } else {

          ?>

            <h5> No Module Uploaded in this subject </h5>

          <?php

          }

          ?>
          </div>
        </div><hr>
        <div class="row">
          <div class="col-lg-12">
            <h4> Upload Module </h4>
            <form action="" method="post" enctype="multipart/form-data">
              <div class="row">
                <div class="col-lg-6">
                  <input type="text" class="form-control" name="filename" placeholder="Filename" required>
                </div>
                <div class="col-lg-6">
                  <!--<div class="custom-file">
                    <input type="file" class="custom-file-input" name="file" id="exampleInputFile">
                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                  </div>-->
                  <input type="url" class="form-control" name="file" placeholder="Paste Module Link" required>
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

<?php

  require 'footer.php'; 

  }

?>