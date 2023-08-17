function searchStudent(){

	var key = $('#findstudent').val();
	//var key = this.val();

	if(key == ""){

		location.reload();

	} else {

		$.ajax({
			url:'../pages/dynamic-content/teacher.searchresult.php',
			method:'POST',
			cache:false,
			data:{findstudkey:key},
			success:function(data){

				$('#studentRes').html(data);
				//alert(data);

			},
			error:function(err){

				console.log(err);

			}
		});

	}

}




function searchfaculty(){

	var key = $('#findfaculty').val();
	//var key = this.val();

	if(key == ""){

		location.reload();

	} else {

		$.ajax({
			url:'../pages/dynamic-content/teacher.searchresult.php',
			method:'POST',
			cache:false,
			data:{findfackey:key},
			success:function(data){

				$('#facultyRes').html(data);
				//alert(data);

			},
			error:function(err){

				console.log(err);

			}
		});

	}

}