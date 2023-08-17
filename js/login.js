function login(){

	const Toast = Swal.mixin({
	  toast: true,
	  position: 'top-end',
	  showConfirmButton: false,
	  timer: 3000
	});


	var username = $('#username').val();
	var password = $('#password').val();
	var login = "login";

	if(username == ""){

		$('#username').addClass('is-invalid');
		$('#password').removeClass('is-invalid');

      	Toast.fire({
        	type: 'error',
        	title: '&nbsp &nbsp Username is Required'
      	})

	} else if(password == ""){

		$('#password').addClass('is-invalid');
		$('#username').removeClass('is-invalid');

      	Toast.fire({
        	type: 'error',
        	title: '&nbsp &nbsp Password is required'
      	})

	} else {

		$('#username').removeClass('is-invalid');
		$('#password').removeClass('is-invalid');

		$.ajax({
			url:'functions/login.php',
			method:'POST',
			cache: false,
			dataType:'json',
			data:{username:username, password:password, login:login},
			success:function(rem){

				if(rem.res == true){

					location.href="pages/";

				} else {

			      Toast.fire({
			        type: 'error',
			        title: '&nbsp &nbsp Username or Password is Incorrect'
			      })

				}

			},
			error:function(err){

				console.log(err);

			}
		});

	}

}