$(document).ready(function(){
	
	$(".user-edit").on("click",function(){
		var myUrl = base_url + "index.php/user/edit";
		var form_data = {
				ajax: 1,
				id: this.id.split("_")[1]
		};
		
		$.ajax({
			type: "get",
			url: myUrl,
			data: form_data,
			success: function(data){
			showPopup("Edit User",data,"auto");
		}
			
		}); //end ajax
	});//end user-edit
	
	$(".user-create").on("click",function(){
		var myUrl = base_url + "index.php/user/create";
		var form_data = {
				ajax: 1,
		};
		
		$.ajax({
			type: "get",
			url: myUrl,
			data: form_data,
			success: function(data){
			showPopup("Add User",data,"auto");
		}
			
		}); //end ajax
	});//end user-edit
	
})