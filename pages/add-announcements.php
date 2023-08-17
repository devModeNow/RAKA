<?php

  session_start();
  
  if(isset($_SESSION['user_id'])){

    require 'teacher-header.php';


    //Add Student Process
    if(isset($_POST['post_announcement'])){

      $announcement = $conn->real_escape_string($_POST['announcement']);
      $id = $_SESSION['user_id'];

      $query = $conn->query("INSERT INTO portal_announcement (announcement, announcedBy) VALUES(\"$announcement\",\"$id\")");

      if($query == true){

        echo '<script>alert("Announcement Posted Successfully");</script>';

      } else {

        echo $conn->error;

      }

    }

    $ann = "";

    if(isset($_GET['announcementID'])){

      $annId = $conn->real_escape_string($_GET['announcementID']);

      $query = $conn->query("UPDATE portal_announcement SET announceStat = 0 WHERE id = \"$annId\"");
 
      $ann= "";

      if($query == true){

        $ann = "Announcement Deleted Successfully";
        header('location:add-announcements.php');

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
            <h4 class="m-0 text-dark">Announcement</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Announcement</li>
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
            <h5> Add Announcement </h5>
            <div class="row">
              <div class="col-lg-12">
              <textarea class="form-control ann_box" name="announcement" placeholder="Input Announcement Here"></textarea>
              </div>
            </div>
            <div class="row mt-2 text-right">
              <div class="col-lg-12">
              <input type="submit" class="btn btn-sm btn-success" name="post_announcement" value="Post">
              <input type="reset" class="btn btn-sm btn-warning" value="Reset">
              </div>
            </div>
            <hr>
            <div class="row">
              <section class="col-12 ann_panel">
              <?php

              $ann = $func->announcements();

              if($ann->num_rows > 0){

                while($annData = $ann->fetch_assoc()){

                  $id = $annData['announcedBy'];

                  $fullname = $func->user_info($id);

                  $fullname = $fullname->fetch_assoc();

                  $fullname = $fullname['firstname'].' '.$fullname['surname'];

              ?>
                <div class="row">
                  <div class=" col-12 alert alert-sm alert-info">
                    <div class="timeline-item">
                      <span class="time float-right"><i class="fas fa-calendar"></i> <?= $annData['announceDate'] ?> </span>
                      <h5 class="timeline-header"><?= $fullname ?> Posted an announcement</h5><hr>
                      <div class="timeline-body">
                        <?= $annData['announcement'] ?>
                      </div><hr>
                      <div class="timeline-footer">
                        <button class="btn btn-xs btn-danger float-right" name="delete_announcement"> <a href="?announcementID=<?= $annData['id'] ?>"> Delete Announcement </a></button>
                      </div>
                    </div>
                  </div>
                </div><hr>
                <?php

                    }

                  } else {

                ?>

                  <h3 class="col-12 alert alert-sm alert-info text-center"> No Posted Announcement. </h3><hr>

                <?php

                  }

                ?>
              </section>
            </div><br>
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