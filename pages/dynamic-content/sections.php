<?php

	if(isset($_POST['section'])){

		session_start();

		require '../../functions/functions.php';

		$func = new  functions($conn);
		
		$key = $conn->real_escape_string($_POST['key']);
		$syear = $_SESSION['syear'];
		$user_id = $_SESSION['user_id'];

		$section = $func->getSection($key);
		//$section = $conn0>query("SELECT * FROM tblschool_section WHERE sy_ayid = \"$syear\" AND  gradeid = \"$key\"  AND adviserid = \"$user_id\"");

?>

				<option value="" selected disabled> Choose Section </option>

<?php

		if($section->num_rows > 0) {

			while($data = $section->fetch_assoc()) {

?>

                <option value="<?= $data['sectionid'] ?>"> <?= $data['description'] ?> </option>

                

<?php

			}

		} else {

?>

				<option value="" disabled> You have no advisory for this grade </option>

<?php

		}



	}

?>