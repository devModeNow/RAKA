<?php

  session_start();

  if(isset($_SESSION['user_id'])){

    require 'teacher-header.php';

?>

  <?php require 'header.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0 text-dark">Performance Task</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Class</li>
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

          $class = $func->teacher_classes();

          if($class->num_rows > 0){

            while($classData = $class->fetch_assoc()){ 

            //$classData = $class->fetch_assoc();

            $key = $classData['gradeid'];

            $glevelz = $func->gradeLevel($key);

            if($glevelz->num_rows > 0){

              $glevel = $glevelz->fetch_assoc();
              $glevel = $glevel['description'];

            } else {

              $glevel = "You have nothing to handle.";

            }

          ?>
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="fa fa-book"></i></span>

              <div class="info-box-content">
                <span class="text-info"><strong><i class="fas fa-home"></i><?= $glevel ?></strong></span>
                <span class="info-box-text"><?= $classData['description'] ?></span>
                <!--<span class="info-box-number"> <a href="teacherstudents.php?subkey=<?= $classData['gradeid'] ?>&seckey=<?= $classData['sectionid'] ?>"> <i class ="fa fa-users"></i> Students </a> </span>-->
                <span class="info-box-number"> <a href="teachertasksubject.php?subkey=<?= $classData['gradeid'] ?>&seckey=<?= $classData['sectionid'] ?>"> <i class ="fas fa-book"></i> Subjects </a> </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        <?php 

              }

          } else {

        ?>

          <h3 class="col-12 alert alert-sm alert-info text-center"> You have no class advisory to be handeled. </h3>

        <?php } ?>
        </div>
        <!-- /.row -->
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
