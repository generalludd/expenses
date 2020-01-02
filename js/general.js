$(document).ready(function () {

		$(".delete.ajax.inline").on("click", function (e) {
			e.preventDefault();
			let my_url = $(this).attr("href");
			let my_id = $(this).data("id");
			let my_target = $(this).data('parent');
			let form_data = {
				id: my_id,
				ajax: 1,
			};
			let question = confirm("Are you sure you want to delete this? This cannot be undone!");
			if (question) {
				$.ajax({
					url: my_url,
					type: "post",
					data: form_data,
					success: function (data) {
						$('#' + my_target).html(data);
						console.log(data);
					},
					failure: function (data) {
						console.log(data);
					}

				})
			}
		});

		$(".edit.ajax.inline").on('click', function (e) {
			e.preventDefault();
			let me = $(this);
			let my_callback = me.attr('href');
			let my_value = me.data("value");
			let my_id = me.data("id");
			let my_name = me.data("field_name");
			let my_user = me.data("user_id");
			let my_target =  me.data("parent");
			let form_data = {
				id: my_id,
				user_id: my_user,
				ajax: 1,
				field_name: my_name,
				value: my_value,
			};
			$.ajax({
				url: my_callback,
				type: "post",
				data: form_data,
				success: function (data) {
					$(my_target).html(data);
					me.removeClass("edit").addClass("update");
				},
				failure: function (data) {
					console.log(data);
				}
			});

		});
		$(document).on("change", ".ajax.inline select", function (e) {
			let me = $(this);
			let my_id = me.data("id");
			let my_value = me.val();
			let my_name = me.data("name");
			let form_data = {
				id: my_id,
				ajax: 1,
				field_name: my_name,
				value: my_value
			};
			$.ajax({
				url: '/transaction/update_value',
				type: "post",
				data: form_data,
				success: function (data) {
					//my_parent.html(data.my_value);
				},
				failure: function(data){
					console.log(data);
				}
			})

		});
		$(document).on("change", ".ajax.inline input", function (e) {
			let me = $(this);
			let my_value = me.val();
			let my_id = me.data("id");
			let my_name = me.data("name");
			let form_data = {
				id: my_id,
				ajax: 1,
				field_name: my_name,
				value: my_value
			};
			$.ajax({
				url: '/transaction/update_value',
				type: "post",
				data: form_data,
				success: function (data) {
					me.animate({
						color: "green"
					}, 1500);
				},
				failure: function(data){
					console.log(data);
				}
			})

		});
		$('.batch-update').on('click', function(e){
			e.preventDefault();
			let uri_callback = $(this).data('uri');
			console.log(uri_callback);

			let data = [];
			 $('.transaction').each(function(e){
				data.push($(this).data('id'));
			});
			console.log(data);

			form_data = {
				ajax: 1,
				transaction_ids: data,
				return_path: uri_callback
			};

			window_width = $(window).width();
			$.ajax({
				type: "post",
				data: form_data,
				url: $(this).attr('href'),
				success: function (data) {
					$("#popup").html(data);
					$("#my_dialog").modal("show");
				}
			});
		});




		$('.edit_preference').on("mouseup", function (event) {
			var myUser = $('#user_id').val();
			var myType = this.id;
			var myValue = $('#' + this.id).val();
			var myTarget = "stat" + myType;
			$('#' + myTarget).html("").show();
			var myUrl = base_url + "index.php/preference/update/";
			var form_data = {
				user_id: myUser,
				type: myType,
				value: myValue,
				ajax: 1
			};
			$.ajax({
				url: myUrl,
				type: "POST",
				data: form_data,
				success: function (data) {
					$('#' + myTarget).html(data).fadeOut(3000);
				}
			});
		});


		$(".menu_item_edit").on("click", function () {
			myId = this.id.split("_")[1];
			myUrl = base_url + "index.php/menu/edit_item/" + myId;
			$.ajax({
				type: "GET",
				url: myUrl,
				success: function (data) {
					showPopup("Edit Menu Item", data, "auto");
				}
			});
		});


		$(".menu_item_add").on("click", function () {
			myUrl = base_url + "index.php/menu/create_item/";
			$.ajax({
				type: "GET",
				url: myUrl,
				success: function (data) {
					showPopup("Create Menu Item", data, "auto");
				}
			});
		});


		$("#browser_warning").on('click',
			function () {
				$(".notice").fadeOut();
			}
		);

		$(".new.dialog,.edit.dialog").on("click", function (e) {
			e.preventDefault();
			show_popup(this);

		});

		$("select").on("change", function () {
			let my_parent = $(this).parents(".select-block");
			if ($(this).val() == "other") {
				let my_name = $(this).attr("name");
				my_parent.html("<input type='text' size='15' name='" + my_name + "'  id='" + my_name + "' value=''/>");
				my_parent.children("input#" + my_name).focus();
			}

		});
	}//end document function
);//end ready


function showPopup(myTitle, data, popupWidth, x, y) {
	if (!popupWidth) {
		popupWidth = 300;
	}
	var myDialog = $('<div id="popup">').html(data).dialog({
		autoOpen: false,
		title: myTitle,
		modal: true,
		width: popupWidth
	});

	if (x) {
		myDialog.dialog({position: x});
	}


	myDialog.fadeIn().dialog('open', {width: popupWidth});

	return false;
}

function showHelp(myTopic, mySubtopic) {
	$.get('ajax.switch.php', {target: "help", helpTopic: myTopic, helpSubtopic: mySubtopic},
		function (data) {
			var title = "Help with " + myTopic + ": " + mySubtopic;
			showNewPopup(title, data, "25%");
		}//end function(data)
	);//end get

}

function toggle_navigation(me, toggle) {
	if (toggle == "show") {
		$("#navigation").fadeIn();
		$(me).removeClass("show-navigation");
		$(me).addClass("hide-navigation");
		$(me).html("Hide Navigation");
	} else if (toggle == "hide") {
		$("#navigation").fadeOut();
		$(me).removeClass("hide-navigation");
		$(me).addClass("show-navigation");
		$(me).html("Show Navigation");
	}
}

function show_popup(me) {
	target = $(me).attr("href");
	form_data = {
		ajax: 1
	};

	window_width = $(window).width();
	$.ajax({
		type: "get",
		data: form_data,
		url: target,
		success: function (data) {
			console.log(data);
			console.log(target);
			$("#popup").html(data);
			$("#my_dialog").modal("show");
		}
	});
}


function delete_entity(me) {
	target = $(me).attr("href");
	my_id = me.id.split("_")[1];
	my_parent = $(me).parents(".row").attr("id");

	question = confirm("Are you sure you want to delete this? This cannot be undone!");
	if (question) {

		form_data = {
			ajax: 1,
			id: my_id
		}
		$.ajax({
			type: "post",
			data: form_data,
			url: target,
			success: function (data) {
				if ($(me).hasClass("inline")) {
					$("#" + my_parent).remove();
				} else if ($(me).hasClass("redirect")) {
					window.location.href = data;
				} else {
					$("#popup").html(data);
					$("#my_dialog").modal("show");
				}
			},
			error: function (data) {
				console.log(data);
			}
		});
	}
}
