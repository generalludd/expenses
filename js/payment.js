$(document).ready(function(){
	

	
	
	$(".payment-edit").on("click",function(){
		var myPayment = this.id.split("_")[1];
		var form_data = {
				id:myPayment
				};
		var myUrl = base_url + "index.php/payment/edit/";
		$.ajax({
			type:"get",
			data: form_data,
			url: myUrl,
			success: function(data){
			showPopup("Editing Payment",data,"auto");
		}
		});
	});
	
	
	$(".payment-create").on("click",function(){
		var myUrl = base_url + "index.php/payment/create/";
		var myArray = this.id.split("_");
		var myTotal = myArray[1];
		var myMo = myArray[2];
		var myYr = myArray[3];
		var myId = myArray[4];
		var form_data = {
			total_due: myTotal,
			mo: myMo,
			yr: myYr,
			user_id: myId,
			ajax: 1
		};
		
		$.ajax({
			type:"get",
			data: form_data,
			url: myUrl,
			success: function(data){
			showPopup("Adding A Payment", data, "auto");
		}
			
		});
	});
	
	
	
});