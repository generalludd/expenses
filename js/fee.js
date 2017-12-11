$(document).ready(function(){
	
	$("#type").on("change",function(){
		if ($("#type").val() == "other") {
			$("#type_span").html("<input type='text' size='15' name='type' id='type' value=''/>");
			$("#type").focus();
		}
		
	});
	
	
	$(".fee-edit").on("click",function(){
		var myFee = this.id.split("_")[1];
		var myUrl = base_url + "index.php/fee/edit/" + myFee;
		$.ajax({
			type:"get",
			url: myUrl,
			success: function(data){
			showPopup("Editing Fee",data,"auto");
		}
		});
	});
	
	
	$(".fee-create").on("click",function(){
		var myUrl = base_url + "index.php/fee/create/";
		$.ajax({
			type:"get",
			url: myUrl,
			success: function(data){
			showPopup("Adding A Fee", data, "auto");
		}
			
		});
	})
	
	
	
});