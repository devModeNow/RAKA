function searchteacher(){

	var key = $('#teacherkey').val();
	//var key = this.val();

	if(key == ""){

		location.reload();

	} else {

		$.ajax({
			url:'../pages/dynamic-content/student.searchresult.php',
			method:'POST',
			cache:false,
			data:{findteacherkey:key},
			success:function(data){

				$('#teacherres').html(data);
				//alert(data);

			},
			error:function(err){

				console.log(err);

			}
		});

	}

}




function searchscmate(){

	var key = $('#scmatekey').val();
	//var key = this.val();

	if(key == ""){

		location.reload();

	} else {

		$.ajax({
			url:'../pages/dynamic-content/student.searchresult.php',
			method:'POST',
			cache:false,
			data:{scmatekey:key},
			success:function(data){

				$('#scmateres').html(data);
				//alert(data);

			},
			error:function(err){

				console.log(err);

			}
		});

	}

}