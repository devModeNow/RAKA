<?php

  session_start();

  if(isset($_SESSION['user_id'])){

    if($_SESSION['access'] == 1){

      @require 'teacher-header.php';

    } else {

      @require 'student-header.php';

    }

    $keyId = $conn->real_escape_string($_GET['messageid']);
    $_SESSION['reciSession'] = $keyId;

?>

  <?php require 'header.php'; ?>


<?php


	if(isset($_POST['send_message'])){



	}

?>

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">

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
      	<div class="row">
      		<div class="col-12">
            <!-- DIRECT CHAT PRIMARY -->
            <div class="card card-prirary cardutline direct-chat direct-chat-primary">
              <div class="card-header">
              	<?php 

                    $data1 = $func->user_info($_GET['messageid']);
                    $reciData1 = $data1->fetch_assoc();


                    $data2 = $func->user_student_info($_GET['messageid']);
                    $reciData2 = $data2->fetch_assoc();

              	?>
                <h3 class="card-title"> <?= $reciData1['firstname'].' '.$reciData1['surname']; ?> </h3>
                <h3 class="card-title"> <?= $reciData2['firstname'].' '.$reciData2['lastname']; ?> </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <a href="messages.php" type="button" class="btn btn-tool"><i class="fas fa-times"></i>
                  </a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body mes">
                <!-- Conversations are loaded here -->

              </div>
              <!-- /.card-body -->

              <div class="card-footer">
	              <div class="input-group">
	                <input type="text" required name="message" id="message" placeholder="Type Message ..." class="form-control">
	                <span class="input-group-append">
	                  <button type="submit" name="send_message" id="send_message" onclick="send(<?= $keyId ?>)" class="btn btn-primary">Send</button>
	                </span>
	              </div>
              </div>
              <!-- /.card-footer-->
            </div>
            <!--/.direct-chat -->
      		</div>
      	</div>
      </div>
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

<?php require 'footer.php'; ?>
 <script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../js/message.js"></script>

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



<?php

	} else {

    header('location:../404.php');

  }

?>