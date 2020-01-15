$(document).ready(function(){
	

	
	$(".select-month").on("click",function(){
		form_data= {
				ajax: "1"
		};
		$.ajax({
			type:"get",
			url: base_url + "index.php/expense/select_month",
		data: form_data,
		success: function(data){
			showPopup("Select Month", data, "auto");
		}
		});
	});
	
	$(".go-to-month").on("click",function(){
		var my_month = $("#search-month").val();
		var my_year = $("#search-year").val();
		window.location.href = base_url + "index.php/expense/show_all/" + my_month + "/" + my_year;
	});
	
	$(".show-current-month").on("click",function(){
		window.location.href = base_url + "index.php/expense/show_all";
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
