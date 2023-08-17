<?php

  session_start();
  
  if(isset($_SESSION['user_id'])){

    require 'teacher-header.php';

    //Add Student Process
    if(isset($_POST['add_stud'])){

      $teacherId = $_SESSION['user_id'];

      $studId = $conn->real_escape_string($_POST['studid']);

      $username = $conn->real_escape_string($_POST['username']);
      $password = $conn->real_escape_string($_POST['password']);

      $firstname = $conn->real_escape_string($_POST['firstname']);
      $middlename = $conn->real_escape_string($_POST['middlename']);
      $lastname = $conn->real_escape_string($_POST['lastname']);
      $contactNumber = $conn->real_escape_string($_POST['contact']);
      $email = $conn->real_escape_string($_POST['email']);

      $moth_fullname = $conn->real_escape_string($_POST['moth_fullname']);
      $moth_contact = $conn->real_escape_string($_POST['moth_contact']);
      $fath_fullname = $conn->real_escape_string($_POST['fath_fullname']);
      $fath_contact = $conn->real_escape_string($_POST['fath_contact']);

      $glevel = $conn->real_escape_string($_POST['glevel']);
      $secid = $conn->real_escape_string($_POST['secid']);
      $syear = $_SESSION['schoolyear'];

      $checkUser = $conn->query("SELECT * FROM portal_users WHERE userId = \"$studId\" OR username = \"$username\"");

      if($checkUser->num_rows > 0){

        echo '<script>alert("Student already asinged in class. Choose different student. Thank you.");</script>';

      } else {

        $insert1 = $conn->query("INSERT INTO portal_users (userId, username, password, acc_type, status)
                                 VALUES(\"$studId\",\"$username\",\"$password\",\"2\",\"1\")");

        if($insert1 == true){

          $insert2= $conn->query("INSERT INTO portal_user_details (userId, firstname, middlename, lastname, contactNumber, email, position, mothersname, motherscontactnumber, fathersname, fatherscontactnumber, createdby)
                                   VALUES(\"$studId\",\"$firstname\",\"$middlename\",\"$lastname\",\"$contactNumber\",\"$email\",\"Student\",\"$moth_fullname\",\"$moth_contact\",\"$fath_fullname\",\"$fath_contact\",\"admin\")");

          if($insert2 == true){

            $insert3 = $conn->query("INSERT INTO portal_students (studentId, gradeId, sectionid, TeacherId, studentstat, createdby)
                                     VALUES(\"$studId\",\"$glevel\",\"$secid\",\"$teacherId\",\"1\",\"admin\")");

            if($insert3 == true){

              echo '<script>alert("Student Added Successfully");</script>';

            } else {

               echo 'Failed to add student insert3 '.$conn->error;

            }

          } else {

            echo 'Failed to add student insert2';

          }

        } else {

          echo 'Failed to add student insert1';

        }

      }

    }

?>

  <?php require 'header.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0 text-dark">Add Student</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Student</li>
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
          <div class="col-lg-12 jumbotron">
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <h5>Find Student to be added</h5>
                  <select class="form-control select2" id="key" style="width: 100%;" onchange="studDetails()">
                    <option selected="selected" disabled value="">Choose Student</option>
                    <?php

                    echo $syear = $_SESSION['schoolyear'];
                    echo $secid = $conn->real_escape_string($_GET['seckey']);
                    echo $glevel = $conn->real_escape_string($_GET['subkey']);

                    //$selstuds = $func->studInfo();
                    $selstuds = $conn->query("SELECT * FROM tblschool_registration a INNER JOIN tblschool_studinfo b WHERE a.sectionid= \"$secid\" AND a.gradeid=\"$glevel\" AND a.sy_ayid=\"$syear\" AND a.accid=b.accid ORDER BY b.surname,b.firstname");

                    if($selstuds->num_rows > 0){

                      while($studata = $selstuds->fetch_assoc()){

                    ?>

                    <option value="<?= $studata['accid'] ?>"><?= $studata['firstname'].' '.$studata['middlename'].' '.$studata['surname']?></option>

                    <?php

                      }

                    } else {

                    ?>

                    <option value=""> You have no student </option>

                    <?php

                    }

                    ?>
                  </select>
                </div>
              </div>
            </div><hr>
          <form action="" method="POST" >
            <h5> Student Login Details </h5>
            <div class="row">
              <div class="col-lg-6">
                <input type="hidden" class="form-control" id="studid" name="studid" placeholder="LRN" required>
                <input type="text" class="form-control" id="lrn" name="username" placeholder="LRN" required>
              </div>
              <div class="col-lg-6">
                <input type="password" class="form-control" name="password" placeholder="Assign Password" required>
              </div>
            </div>
            <hr>
            <h5> Student Personal Details </h5>
            <div class="row">
              <div class="col-lg-4">
                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" required>
              </div>
              <div class="col-lg-4">
                <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Middle Name" required>
              </div>
              <div class="col-lg-4">
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name" required>
              </div>
            </div><br>
            <div class="row">
              <div class="col-lg-6">
                <input type="number" maxlength="11" id="contact" minlength="11" name="contact" class="form-control" placeholder="Contact Number">
              </div>
              <div class="col-lg-6">
                <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
              </div>
            </div><hr>
            <h5> Parents Details </h5>
            <div class="row">
              <div class="col-lg-6">
                <input type="text" class="form-control" id="mothFullname" name="moth_fullname" placeholder="Mother's Fullname">
              </div>
              <div class="col-lg-6">
                <input type="number" maxlength="11" id="mothContact" minlength="11" name="moth_contact" class="form-control" placeholder="Mother's Contact Number">
              </div>
            </div><hr>
            <div class="row">
              <div class="col-lg-6">
                <input type="text" class="form-control" id="fathFullname" name="fath_fullname" placeholder="Father's Fullname">
              </div>
              <div class="col-lg-6">
                <input type="number" maxlength="11" id="fathContact" minlength="11" name="fath_contact" class="form-control" placeholder="Father's Contact Number">
              </div>
            </div>
            <hr>
            <h5> Grade Level </h5>
            <div class="row">
              <div class="col-lg-12">
                <select name="glevel" id="glevel" class="form-control" onchange="gradeLevel()" required>
                  <option selected disabled value=""> Grade Level </option>
                  <?php

                $gradeLevel = $func->grade_level();

                if($gradeLevel->num_rows > 0){

                  while($gradelev = $gradeLevel->fetch_assoc()){

                  ?>

                  <option value="<?= $gradelev['gradeid'] ?>"> <?= $gradelev['description'] ?> </option>

                  <?php

                    }

                  }

                  ?>
                </select>
              </div>
            </div><hr>
            <div class="row" id="secrow">
              <h5> Section </h5>
              <div class="col-lg-12">
                <select name="secid" class="form-control" id="secData" required>
                  <!-- Section Data -->
                </select>
              </div>
              <hr>
            </div><br>
            <div class="row">
              <div class="col-lg-12 text-right">
                <input type="reset" class="btn btn-md btn-warning" value=" reset form ">
                <input type="submit" class="btn btn-md btn-success" name="add_stud" value=" Add Student ">
              </div>
            </div>
          </form>
          </div>
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

?>
<script src="../js/studentdetails.js"></script>
<script>
  $(function(){
    
    $('.select2').select2()


  });

</script>

<?php


  }


?>