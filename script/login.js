$('document').ready(function() { 
	/* handling form validation */
	$("#login-form").validate({
		rules: {
			password: {
				required: true,
			},
			user_email: {
				required: true,
				email: true
			},
		},
		messages: {
			password:{
			  required: "please enter your password"
			 },
			user_email: "please enter your email address",
		},
		submitHandler: submitForm	
	});	   
	/* Handling login functionality */
	function submitForm() {		
		var data = $("#login-form").serialize();				
		$.ajax({				
			type : 'POST',
			url  : 'login.php',
			data : data,
			beforeSend: function(){	
				$("#error").fadeOut();
				$("#login_button").html('<i class="fas fa-car-side"></i> sending ...');
			},
			success : function(response){						
				if(response=="ok"){									
					$("#login_button").html('<img src="ajax-loader.gif" /> Signing In ...');
					setTimeout(' window.location.href = "welcome.php"; ',4000);
				} else {									
					$("#error").fadeIn(1000, function(){						
						$("#error").html('<div class="alert alert-danger"> <i class="fas fa-exclamation"></i> '+response+' !</div>');
						$("#login_button").html('<i class="fas fa-sign-in-alt"></i> Sign In');
					});
				}
			}
		});
		return false;
	}   
});
