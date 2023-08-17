<?php

  session_start();

  if(isset($_SESSION['user_id'])){

    if($_SESSION['access'] == 1){

      @require 'teacher-header.php';

    } else {

      @require 'student-header.php';

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
            <h4 class="m-0 text-dark">Messaging</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Messages</li>
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
        <?php if($_SESSION['access'] == 1){ ?>
        <div class="row">
          <div class="col-lg-12 alert alert-sm alert-info">
            <div class="row">
              <h4 class="col-md-4"> My Students </h4>
              <div class="col-md-4"></div>
              <div class="col-md-4 input-group input-group-sm text-right">
                <input type="text" placeholder="Find in my students" id="findstudent" class="form-control" onkeyup="searchStudent()">
                <!--<span class="input-group-append">
                  <button type="button" class="btn btn-sm btn-success btn-flat" onclick="searchStudent()">Go!</button>
                </span>-->
              </div>
              <!-- /input-group -->
            </div>
          </div>
        </div>
        <div class="row" id="studentRes">

          <?php

            $studentList = $func->teacher_student();

            if($studentList->num_rows > 0){

              while($studData = $studentList->fetch_assoc()){

                if($stat = $studData['status'] == 1){

                  $stat = '<i class="fa fa-circle text-success"></i>';

                } else {

                  $stat = '<i class="fa fa-circle text-danger"></i>';

                }

          ?>
              <div class="col-md-3">
                <!-- Widget: user widget style 2 -->
                <div class="card card-widget widget-user-2">
                  <!-- Add the bg color to the header using any of the bg-* classes -->
                  <div class="widget-user-header bg-info">
                    <div class="widget-user-image">
                      <img class="img-circle elevation-2" src="../<?= $studData['profile_pic'] ?>" alt="User Avatar">
                    </div>
                    <!-- /.widget-user-image -->
                    <h3 class="widget-user-username"><?= $studData['firstname'].' '.$studData['lastname'] ?></h3>
                    <label class="widget-user-desc"> <?= $studData['position'].' | '.$studData['description'] ?> </label>
                    <div class="row">
                      <h5 class="col-md-8"> Status: <?= $stat ?> </h5> 
                      <a href="message-box.php?messageid=<?= $studData['userId'] ?>" class="col-md-4 float-right btn btn-sm btn-primary"> Chat </a> 
                    </div>
                  </div>
                </div>
                <!-- /.widget-user -->
              </div><hr>
                <?php

                    }

                  } else {

                ?>

                <div class="row">
                  <div class=" col-12 alert alert-sm alert-default">
                    <h5> You have no student  </h5>
                  </div>
                </div><hr>

                <?php

                  }

                  ?>
          </div><br>


          <!-- For All Faculty Messaging -->
        <div class="row">
          <div class="col-lg-12 alert alert-sm alert-info">
            <div class="row">
              <h4 class="col-md-4"> All Faculty </h4>
              <div class="col-md-4"></div>
              <div class="col-md-4 input-group input-group-sm text-right">
                <input type="text" id="findfaculty" placeholder="Find Peaople" class="form-control" onkeyup="searchfaculty()">
                <!--<span class="input-group-append">
                  <button type="button" class="btn btn-sm btn-success btn-flat">Go!</button>
                </span>-->
              </div>
              <!-- /input-group -->
            </div>
          </div>
        </div>
        <div class="row" id="facultyRes">

          <?php

            $studentList = $func->all_faculty_user();

            if($studentList->num_rows > 0){

              while($studData = $studentList->fetch_assoc()){

                if($stat = $studData['activestatus'] == 1){

                  $stat = '<i class="fa fa-circle text-success"></i>';

                } else {

                  $stat = '<i class="fa fa-circle text-danger"></i>';

                }

          ?>
              <div class="col-md-3">
                <!-- Widget: user widget style 2 -->
                <div class="card card-widget widget-user-2">
                  <!-- Add the bg color to the header using any of the bg-* classes -->
                  <div class="widget-user-header bg-info">
                    <div class="widget-user-image">
                      <img class="img-circle elevation-2" src="../images/profiles/man.png" alt="User Avatar">
                    </div>
                    <!-- /.widget-user-image -->
                    <h3 class="widget-user-username"><?= $studData['accname'] ?></h3>
                    <h5 class="widget-user-desc"> <?= $studData['empposition'] ?> </h5>
                    <div class="row">
                      <h5 class="col-md-8"> Status: <?= $stat ?> </h5> 
                      <a href="message-box.php?messageid=<?= $studData['accid'] ?>" class="col-md-4 float-right btn btn-sm btn-primary"> Chat </a> 
                    </div>
                  </div>
                </div>
                <!-- /.widget-user -->
              </div><hr>
                <?php

                    }

                  } else {

                ?>

                <div class="row">
                  <div class=" col-12 alert alert-sm alert-default">
                    <h5> You have no student  </h5>
                  </div>
                </div><hr>

                <?php

                  }

                  ?>

          </div><br>

          <?php

          } else {

          ?>

        <div class="row">
          <div class="col-lg-12 alert alert-sm alert-info">
            <div class="row">
              <h4 class="col-md-4"> My Teachers </h4>
              <div class="col-md-4"></div>
              <div class="col-md-4 input-group input-group-sm text-right">
                <input type="text" placeholder="Find in my teachers" id="teacherkey" onkeyup="searchteacher()" class="form-control">
                <!--<span class="input-group-append">
                  <button type="button" class="btn btn-sm btn-success btn-flat">Go!</button>
                </span>-->
              </div>
              <!-- /input-group -->
            </div>
          </div>
        </div>
        <div class="row" id="teacherres">

          <?php

            $studentList = $func->teachers();
            //$studentList = $func->all_faculty_user();

            if($studentList->num_rows > 0){

              while($studData = $studentList->fetch_assoc()){

                if($stat = $studData['isactive'] == 1){

                  $stat = '<i class="fa fa-circle text-success"></i>';

                } else {

                  $stat = '<i class="fa fa-circle text-danger"></i>';

                }

          ?>
              <div class="col-md-3">
                <!-- Widget: user widget style 2 -->
                <div class="card card-widget widget-user-2">
                  <!-- Add the bg color to the header using any of the bg-* classes -->
                  <div class="widget-user-header bg-info">
                    <div class="widget-user-image">
                      <img class="img-circle elevation-2" src="../images/profiles/man.png" alt="User Avatar">
                    </div>
                    <!-- /.widget-user-image -->
                    <h3 class="widget-user-username"><?= $studData['firstname'].' '.$studData['surname'] ?></h3>
                    <h5 class="widget-user-desc"> Faculty/Teacher </h5>
                    <div class="row">
                      <h5 class="col-md-8"> Status: <?= $stat ?> </h5> 
                      <a href="message-box.php?messageid=<?= $studData['accid'] ?>" class="col-md-4 float-right btn btn-sm btn-primary"> Chat </a> 
                    </div>
                  </div>
                </div>
                <!-- /.widget-user -->
              </div><hr>
                <?php

                    }

                  } else {

                ?>

                <div class="row">
                  <div class=" col-12 alert alert-sm alert-default">
                    <h5> You have no teacher  </h5>
                  </div>
                </div><hr>

                <?php

                  }

                  ?>

          </div><br>

          <!-- For All Schoolmate Messaging -->
        <div class="row">
          <div class="col-lg-12 alert alert-sm alert-info">
            <div class="row">
              <h4 class="col-md-4"> Schoolmates </h4>
              <div class="col-md-4"></div>
              <div class="col-md-4 input-group input-group-sm text-right">
                <input type="text" placeholder="Find Peaople" id="scmatekey" class="form-control" onkeyup="searchscmate()">
                <!--<span class="input-group-append">
                  <button type="button" class="btn btn-sm btn-success btn-flat">Go!</button>
                </span>-->
              </div>
              <!-- /input-group -->
            </div>
          </div>
        </div>
        <div class="row" id="scmateres">

          <?php

            $studentList = $func->all_schoolmate_user($sectionid);

            if($studentList->num_rows > 0){

              while($studData = $studentList->fetch_assoc()){

                if($stat = $studData['status'] == 1){

                  $stat = '<i class="fa fa-circle text-success"></i>';

                } else {

                  $stat = '<i class="fa fa-circle text-danger"></i>';

                }

          ?>
              <div class="col-md-3">
                <!-- Widget: user widget style 2 -->
                <div class="card card-widget widget-user-2">
                  <!-- Add the bg color to the header using any of the bg-* classes -->
                  <div class="widget-user-header bg-info">
                    <div class="widget-user-image">
                      <img class="img-circle elevation-2" src="../<?= $studData['profile_pic'] ?>" alt="User Avatar">
                    </div>
                    <!-- /.widget-user-image -->
                    <h3 class="widget-user-username"><?= $studData['firstname'].' '.$studData['lastname'] ?></h3>
                    <h5 class="widget-user-desc"> <?= $studData['position'] ?> </h5>
                    <div class="row">
                      <h5 class="col-md-8"> Status: <?= $stat ?> </h5> 
                      <a href="message-box.php?messageid=<?= $studData['userId'] ?>" class="col-md-4 float-right btn btn-sm btn-primary"> Chat </a> 
                    </div>
                  </div>
                </div>
                <!-- /.widget-user -->
              </div><hr>
                <?php

                    }

                  } else {

                ?>

                <div class="row">
                  <div class=" col-12 alert alert-sm alert-default">
                    <h5> You have no schoolmate.  </h5>
                  </div>
                </div><hr>

                <?php

                  }

                  ?>

          </div><br>

          <?php


          }

          ?>

        </div><br>
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

  } else {

    header('location:../');

  }

?>
<script src="../js/teacher.search.js"></script>
<script src="../js/student.search.js"></script>
<script>

  $(function(){

    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Timepicker
    $('#timepickerFrom').datetimepicker({
      format: 'LT'
    })

    $('#timepickerTo').datetimepicker({
      format: 'LT'
    })

  });

</script>
