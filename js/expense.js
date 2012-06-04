$(document).ready(function(){
	
	$("#search-month, #search-year").live("change",function(){
		var form_data = {
				ajax: 1
		};
		var myMonth = $("#search-month").val();
		var myYear = $("#search-year").val();
		var myUrl = base_url + "index.php/expense/show_all/" + myMonth + "/" + myYear;
		
		$.ajax({
			type: "get",
			url: myUrl,
			data: form_data,
			success: function(data){
			$("#content").html(data);
		}
		});
	});
	
	
	
	
	
	$("#type").live("change",function(){
		if ($("#type").val() == "other") {
			$("#type_span").html("<input type='text' size='15' name='type' id='type' value=''/>");
			$("#type").focus();
		}
		
	});
	
	$("#type").live("blur",function(){
		
		if($("#type").val() == "other" ) {
			$("#type_span").html("<input type='text' size='15' name='type' id='type' value=''/>");
		}
			
	})
	
	
	$(".expense-edit").live("click",function(){
		var myExpense = this.id.split("_")[1];
		var myUrl = base_url + "index.php/expense/edit/" + myExpense;
		$.ajax({
			type:"get",
			url: myUrl,
			success: function(data){
			showPopup("Editing Expense",data,"auto");
		}
		});
	});
	
	
	$(".expense-create").live("click",function(){
		var myUrl = base_url + "index.php/expense/create/";
		var form_data = {
			user_id: this.id.split("_")[1]
		};
		$.ajax({
			type:"get",
			url: myUrl,
			data: form_data,
			success: function(data){
			showPopup("Adding A Expense", data, "auto");
		}
			
		});
	})
	
	
	$(".expense-delete").live("click", function(){
		var action = confirm("Are you sure you want to delete this? It cannot be undone!");
		if(action) {
			$("#action").val("delete");
			$("#expense_editor").submit();
		}
		
	});
	
	
	
})