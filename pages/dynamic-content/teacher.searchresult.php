  <?php

  session_start();

  require '../../functions/functions.php';

  if(isset($_POST['findstudkey'])){

    $func = new functions($conn);

    $id = $conn->real_escape_string($_POST['findstudkey']);

    $studentList = $func->teacher_student_message_search($id);

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
              <h5> Student not found <?= $conn->error; ?>  </h5>
            </div>
          </div><hr>

        <?php

    }

          ?>

<?php
  
  } elseif(isset($_POST['findfackey'])){

    $func = new functions($conn);

    $id = $conn->real_escape_string($_POST['findfackey']);

    $studentList = $func->all_faculty_search($id);

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
              <h5> Faculty/Teacher not found  </h5>
            </div>
          </div><hr>

        <?php

    }

          ?>

<?php

  } else {

    header('location:../../404.php');

  }

?>