<?php

  session_start();

  if(isset($_SESSION['user_id'])){

    if($_SESSION['access'] == 1){

      require 'teacher-header.php';

    } else {

      require 'student-header.php';

    }

?>

  <?php require 'header.php'; ?>

    <!-- Toastr -->
  <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
    <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<?php

  if($_SESSION['access'] == 1){

?>
  <!-- Content Wrapper. Contains page content -->
  <!--<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!--<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Student Profile</h5>
          </div><!-- /.col -->
          <!--<div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../">Home</a></li>
              <li class="breadcrumb-item active">Student Profile</li>
            </ol>
          </div><!-- /.col -->
        <!--</div><!-- /.row -->
      <!--</div><!-- /.container-fluid -->
    <!--</div><hr>
    <!-- /.content-header -->

    <?php

      /*$studID = $conn->real_escape_string($_SESSION['user_id']);

      $selStudData = $conn->query("SELECT * FROM portal_user_details a, portal_users b WHERE a.userId = b.userId AND a.userId = \"$studID\"");

      $studData = $selStudData->fetch_assoc();

      $fname = strtolower($studData['firstname']);
      $mname = strtolower($studData['middlename']);
      $lname = strtolower($studData['lastname']);

      $fname = ucfirst($fname);
      $mname = ucfirst($mname);
      $lname = ucfirst($lname);

      $studfullname = $fname.' '.$mname.' '.$lname;

      $skey = $studData['userId'];

      $selstudschooldet = $conn->query("SELECT * FROM portal_students a, tblschool_glevel b, tblschool_section c WHERE a.gradeId = b.gradeid AND a.sectionid = c.sectionid AND a.studentId = \"$skey\"");

      $schoolData = $selstudschooldet->fetch_row();*/

    ?>

    <!-- Main content -->
    <!--<section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <!--<div class="row alert alert-info">
          <div class="col-md-12 col-sm-12 col-lg-6">
            <div class="immg text-center">
              <img class="ppic" src="../images/profiles/man.png"><br>
              <h5> <?= $fullname ?> </h5><br>
            </div>
          </div>
          <div class="col-md-12 col-sm-12 col-lg-6">
            <div class="text-center"><br>
              <h4> <b> Change Password </b> </h4><br><br>
              <div class="col-lg-8 porm">
                <input type="password" id="pass1" class="form-control" placeholder="Enter Student New Password"><br>
                <input type="password" id="pass2" class="form-control" onkeyup="checkPazz()" placeholder="Re-type Student New Password">
                <label id="ewor" class="text-red"><i fa fa-info><i><i> Password Not Match </i></label><br>
                <input id="cpass" type="submit" onclick="changePassteach(<?= $_SESSION['user_id'] ?>)" value="Submit" class="btn btn-sm btn-warning">
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      <!--</div><!-- /.container-fluid -->
    <!--</section>
    <!-- /.content -->
  <!--</div>
  <!-- /.content-wrapper -->

  <h5 class="text-center alert alert-success"> Under Production </h5>

<?php } else { ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h5 class="m-0 text-dark">Student Profile</h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../">Home</a></li>
              <li class="breadcrumb-item active">Student Profile</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div><hr>
    <!-- /.content-header -->

    <?php

      $studID = $conn->real_escape_string($_SESSION['user_id']);

      $selStudData = $conn->query("SELECT * FROM portal_user_details a, portal_users b WHERE a.userId = b.userId AND a.userId = \"$studID\"");

      $studData = $selStudData->fetch_assoc();

      $fname = strtolower($studData['firstname']);
      $mname = strtolower($studData['middlename']);
      $lname = strtolower($studData['lastname']);

      $fname = ucfirst($fname);
      $mname = ucfirst($mname);
      $lname = ucfirst($lname);

      $studfullname = $fname.' '.$mname.' '.$lname;

      $skey = $studData['userId'];

      $selstudschooldet = $conn->query("SELECT * FROM portal_students a, tblschool_glevel b, tblschool_section c WHERE a.gradeId = b.gradeid AND a.sectionid = c.sectionid AND a.studentId = \"$skey\"");

      $schoolData = $selstudschooldet->fetch_row();

    ?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row alert alert-info">
          <div class="col-md-12 col-sm-12 col-lg-6">
            <div class="immg text-center">
              <img class="ppic" src="../<?= $studData['profile_pic'] ?>"><br>
              <h5 class="mt-2"> LRN: <?= $studData['username'] ?> </h5><br>
              <h5> <?= $studfullname ?> </h5><br>
              <h4> Grade: <?= $schoolData[10] ?> | Section: <?= $schoolData[15] ?> </h4>
            </div>
          </div>
          <div class="col-md-12 col-sm-12 col-lg-6">
            <div class="text-center"><br>
              <h4> <b> Change Password </b> </h4><br><br>
              <div class="col-lg-8 porm">
                <input type="password" id="pass1" class="form-control" placeholder="Enter Student New Password"><br>
                <input type="password" id="pass2" class="form-control" onkeyup="checkPazz()" placeholder="Re-type Student New Password">
                <label id="ewor" class="text-red"><i fa fa-info><i><i> Password Not Match </i></label><br>
                <input id="cpass" type="submit" onclick="changePass(<?= $studData['userId'] ?>)" value="Submit" class="btn btn-sm btn-warning">
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php } ?>

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
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../js/updatePass.js"></script>
<script src="../js/updatePassteacher.js"></script>