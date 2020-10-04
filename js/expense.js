jQuery.noConflict();

jQuery(document).ready(function ($) {
	

	
	$(".select-month").on("click",function(){
		form_data= {
				ajax: "1"
		};
		$.ajax({
			type:"get",
			url: base_url + "index.php/expense/select",
		data: form_data,
		success: function(data){
			showPopup("Select Month", data, "auto");
		}
		});
	});

	
	$("#type").on("change",function(){
		if ($("#type").val() == "other") {
			$("#type_span").html("<input type='text' size='15' name='type' id='type' value=''/>");
			$("#type").focus();
		}
		
	});
	
	$("#type").on("blur",function(){
		
		if($("#type").val() == "other" ) {
			$("#type_span").html("<input type='text' size='15' name='type' id='type' value=''/>");
		}
			
	});

	
	
	
})
