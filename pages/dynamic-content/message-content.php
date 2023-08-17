<?php

	session_start();

	if(isset($_SESSION['user_id'])){

		require '../../functions/db.php';
		require '../../functions/functions.php';

		$func = new functions($conn);

		$key = $_SESSION['user_id'];
		$to = $_SESSION['reciSession'];

		$selMessage = $conn->query("SELECT * FROM portal_messaging WHERE fromrecepient = \"$key\" AND torecepient = \"$to\" OR fromrecepient = \"$to\" AND torecepient = \"$key\" AND messagestat != 0 ORDER BY id ASC");

		if($selMessage->num_rows > 0){

			while($mesData = $selMessage->fetch_assoc()){

?>

                <div class="direct-chat-messages">
                  <!-- Message. Default to the left -->
                  <?php

                  	if($mesData['exchange'] == 1){

                  		$user_key = $to;
                  		$userData = $func->user_info($user_key);

                  		$userData = $userData->fetch_assoc();
                  ?>
                  <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                      <!--<span class="direct-chat-name float-left"><?= $userData['firstname'].' '.$userData['lastname'] ?></span>-->
                      <span class="direct-chat-timestamp float-left">  <?= $mesData['datesent'] ?> </span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="../images/profiles/man.png" alt="Message User Image">
                    <!-- /.direct-chat-img -->
                    <div class="float-left direct-chat-text">
                      <?= $mesData['message'] ?>
                    </div>
                    <!-- /.direct-chat-text -->
                  </div>
                  <!-- /.direct-chat-msg -->

                  <?php

                  	}


                  	if($mesData['exchange'] == 0) {

                  		$user_key = $key;
                  		$userData = $func->user_info($user_key);

                  		$userData = $userData->fetch_assoc();

                  ?>

                  <!-- Message to the right -->
                  <div class="direct-chat-msg right">
                    <div class="direct-chat-infos clearfix">
                      <!--<span class="direct-chat-name float-right">&nbsp;&nbsp;&nbsp;&nbsp;<?= $userData['firstname'].' '.$userData['lastname'] ?></span>-->
                      <span class="direct-chat-timestamp float-right"><?= $mesData['datesent'] ?></span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="../images/profiles/man.png" alt="Message User Image">
                    <!-- /.direct-chat-img -->
                    <div class="float-right text-right direct-chat-text">
                      <?= $mesData['message'] ?>
                    </div>
                    <!-- /.direct-chat-text -->
                  </div>
                  <!-- /.direct-chat-msg -->
                  <?php

                  	}

                  ?>
                </div>
                <!--/.direct-chat-messages-->

<?php

			}

		} else {

?>	
					<br/><br/><br/>
                    <div class="text-center row m-auto col-md-6 alert alert-warning">
                      You don't have any conversation yet. <strong> Start chatting now!</strong>
                    </div>
                    <!-- /.direct-chat-text -->

<?php

		}

	} else {

		header('location:../');

	}

?>