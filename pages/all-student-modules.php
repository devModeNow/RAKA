<?php
  
  session_start();

  if(isset($_SESSION['user_id'])){

    require 'student-header.php';


?>

  <?php require 'header.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0 text-dark">My Response Modules</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">My Modules</li>
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


        	$modDetails = $func->module_details_stud($gradeId);

		    if($modDetails->num_rows > 0){

		      while($modData = $modDetails->fetch_assoc()){
        		

        	?>
            <div class="col-lg-3 col-6 mods">
              <!-- small card -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h4>Filename: <?= $modData['filename'] ?></h4>
                  <h6> Uploaded By: <?= $modData['firstname'].' '.$modData['lastname'] ?> </h6><br><br>
                </div>
                <div class="icon">
                  <i class="fa fa-file"></i>
                </div>
                <a href="<?= $modData['filepath'] ?>" target="_blank" class="small-box-footer">
                  View File <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
          <?php 

          		}

          	} else {

          ?>

          <h4 class="alert alert-info text-center col-12"> You have no response modules uploaded yet </h4>

          <?php

          	}

          ?>
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