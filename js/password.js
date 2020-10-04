jQuery.noConflict();

jQuery(document).ready(function ($) {


	$('#popupContainer').ready(function () {

		$('.password_edit').on('click', function () {
			let myId = "";
			if (this.id) {
				myId = this.id.split('_')[1];
			} else if ($('#id')) {
				myId = $('#id').val();
			}
			let myUrl = base_url + "index.php/auth/edit_password";
			let form_data = {
				id: myId,
				ajax: 1
			};
			$.ajax({
				type: "POST",
				url: myUrl,
				data: form_data,
				success: function (data) {
					showPopup("Change Password", data, "auto");
				}
			});
		}); // end password_edit


		$('#new_password').on('keyup', function () {
			matchPasswords();
		});

		$('#check_password').on('keyup', function () {
			matchPasswords();
		});

		$('.change_password').on('click', function () {
			let myId = $("#id").val();
			let myCurrentPassword = $('#current_password').val();
			let myNewPassword = $('#new_password').val();
			let myCheckPassword = $("#check_password").val();
			let validPassword = $("#valid_password").val();
			let form_data = {
				id: myId,
				current_password: myCurrentPassword,
				new_password: myNewPassword,
				check_password: myCheckPassword,
				ajax: 1
			};
			let myUrl = base_url + "index.php/auth/change_password";
			if (validPassword == "true" && myCurrentPassword != "") {
				$.ajax({
					type: "POST",
					url: myUrl,
					data: form_data,
					success: function (data) {
						$("#password_form").html("<h3>" + data + "</h3>");

					}
				});
			} else {
				let message = "You have the following error(s):";
				if (validPassword != "true") {
					;
					message = message + "\rYour passwords do not match!";
					$("#check_password").val("");
					$("#new_password").val("").focus();


				}
				if (myCurrentPassword == "") {
					message = message + "\rYou have not entered your current password!";

				}

				alert(message);
			}// end if validPassword;


		});

		$('.log_out').on('click', function () {
				document.location = "index.php?target=logout";
			}// end function
		);// end log_out

	});
});

function matchPasswords() {
	let newPassword=jQuery('#new_password').val();
	let checkPassword=jQuery('#check_password').val();
	if(checkPassword!="" && newPassword!="") {
		if(newPassword==checkPassword) {
			jQuery('#valid_password').val("true");
			jQuery('#password_note').fadeIn().html("Passwords Match");
		}else {
			jQuery('#valid_password').val("false");
			jQuery('#password_note').fadeIn().html("Passwords Do Not Match");
		}
	}
}