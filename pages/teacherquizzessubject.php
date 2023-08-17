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

              $subjectsdetails = $func->teacher_subject($_GET['subkey']);
              $seckey = $conn->real_escape_string($_GET['seckey']);

              $section = $conn->query("SELECT * FROM tblschool_section WHERE sectionid = \"$seckey\" AND adviserid = ".$_SESSION['user_id']);

              if($section->num_rows > 0){

                $section = $section->fetch_assoc();

                $section = $section['description'];

              } else {

                $section = "";

              }

              ?>
              <div class="row">
                <div class="col-lg-12">
                  <h4 class="alert alert-sm alert-success">Section: <?= $section ?> </h4>
                </div>
              </div>
              <?php

              if($subjectsdetails->num_rows > 0){

                while($subdesc = $subjectsdetails->fetch_assoc()){

              ?>
                <div class="col-md-3 col-sm-6 col-lg-3 mods">
                  <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fa fa-book"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text"><?= $subdesc['description'] ?></span>
                      <span class="info-box-number"> <a href="teacherquizzeslist.php?classkey=<?= $_GET['subkey'] ?>&seckey=<?= $_GET['seckey'] ?>&key=<?= $subdesc['subjectid'] ?>"> View Quizzes </a> </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
            <?php 

                }

              } else {

          ?>

            <h3 class="col-12 alert alert-sm alert-info text-center"> No subject assign for this class </h3>

          <?php
            }

          } else {

        ?>

        <h3 class="col-12 alert alert-sm alert-info text-center"> No subject assign for this class </h3>

          }

          </div>
        </div><hr>
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