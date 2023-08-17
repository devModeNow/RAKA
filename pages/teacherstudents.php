<?php

  session_start();

  if(isset($_SESSION['user_id'])){

    require 'teacher-header.php';

?>

  <?php require 'header.php'; ?>

  <style>
      
      .mods{
        position:relative;
        display:inline-flex;
      }

  </style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0 text-dark">Subjects</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
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
          
          <?php

            if(isset($_GET['subkey'])){

              $subjectsdetails = $func->mystudents($_GET['seckey']);
              $seckey = $conn->real_escape_string($_GET['seckey']);

              $section = $conn->query("SELECT * FROM tblschool_section WHERE sectionid = \"$seckey\" AND adviserid = ".$_SESSION['user_id']);

              if($section->num_rows > 0){

                $section = $section->fetch_assoc();

                $section = $section['description'];

              } else {

                $section = "";

              }

              //Delete Student
              if(isset($_GET['delKey'])){

                $delkey = $conn->real_escape_string($_GET['delKey']);

                $del1 = $conn->query("DELETE FROM portal_users WHERE userId = \"$delkey\"");

                  if($del1 == true){

                    $del2 = $conn->query("DELETE FROM portal_user_details WHERE userId = \"$delkey\"");

                    if($del2 == true){

                      $del3 = $conn->query("DELETE FROM portal_students WHERE studentId = \"$delkey\"");

                      if($del3 == true){

                        echo '<script>alert("Student Deleted Successfuly"); location.href="?subkey='.$_GET['subkey'].'&seckey='.$_GET['seckey'].'"</script>';

                      } else {

                        $conn->error;

                      }

                    } else {

                      $conn->error;

                    }

                  } else {

                    $conn->error;

                  }

              }


              ?>
              <div class="row">
                <div class="col-lg-12">
                  <h4 class="alert alert-sm alert-success">Section: <?= $section ?> <a class="btn btn-sm btn-danger float-right" href="add-student.php?subkey=<?= $_GET['subkey'] ?>&seckey=<?= $_GET['seckey'] ?>"> Register Student </a> </h4>
                </div>
              </div>
              <div class="row">
              <?php

              if($subjectsdetails->num_rows > 0){

                while($subdesc = $subjectsdetails->fetch_assoc()){

              ?>
              <div class="col-md-3">
                <!-- Widget: user widget style 2 -->
                <div class="card card-widget widget-user-2">
                  <!-- Add the bg color to the header using any of the bg-* classes -->
                  <div class="widget-user-header bg-info">
                    <div class="widget-user-image">
                      <img class="img-circle elevation-2" src="../<?= $subdesc['profile_pic'] ?>" alt="User Avatar">
                    </div>
                    <!-- /.widget-user-image -->
                    <h3 class="widget-user-username"><?= $subdesc['lastname'].', '.$subdesc['firstname'] ?></h3>
                    <label class="widget-user-desc"> Student </label>
                    <div class="row">
                      <a href="studentProfile.php?studKey=<?= $subdesc['userId'] ?>" class="btn btn-xs btn-primary col-12"> View Profile </a>
                      <a href="?subkey=<?=$_GET['subkey']?>&seckey=<?=$_GET['seckey']?>&delKey=<?= $subdesc['userId'] ?>" class="btn btn-xs btn-danger col-12"> Delete Student </a>
                    </div>
                  </div>
                </div>
                <!-- /.widget-user -->
              </div>
            <?php 

                }

              } else {

                //echo '<script>alert("No Subject Assigned");location.href="../"</script>';

          ?>

            <h3 class="col-12 alert alert-sm alert-info text-center"> No student assigned for this class </h3>

          <?php
            }

          } else {

            echo '<script>alert("No Subject Assigned");location.href="../"</script>';

        ?>

        <!--<h3 class="col-12 alert alert-sm alert-info text-center"> No subject assign for this class </h3>-->

          }

        
        <?php } ?>
        </div>
      </div><hr><!-- /.container-fluid -->
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
