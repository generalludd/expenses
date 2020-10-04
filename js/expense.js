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

	
	
	
})
