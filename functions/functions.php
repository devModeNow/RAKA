<?php

	require 'db.php';

	class functions{

		private $dbase;
		public $id;

		public function __construct($database){

			@$this->dbase = $database;
			@$this->id = $_SESSION['user_id'];
			@$this->syear = $_SESSION['schoolyear'];

		}

		public function user_info($id){

			$query = $this->dbase->query("SELECT * FROM tblhr_personalinfo a, tblaccounts b WHERE a.accid = \"$id\" AND a.accid = b.accid");
			return $query;

		}

		public function user_student_info($id){

			$query = $this->dbase->query("SELECT * FROM portal_user_details WHERE userId = \"$id\"");
			return $query;

		}

		public function stud_info($id){

			$query = $this->dbase->query("SELECT * FROM portal_user_details a, portal_students b WHERE a.userId = b.studentId AND a.userId = \"$id\"");
			return $query;

		}

		//old function
		//public function teacher_subject(){

			//$query = $this->dbase->query("SELECT * FROM portal_subjects");
			//return $query;

		//}

		//new function
		public function teacher_subject($key, $sectionid){

			//$query = $this->dbase->query("SELECT * FROM tblschool_subjects WHERE gradeid = \"$key\"");
            $query = $this->dbase->query("SELECT * FROM tblschool_subjects a, tblschool_class_sched b WHERE a.gradeid = b.gradeid AND a.gradeid = \"$key\" AND b.teacherid = \"$this->id\" AND b.sectionid = \"$sectionid\" AND a.subjectid = b.subjectid");
			return $query;

		}

		//new function
		public function profilesubject($key){

			$query = $this->dbase->query("SELECT * FROM tblschool_subjects WHERE subjectid = \"$key\"");
			return $query;

		}

		public function stud_subject($gradeId, $sectionid, $TeacherId){

			$query = $this->dbase->query("SELECT DISTINCT a.gradeid, a.sectionid, b.subjectid, b.description FROM tblschool_section a, tblschool_subjects b WHERE a.gradeid = \"$gradeId\" AND a.sectionid = \"$sectionid\" AND a.adviserid = \"$TeacherId\" AND a.gradeid = b.gradeid");
			return $query;

		}



		//old function
		//public function subject_details($id){

			//$query = $this->dbase->query("SELECT * FROM portal_subjects WHERE subjectid = \"$id\"");
			//return $query;

		//}

		//new function
		public function subject_details($subkey, $key){

			$query = $this->dbase->query("SELECT * FROM tblschool_subjects WHERE gradeid = \"$subkey\" AND subjectid = \"$key\"");
			return $query;

		}

		//old function (still using)
		public function module_details($id, $secId){

			$query = $this->dbase->query("SELECT * FROM portal_modules WHERE sectionid = \"$secId\" AND subjectid = \"$id\" AND stat = 1 AND uploadedby = \"$this->id\" OR 
																			 sectionid = \"$secId\" AND subjectid = \"$id\" AND stat = 1 AND acctype = \"1\" OR
																			 sectionid = \"$secId\" AND subjectid = \"$id\" AND stat = 1 AND acctype = \"2\" ");
			return $query;

		}

		//new function
		public function quiz_details($id, $secId){

			$query = $this->dbase->query("SELECT * FROM portal_quizzes WHERE sectionid = \"$secId\" AND subjectid = \"$id\" AND stat = 1 AND quiztype = \"creator\" AND uploadedby = \"$this->id\" OR 
																			 sectionid = \"$secId\" AND subjectid = \"$id\" AND stat = 1 AND quiztype = \"creator\" AND acctype = \"1\" OR
																			 sectionid = \"$secId\" AND subjectid = \"$id\" AND stat = 1 AND quiztype = \"creator\" AND acctype = \"2\" OR
																			 sectionid = \"$secId\" AND subjectid = \"$id\" AND stat = 3 AND quiztype = \"creator\" AND uploadedby = \"$this->id\" OR 
																			 sectionid = \"$secId\" AND subjectid = \"$id\" AND stat = 3 AND quiztype = \"creator\" AND acctype = \"1\" OR
																			 sectionid = \"$secId\" AND subjectid = \"$id\" AND stat = 3 AND quiztype = \"creator\" AND acctype = \"2\"");
			return $query;

		}

		//new function
		public function task_details($id, $secId){

			$query = $this->dbase->query("SELECT * FROM portal_performance_task WHERE sectionid = \"$secId\" AND subjectid = \"$id\" AND stat = 1 AND quiztype = \"creator\" AND uploadedby = \"$this->id\" OR 
																			 sectionid = \"$secId\" AND subjectid = \"$id\" AND stat = 1 AND quiztype = \"creator\" AND acctype = \"1\" OR
																			 sectionid = \"$secId\" AND subjectid = \"$id\" AND stat = 1 AND quiztype = \"creator\" AND acctype = \"2\" OR
																			 sectionid = \"$secId\" AND subjectid = \"$id\" AND stat = 3 AND quiztype = \"creator\" AND uploadedby = \"$this->id\" OR 
																			 sectionid = \"$secId\" AND subjectid = \"$id\" AND stat = 3 AND quiztype = \"creator\" AND acctype = \"1\" OR
																			 sectionid = \"$secId\" AND subjectid = \"$id\" AND stat = 3 AND quiztype = \"creator\" AND acctype = \"2\"");
			return $query;

		}

		//new function
		public function quiz_answer_details($id, $secId, $qid){

			$query = $this->dbase->query("SELECT * FROM portal_quizzes WHERE sectionid = \"$secId\" AND subjectid = \"$id\" AND quizzId = \"$qid\" AND quiztype = \"respondent\" AND stat != 0 ORDER BY id DESC");
			return $query;

		}

		//new function
		public function task_answer_details($id, $secId, $qid){

			$query = $this->dbase->query("SELECT * FROM portal_performance_task WHERE sectionid = \"$secId\" AND subjectid = \"$id\" AND quizzId = \"$qid\" AND quiztype = \"respondent\" AND stat != 0 ORDER BY id DESC");
			return $query;

		}


		public function module_count(){

			$query = $this->dbase->query("SELECT count(*) FROM portal_modules");
			return $query;

		}

		public function student_module_count($gradeId){

			$query = $this->dbase->query("SELECT count(*) FROM portal_modules a, tblschool_subjects b WHERE a.subjectid = b.subjectid AND a.gradeId = \"$gradeId\" AND a.stat = 1 AND a.uploadedby = \"$this->id\"");
			return $query;

		}

		public function module_details_stud($gradeId){

			$query = $this->dbase->query("SELECT * FROM portal_modules a, tblschool_subjects b, portal_user_details c WHERE a.gradeid = b.gradeid AND a.subjectid = b.subjectid AND a.uploadedby = c.userId AND a.gradeId = \"$gradeId\" AND a.uploadedby = \"$this->id\" AND a.stat = 1");
			return $query;

		}

		public function subject_count(){

			$query = $this->dbase->query("SELECT count(*) FROM portal_subjects");
			return $query;

		}

		public function student_subject_count($gradeId){

			$query = $this->dbase->query("SELECT count(*) FROM tblschool_subjects WHERE gradeid = \"$gradeId\"");
			return $query;

		}


		//old function
		//public function grade_level(){

			//$query = $this->dbase->query("SELECT * FROM portal_gradelevel");
			//return $query;

		//}

		//new function
		public function grade_level(){

			$query = $this->dbase->query("SELECT * FROM tblschool_glevel");
			return $query;

		}

		//old function
		public function stud_count(){

			$query = $this->dbase->query("SELECT count(*) FROM portal_students WHERE TeacherId = \"$this->id\"");
			return $query;

		}


		//new function
		public function classCount(){

			$query = $this->dbase->query("SELECT count(*) FROM tblschool_section WHERE adviserid = \"$this->id\" AND sy_ayid =".@$_SESSION['schoolyear']);
			return $query;

		}


		//old function
		public function teacher_student(){

			$query = $this->dbase->query("SELECT * FROM portal_students a, portal_user_details b, tblschool_glevel c, portal_users d WHERE a.studentId = b.userId AND a.gradeId = c.gradeid AND d.userId = a.studentId AND a.teacherId = \"$this->id\" LIMIT 12");
			return $query;

		}

		//new function for search
		public function teacher_student_message_search($id){

			$query = $this->dbase->query("SELECT * FROM portal_students a, portal_user_details b, tblschool_glevel c, portal_users d WHERE 
										  a.studentId = b.userId AND a.gradeId = c.gradeid AND d.userId = a.studentId AND a.teacherId = \"$this->id\" AND b.firstname LIKE \"%$id%\" OR
										  a.studentId = b.userId AND a.gradeId = c.gradeid AND d.userId = a.studentId AND a.teacherId = \"$this->id\" AND b.middlename LIKE \"%$id%\" OR
										  a.studentId = b.userId AND a.gradeId = c.gradeid AND d.userId = a.studentId AND a.teacherId = \"$this->id\" AND b.lastname LIKE \"%$id%\" OR
										  a.studentId = b.userId AND a.gradeId = c.gradeid AND d.userId = a.studentId AND a.teacherId = \"$this->id\" AND d.username LIKE \"%$id%\"");
			return $query;

		}

		//new function
		public function mystudents($seckey){

			//$query = $this->dbase->query("SELECT * FROM portal_students a, portal_user_details b, portal_users d WHERE a.studentId = b.userId AND d.userId = a.studentId AND a.sectionid = \"$seckey\" AND a.teacherId = \"$this->id\"");
			$query = $this->dbase->query("SELECT * FROM portal_students a, portal_user_details b, portal_users d WHERE a.studentId = b.userId AND d.userId = a.studentId AND a.sectionid = \"$seckey\" ORDER BY b.lastname ASC");
			return $query;

		}


		//new function
		public function teacher_classes(){

			//$query = $this->dbase->query("SELECT * FROM tblschool_section WHERE adviserid = \"$this->id\" AND sy_ayid =".@$_SESSION['schoolyear']);
           	$query = $this->dbase->query("SELECT DISTINCT a.gradeid, a.sectionid, a.description FROM tblschool_section a, tblschool_class_sched b WHERE a.sy_ayid  = b.sy_ayid AND a.sy_ayid = ".@$_SESSION['schoolyear']." AND a.gradeid = b.gradeid AND a.sectionid = b.sectionid");
            //$query = $this->dbase->query("SELECT * FROM tblschool_class_sched  WHERE teacherid = \"$this->id\" AND sy_ayid = \"$this->syear\"");
			return $query;

		}

		
		//old function
		public function teachers(){

			//$query = $this->dbase->query("SELECT * FROM portal_students a, tblaccounts b, tblhr_personalinfo c WHERE a.TeacherId = b.accid AND a.TeacherId = c.accid AND a.studentId = \"$this->id\" AND b.acctype = 1");
			$query = $this->dbase->query("SELECT * FROM tblusers a, tblaccounts b, tblhr_personalinfo c WHERE a.employeeid = b.accid AND c.accid = a.employeeid AND b.acctype = 1 AND b.isactive = 1 ORDER BY accname ASC LIMIT 12");
			return $query;

		}

		//new function from search teacher
		public function teachers_search($id){

			$query = $this->dbase->query("SELECT * FROM tblusers a, tblaccounts b, tblhr_personalinfo c WHERE
										  a.employeeid = b.accid AND c.accid = a.employeeid AND b.acctype = 1 AND b.isactive = 1 AND b.accname LIKE \"%$id%\" OR
										  a.employeeid = b.accid AND c.accid = a.employeeid AND b.acctype = 1 AND b.isactive = 1 AND c.firstname LIKE \"%$id%\" OR
										  a.employeeid = b.accid AND c.accid = a.employeeid AND b.acctype = 1 AND b.isactive = 1 AND c.middlename LIKE \"%$id%\" OR
										  a.employeeid = b.accid AND c.accid = a.employeeid AND b.acctype = 1 AND b.isactive = 1 AND c.surname LIKE \"%$id%\"");


			/*$query = $this->dbase->query("SELECT * FROM portal_students a, tblaccounts b, tblhr_personalinfo c WHERE 
										  a.TeacherId = b.accid AND a.TeacherId = c.accid AND a.studentId = \"$this->id\" AND b.acctype = 1 AND b.accname LIKE \"%$id%\" OR
										  a.TeacherId = b.accid AND a.TeacherId = c.accid AND a.studentId = \"$this->id\" AND b.acctype = 1 AND c.firstname LIKE \"%$id%\" OR
										  a.TeacherId = b.accid AND a.TeacherId = c.accid AND a.studentId = \"$this->id\" AND b.acctype = 1 AND c.middlename LIKE \"%$id%\" OR
										  a.TeacherId = b.accid AND a.TeacherId = c.accid AND a.studentId = \"$this->id\" AND b.acctype = 1 AND c.surname LIKE \"%$id%\"");*/
			return $query;

		}


		//old function
		//public function all_user(){

			//$query = $this->dbase->query("SELECT * FROM portal_user_details a, portal_users b WHERE a.userId = b.userId");
			//return $query;

		//}

		//new function
		public function all_faculty_user(){

			$query = $this->dbase->query("SELECT * FROM tblusers a, tblaccounts b WHERE a.employeeid = b.accid AND b.acctype = 1 ORDER BY accname ASC LIMIT 12");
			return $query;

		}

		//new function for faculty search
		public function all_faculty_search($id){

			$query = $this->dbase->query("SELECT * FROM tblusers a, tblaccounts b WHERE a.employeeid = b.accid AND b.acctype = 1 AND a.employeeid LIKE \"%$id%\" OR
										  												a.employeeid = b.accid AND b.acctype = 1 AND b.accname LIKE \"%$id%\"
										  																							ORDER BY accname ASC");
			return $query;

		}

		public function all_schoolmate_user($secid){

			$query = $this->dbase->query("SELECT * FROM portal_students a, portal_user_details b, portal_users c WHERE a.studentId = b.userId AND b.userId = c.userId AND a.sectionid = \"$secid\" ORDER BY a.studentId ASC");
			return $query;

		}

		public function search_schoolmate_user($id, $secid){

			$query = $this->dbase->query("SELECT * FROM portal_students a, portal_user_details b, portal_users c WHERE
										  a.studentId = b.userId AND b.userId = c.userId AND a.sectionid = \"$secid\" AND b.firstname LIKE \"%$id%\" OR
										  a.studentId = b.userId AND b.userId = c.userId AND a.sectionid = \"$secid\" AND b.middlename LIKE \"%$id%\" OR
										  a.studentId = b.userId AND b.userId = c.userId AND a.sectionid = \"$secid\" AND b.lastname LIKE \"%$id%\"
										  ORDER BY a.studentId ASC");
			return $query;

		}


		public function announcements(){

			$query = $this->dbase->query("SELECT * FROM portal_announcement WHERE announceStat = 1 ORDER BY announceDate DESC");
			return $query;

		}

		public function Studannouncements($secID){

			$query = $this->dbase->query("SELECT * FROM portal_announcement WHERE audience = \"$secID\" AND announceStat = 1 OR audience = \"allaudience\" AND announceStat = 1 ORDER BY announceDate DESC");
			return $query;

		}

		public function send_message($to, $from, $message, $exchange, $datez){

			$query = $this->dbase->query("INSERT INTO portal_messaging (torecepient, fromrecepient, message, exchange, datesent)
										  VALUES (\"$to\",\"$from\",\"$message\",\"$exchange\",\"$datez\")");
			return $query;
		}

		public function syear(){

			$query = $this->dbase->query("SELECT * FROM tblschool_acadyear ORDER BY sy_ayid DESC");
			return $query;

		}

		//new function
		public function gradeLevel($key){

			$query = $this->dbase->query("SELECT * FROM tblschool_glevel WHERE gradeid = \"$key\"");
			return $query;
		}

		public function studInfo(){

			$query = $this->dbase->query("SELECT * FROM tblschool_studinfo ORDER BY accid DESC");
			return $query;

		}

		public function perstudInfo($key, $syear){

			$query = $this->dbase->query("SELECT * FROM tblschool_studinfo a, tblschool_registration b WHERE a.accid = b.accid AND a.accid = \"$key\" AND b.sy_ayid = \"$syear\"");
			return $query;

		}

		public function getSection($key){

			$query = $this->dbase->query("SELECT * FROM tblschool_section WHERE sy_ayid = \"$this->syear\" AND  gradeid = \"$key\"  AND adviserid = \"$this->id\"");
			return $query;

		}


		//new functions

		public function selectGrade($id){

			$query = $this->dbase->query("SELECT * FROM tblschool_glevel WHERE gradeid = \"$id\"");
			return $query;

		}

		public function selectSection($id){

			$query = $this->dbase->query("SELECT * FROM tblschool_section WHERE sectionid = \"$id\"");
			return $query;

		}

		public function personuploaded($id){

			$query = $this->dbase->query("SELECT * FROM portal_user_details a, portal_modules b WHERE a.userId = b.uploadedby AND a.userId =\"$id\" AND b.stat = 1");
			return $query;

		}

		//New Function
		public function profileModules($id){

			$query = $this->dbase->query("SELECT * FROM portal_modules WHERE uploadedby = \"$id\" AND stat != 0");
			return $query;

		}

		//New Function
		public function profileQuizzes($id){

			$query = $this->dbase->query("SELECT * FROM portal_quizzes WHERE uploadedby = \"$id\" AND quiztype = \"respondent\" AND stat != 0");
			return $query;

		}

		//New Function
		public function profileTasks($id){

			$query = $this->dbase->query("SELECT * FROM portal_performance_task WHERE uploadedby = \"$id\" AND quiztype = \"respondent\" AND stat != 0");
			return $query;

		}

	}

?>
