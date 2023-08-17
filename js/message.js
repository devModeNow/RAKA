
$('.mes').load('dynamic-content/message-content.php');


setInterval(function(){
	$('.mes').load('dynamic-content/message-content.php');
}, 2000);


function send(id){

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 4000
});
	//alert(id);

  var id = id;
  var send = $('#send_message').val();
  var message = $('#message').val();

  if(message == ""){

  	$('#message').addClass('is-invalid');

  	Toast.fire({
    	type: 'error',
    	title: '&nbsp &nbsp Message is Required'
  	})

  } else {


  	$('#message').removeClass('is-invalid');

	  $.ajax({
	  	url:'../functions/send_message.php',
	  	method:'POST',
	  	dataType:'json',
	  	cache:false,
	  	data:{send:send, message:message, id:id},
	  	success:function(res){

	  		if(res == true){

			  	Toast.fire({
			    	type: 'success',
			    	title: '&nbsp &nbsp Message Sent'
			  	})

			  	$('#message').val('');

	  			$('.mes').load('dynamic-content/message-content.php');

	  		} else {

	  			alert("Nani?");

	  		}

	  	},
	  	error:function(err){

	  		console.log(err);

	  	}
	  });

	}

}