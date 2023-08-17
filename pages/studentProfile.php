<?php

  session_start();

  if(isset($_SESSION['user_id'])){

    require 'teacher-header.php';

?>

  <?php require 'header.php'; ?>

    <!-- Toastr -->
  <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
    <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

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

      $studID = $conn->real_escape_string($_GET['studKey']);

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


      //Update Email
      if(isset($_POST['updateEmail'])){

        @$email = $conn->real_escape_string($_POST['emailz']);

        $upd = $conn->query("UPDATE portal_user_details SET email = \"$email\" WHERE userId = \"$studID\"");

        if($email){

            echo '<script>alert("Email Updated Successfuly");</script>';

        } else {

            echo $conn->error;

        }

      }

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
              <h4> <b> Change Password </b> </h4>
              <div class="col-lg-8 porm">
                <input type="password" id="pass1" class="form-control" placeholder="Enter Student New Password"><br>
                <input type="password" id="pass2" class="form-control" onkeyup="checkPazz()" placeholder="Re-type Student New Password">
                <label id="ewor" class="text-red"><i fa fa-info><i><i> Password Not Match </i></label><br>
                <input id="cpass" type="submit" onclick="changePass(<?= $studData['userId'] ?>)" value="Submit" class="btn btn-sm btn-warning">
              </div>

              <hr><br>
              <h4> <b> Update Email </b> </h4>
              <div class="col-lg-8 porm">
                <form action="" method="POST">
                    <input type="email" class="form-control" name="emailz" value="<?= $studData['email'] ?>"><br>
                    <input type="submit" value="Update Email" name="updateEmail" class="btn btn-sm btn-success">
                </form>
              </div>
            </div>
            </div>
          </div>
        </div>
        <!-- Modules -->
        <div class="row">
          <div class="col-12 res">
          <br><br>
          <span class="alert alert-info mt-5"> Modules </span>
          <br><br>
              <table id="mods" class="table table-striped table-hover">
                <thead>
                  <tr>
                    <td> Module Name </td>
                    <td> Subject </td>
                    <td> Date Uploaded </td>
                    <td> Actions </td>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  $id = $conn->real_escape_string($_GET['studKey']);

                  $profMods = $func->profileModules($id);

                  if($profMods->num_rows > 0){

                    while($data = $profMods->fetch_assoc()){

                      $subKey = $data['subjectid'];

                      $sub = $func->profilesubject($subKey);

                      $subData = $sub->fetch_assoc();

                      $subject = $subData['description'];

                  ?>

                  <tr>
                    <td> <?= $data['filename'] ?> </td>
                    <td> <?= ucfirst($subject) ?> </td>
                    <td> <?= $data['dateuploaded'] ?> </td>
                    <td> <a href="<?= $data['filepath'] ?>" class="btn btn-xs btn-info" target="_blank"> View Module </a> </td>
                  </tr>

                  <?php

                    }

                  } else {

                  ?>

                  <tr>
                    <td colspan="4" class="text-center"> This student doesn't have modules uploaded </td>
                  </tr>

                  <?php

                  }

                  ?>
                </tbody>
              </table>
          </div>
        </div>
        <!-- End Modules -->
        <hr>
        <!-- Quizzes -->
        <div class="row">
          <div class="col-12 res">
          <br><br>
          <span class="alert alert-danger mt-5"> Quizzes </span>
          <br><br>
              <table id="quiz" class="table table-striped table-hover">
                <thead>
                  <tr>
                    <td> Quiz File Name </td>
                    <td> Subject </td>
                    <td> Date Uploaded </td>
                    <td> Status </td>
                    <td> Actions </td>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  $id = $conn->real_escape_string($_GET['studKey']);

                  $profMods = $func->profileQuizzes($id);

                  if($profMods->num_rows > 0){

                    while($data = $profMods->fetch_assoc()){

                      $subKey = $data['subjectid'];

                      $sub = $func->profilesubject($subKey);

                      $subData = $sub->fetch_assoc();

                      $subject = $subData['description'];

                      if($data['stat'] == 1){

                        $status = '<i class="text-danger"> Not Checked </i>';

                      } elseif($data['stat'] == 2){

                        $status = '<i class="text-success"> Checked </i>';

                      } else {

                        $status = '<i> For Re-upload </i>';

                      }

                  ?>

                  <tr>
                    <td> <?= $data['filename'] ?> </td>
                    <td> <?= ucfirst($subject) ?> </td>
                    <td> <?= $data['dateuploaded'] ?> </td>
                    <td> <b> <?= $status ?> </b> </td>
                    <td> <a href="<?= $data['filepath'] ?>" class="btn btn-xs btn-info" target="_blank"> View Quiz </a> </td>
                  </tr>

                  <?php

                    }

                  } else {

                  ?>

                  <tr>
                    <td colspan="5" class="text-center"> This student doesn't have quiz uploaded </td>
                  </tr>

                  <?php

                  }

                  ?>
                </tbody>
              </table>
          </div>
        </div>
        <!-- End Quizzes -->

        <!-- Tasks -->
        <div class="row">
          <div class="col-12 res">
          <br><br>
          <span class="alert alert-success mt-5"> Performance Tasks </span>
          <br><br>
              <table id="quiz" class="table table-striped table-hover">
                <thead>
                  <tr>
                    <td> Tasks File Name </td>
                    <td> Subject </td>
                    <td> Date Uploaded </td>
                    <td> Status </td>
                    <td> Actions </td>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  $id = $conn->real_escape_string($_GET['studKey']);

                  $profMods = $func->profileTasks($id);

                  if($profMods->num_rows > 0){

                    while($data = $profMods->fetch_assoc()){

                      $subKey = $data['subjectid'];

                      $sub = $func->profilesubject($subKey);

                      $subData = $sub->fetch_assoc();

                      $subject = $subData['description'];

                      if($data['stat'] == 1){

                        $status = '<i class="text-danger"> Not Checked </i>';

                      } elseif($data['stat'] == 2){

                        $status = '<i class="text-success"> Checked </i>';

                      } else {

                        $status = '<i> For Re-upload </i>';

                      }

                  ?>

                  <tr>
                    <td> <?= $data['filename'] ?> </td>
                    <td> <?= ucfirst($subject) ?> </td>
                    <td> <?= $data['dateuploaded'] ?> </td>
                    <td> <b> <?= $status ?> </b> </td>
                    <td> <a href="<?= $data['filepath'] ?>" class="btn btn-xs btn-info" target="_blank"> View Task </a> </td>
                  </tr>

                  <?php

                    }

                  } else {

                  ?>

                  <tr>
                    <td colspan="5" class="text-center"> This student doesn't have quiz uploaded </td>
                  </tr>

                  <?php

                  }

                  ?>
                </tbody>
              </table>
          </div>
        </div>
        <!-- End Quizzes -->
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
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../js/updatePass.js"></script>
<script>
  $(function(){

    console.log("nani");

    $("#mods").DataTable();
    $("#quiz").DataTable();

  });

</script>
