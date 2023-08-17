<?php

	require '../../functions/functions.php';

	if(isset($_POST['selected'])){

		session_start();

		$key = $conn->real_escape_string($_POST['key']);
		$syear = $_SESSION['schoolyear'];

		$func = new functions($conn);

		$studs = $func->perstudInfo($key, $syear);

		if($studs->num_rows > 0){

			$data = $studs->fetch_assoc();

			$glev = $data['gradeid'];
			$sec = $data['sectionid'];

			$selglev = $conn->query("SELECT * FROM tblschool_glevel WHERE gradeid = \"$glev\"");

			$glevdata = $selglev->fetch_assoc();


			$secsel = $conn->query("SELECT * FROM tblschool_section WHERE sectionid = \"$sec\"");

			$secdata = $secsel->fetch_assoc();

			$response = array('response'=>true,
							  'studid'=>$data['accid'],
							  'lrn'=>$data['lrn'],
							  'firstname'=>$data['firstname'],
							  'middlename'=>$data['middlename'],
							  'surname'=>$data['surname'],
							  'sms_notif_num'=>$data['sms_notif_num'],
							  'nameofmother'=>$data['nameofmother'],
							  'm_contactnumber'=>$data['m_contactnumber'],
							  'nameoffather'=>$data['nameoffather'],
							  'f_contactnumber'=>$data['f_contactnumber'],
							  'gradeLevel'=>$data['gradeid'],
							  'section'=>$data['sectionid'],
							  'gdesc'=>$glevdata['description'],
							  'secdesc'=>$secdata['description']
							);
			echo json_encode($response);


		} else {

			$response = array('response'=>false);
			echo json_encode($response);

		}

	}

?>