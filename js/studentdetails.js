function studDetails(){

	var key = $('#key').val();
	var selected = "selected";

	if(key == ""){

		alert("Please Choose a student");

	} else {

		$.ajax({
			url: '../pages/dynamic-content/student-details.php',
			method: 'POST',
			cache: false,
			dataType: 'json',
			data:{key:key, selected:selected},
			success: function(res){

				if(res.response == true){

					$('#studid').val(res.studid);
					$('#lrn').val(res.lrn);

					$('#firstname').val(res.firstname);
					$('#middlename').val(res.middlename);
					$('#lastname').val(res.surname);
					$('#contact').val(res.sms_notif_num);
					$('#mothFullname').val(res.nameofmother);
					$('#mothContact').val(res.m_contactnumber);
					$('#fathFullname').val(res.nameoffather);
					$('#fathContact').val(res.f_contactnumber);

					$('#glevelz').val(res.gradeLevel);
					$('#secData').val(res.section);
					$('#glevelDesc').val(res.gdesc);
					$('#secDataDesc').val(res.secdesc);

				} else {



				}

			},
			error:function(err){

				console.log(err);

			}
		});

	}

}

function gradeLevel(){

	var key = $('#glevel').val();
	var section = key;

	if(key == ""){

		alert("Please Choose a student");

	} else {

		$.ajax({
			url: '../pages/dynamic-content/sections.php',
			method: 'POST',
			cache: false,
			data:{key:key, section:section},
			success: function(res){

				$('#secrow').fadeIn(function(){
					$('#secData').html(res);
				});

			},
			error: function(err){

				console.log(err);
				
			}
		});

	}

}

function sectionz(){

	var section = $('#secData').val();

	alert(section);

}