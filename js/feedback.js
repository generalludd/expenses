$(document).ready(function(){
	$(".send_feedback").on('click',function(){
		var mySubject = $('#subject').val();
		var myRank = $('#rank').val();
		var myFeedback = $('#feedback').val();
		var myUrl = base_url + "index.php/feedback/add";
		var form_data = {
				subject: mySubject,
				rank: myRank,
				feedback: myFeedback
		};
		$.ajax({
			type: "get",
			url: myUrl,
			data: form_data,
			success: function(reply){
				$("#feedback-div").html(reply);
				
			}
		});
		
		
	});
	
	$(".create_feedback").on('click',function(data){
		var myUrl = base_url + "index.php/feedback/create";
		var myLocation = document.location;
		var myPath = myLocation.toString().split(base_url + "index.php/");
		form_data = {
				path: myPath[1]
		};
		
		$.ajax({
			type: "get",
			url: myUrl,
			data: form_data,
			success: function(reply){
				showPopup('Create Feedback', reply, 'auto');
			}
		});
		
	});

			

});