  <?php

  session_start();

  require '../../functions/functions.php';

  if(isset($_POST['findteacherkey'])){

    $func = new functions($conn);

    $id = $conn->real_escape_string($_POST['findteacherkey']);

    $studentList = $func->teachers_search($id);

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
              <h5> Teaher Not Found <?= $conn->error; ?>  </h5>
            </div>
          </div><hr>

        <?php

    }

          ?>

<?php
  
  } elseif(isset($_POST['scmatekey'])){

    $func = new functions($conn);

    $id = $conn->real_escape_string($_POST['scmatekey']);

    $studentList = $func->search_schoolmate_user($id);

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
              <h5> Schoolmate not found  </h5>
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