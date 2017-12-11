$('#popupContainer').ready(function(){
	
	$('.password_edit').on('click',function(){
		var myId="";
		if(this.id) {
			 myId=this.id.split('_')[1];
		}else if($('#id')) {
			 myId=$('#id').val();
		}
		var myUrl = base_url + "index.php/auth/edit_password";
		var form_data = {
				id: myId,
				ajax: 1
		};
		$.ajax({
			type: "POST",
			url: myUrl,
			data: form_data,
			success: function(data){
			showPopup("Change Password", data, "auto");
		}
		});
	}); // end password_edit
	
	
	$('#new_password').on('keyup',function(){
		matchPasswords();
	});
	
	$('#check_password').on('keyup',function(){
		matchPasswords();
	});
	
	$('.change_password').on('click',function(){
		var myId = $("#id").val();
		var myCurrentPassword=$('#current_password').val();
		var myNewPassword=$('#new_password').val();
		var myCheckPassword = $("#check_password").val();
		var validPassword=$("#valid_password").val();
		var form_data = {
				id: myId,
				current_password: myCurrentPassword,
				new_password: myNewPassword,
				check_password: myCheckPassword,
				ajax: 1
		};
		var myUrl = base_url + "index.php/auth/change_password";
		if(validPassword=="true" && myCurrentPassword!="") {
			$.ajax({
				type: "POST",
				url: myUrl,
				data: form_data,
				success: function(data){
				$("#password_form").html("<h3>" + data + "</h3>");
				
			}
			});
		}else {
			var message="You have the following error(s):";
			if(validPassword!="true") {;
				message=message + "\rYour passwords do not match!";
				$("#check_password").val("");
				$("#new_password").val("").focus();

				
			}
			if(myCurrentPassword=="") {
				message=message+ "\rYou have not entered your current password!";
				
			}
			
			alert(message);
		}// end if validPassword;

			
	});
	
	$('.log_out').on('click', function(){
		document.location = "index.php?target=logout";
	}// end function
	);// end log_out
	
});

function matchPasswords() {
	var newPassword=$('#new_password').val();
	var checkPassword=$('#check_password').val();
	if(checkPassword!="" && newPassword!="") {
		if(newPassword==checkPassword) {
			$('#valid_password').val("true");
			$('#password_note').fadeIn().html("Passwords Match");
		}else {
			$('#valid_password').val("false");
			$('#password_note').fadeIn().html("Passwords Do Not Match");
		}
	}
}