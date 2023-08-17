<?php

    session_start();
    require '../functions/db.php';

    if(isset($_SESSION['user_id'])){

        header('location:pages/');

    } else {


      if(isset($_POST['subnewpass'])){

        // Multiple recipients
        //$to = 'johny@example.com'; // note the comma
          $to = $_POST['emailz'];
          $newPass = rand(6,121364);

        $selectEmail =  $conn->query("SELECT userId,email FROM portal_user_details WHERE email = \"$to\"");

        if($selectEmail->num_rows > 0){

            $data = $selectEmail->fetch_row();
            $id = $data[0];

            // Subject
            $subject = 'New Portal Password';

            // Message
            $message = '
            <html>
            <head>
              <title>New Portal Password</title>
            </head>
            <body>
              <p>Hello User. Your new password is <strong> '.$newPass.' </strong> </p>
              <a class="btn btn-xs btn-primary" href="http://58.69.194.140:8081/RJL-SPS - raka/" target="_blank"> Go to portal login </a>
            </body>
            </html>
            ';

            // To send HTML mail, the Content-type header must be set
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';

            // Additional headers
            $headers[] = 'To: '.$to;
            $headers[] = 'From: Regina Assumpta Kids Academy <raka@gmail.com>';
            //$headers[] = 'Cc: birthdayarchive@example.com';
            //$headers[] = 'Bcc: birthdaycheck@example.com';

            // Mail it
            //$sent = mail($to, $subject, $message, implode("\r\n", $headers));

            //if($sent){

                $updatePass = $conn->query("UPDATE portal_users SET password = \"$newPass\" WHERE userId = \"$id\"");

                if($updatePass){

                  $message = "<span class='alert alert-sm alert-success'>Password change. Please check your <strong> email </strong> for your new password.</span>";

                } else {

                  $message = $conn->error;

                }

            //} else {

               // $message = "Error";

           // }

        } else {

          $message = "<span class='alert alert-sm alert-danger'>Email not  found.</span>";

        }


      } else {

          $message = "";

      }

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>RAKA | Forgot Password</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../css/added-styles.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="icon" type="icon/image" href="../images/school.logo.png">
</head>
<body class="hold-transition login-page">
  <?php echo $message ?>
<div class="login-box">
    <div class="login-logo">
      <p> <strong> Regina Assumpta Kids Academy </strong> </p>
    </div>
  <!-- /.login-logo -->
    <div class="liz">
      <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="email" name="emailz" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" name="subnewpass" class="btn btn-primary btn-block">Request new password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        Return to <a href="../">Login</a>
      </p>
    </div>
    <!-- /.login-card-body -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>

</body>
</html>
<?php

    }

?>