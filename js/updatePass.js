
function checkPazz(){

	var pass1 = $('#pass1').val();
	var pass2 = $('#pass2').val();

	if(pass1 == "" && pass2 == ""){

		$('#ewor').fadeOut();
		$('#cpass').fadeOut();

	} else {

		if(pass2 != pass1){

			$('#ewor').fadeIn();
			$('#cpass').fadeOut();

		} else {

			$('#ewor').fadeOut();
			$('#cpass').fadeIn();

		}

	}

}

function changePass(id){

	const Toast = Swal.mixin({
	  toast: true,
	  position: 'top-end',
	  showConfirmButton: false,
	  timer: 3000
	});

	var pass2 = $('#pass2').val();
	var updates = $('#cpass').val();

	$.ajax({
		url:'../functions/updatePass.php',
		method:'POST',
		cache: false,
		dataType: 'json',
		data:{pass:pass2,userid:id,updatez:updates},
		success:function(res){

			if(res == true){

				//alert(res);

		      	Toast.fire({
		        	type: 'success',
		        	title: '&nbsp &nbsp Password updated successfuly'
		      	});

		      	var pass1 = $('#pass1').val("");
		      	var pass2 = $('#pass2').val("");

			} else {

				console.log(res);

			}

		},
		error:function(err){

			console.log(err);

		}
	});

}