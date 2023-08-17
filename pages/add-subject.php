<?php

  session_start();
  
  if(isset($_SESSION['user_id'])){

    require 'teacher-header.php';

    //Add Student Process
    if(isset($_POST['add_sub'])){

      $teacherId = $_SESSION['user_id'];
      $subID = 'sub_'.rand(3,12345);

      $studId = rand(2,123456789);

      $glevel = $conn->real_escape_string($_POST['glevel']);
      $subDesc = $conn->real_escape_string($_POST['subDesc']);

      $TimeFrom = $conn->real_escape_string($_POST['TimeFrom']);
      $TimeTo = $conn->real_escape_string($_POST['TimeTo']);

      $insert1 = $conn->query("INSERT INTO portal_subjects (gradeId, subjectId, subjectDesc, teacherId) VALUES(\"$glevel\",\"$subID\",\"$subDesc\",\"$teacherId\")");

      if($insert1 == true){

        foreach($_POST['SubDays'] as $days){

          $insert2 = $conn->query("INSERT INTO portal_subjectsched(subjectId, gradeId, day, timeFrom, timeTo, createdby)
                                  VALUES(\"$subID\",\"$glevel\",\"$days\",\"$TimeFrom\",\"$TimeTo\",\"$teacherId\")");
        }

        if($insert2 == true){

          echo '<script> alert("Subject Added Successfully"); </script>';

        } else {

          echo 'error in insert2 '.$conn->error;

        }

      } else {

        echo 'error in inser1 '.$conn->error;

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
          <form action="" method="POST" >
            <h5> Subject Details </h5>
            <div class="row">
              <div class="col-lg-6">
                <select name="glevel" class="form-control" required>
                  <option selected disabled value=""> Grade Level </option>
                  <?php

                $gradeLevel = $func->grade_level();

                if($gradeLevel->num_rows > 0){

                  while($gradelev = $gradeLevel->fetch_assoc()){

                  ?>

                  <option value="<?= $gradelev['gradeId'] ?>"> <?= $gradelev['gradeDesc'] ?> </option>

                  <?php

                    }

                  }

                  ?>
                </select>
              </div>
              <div class="col-lg-6">
                <input type="text" class="form-control" name="subDesc" placeholder="Subject Description" required>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label>Days</label>
                  <select class="select2" multiple="multiple" name="SubDays[]" data-placeholder="Select a day" style="width: 100%;" required>
                    <option value="Monday" >Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-3">
                <!-- time Picker -->
                <div class="bootstrap-timepicker">
                  <div class="form-group">
                    <label>Time picker From:</label>

                    <div class="input-group date" id="timepickerFrom" data-target-input="nearest">
                      <input type="text"name="TimeFrom" class="form-control datetimepicker-input" data-target="#timepicker"/ required>
                      <div class="input-group-append" data-target="#timepickerFrom" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="far fa-clock"></i></div>
                      </div>
                      </div>
                    <!-- /.input group -->
                  </div>
                  <!-- /.form group -->
                </div>
              </div>
              <div class="col-lg-3">
                <!-- time Picker -->
                <div class="bootstrap-timepicker">
                  <div class="form-group">
                    <label>To</label>

                    <div class="input-group date" id="timepickerTo" data-target-input="nearest">
                      <input type="text" name="TimeTo" class="form-control datetimepicker-input" data-target="#timepicker"/ required>
                      <div class="input-group-append" data-target="#timepickerTo" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="far fa-clock"></i></div>
                      </div>
                      </div>
                    <!-- /.input group -->
                  </div>
                  <!-- /.form group -->
                </div>
              </div>
            </div><hr><br>
            <div class="row">
              <div class="col-lg-12 text-right">
                <input type="reset" class="btn btn-md btn-warning" value=" reset form ">
                <input type="submit" class="btn btn-md btn-success" name="add_sub" value=" Add Subject ">
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

  }


?>

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