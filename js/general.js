$(document).ready(function(){
//	$('#content').css({height:'500px'});
	
	$(".datefield").live("focus", function(){
		$(".datefield").datepicker();
	});
	
		
	 $("#sortable").sortable({
	      handle : '.handle',
	      update : function () {
		var order = $('#sortable').sortable('serialize');
			  alert(order);
	      }
    });
		$("table thead").addClass("theader");
//	$("table tr:nth-child(even)").addClass("striped");

	 
	$('.home').live('click',
		function(event){
			document.location="index.php";
		}//end function(event);
	);//end home.click
	

	
	

	$('.edit_preference').live("mouseup",  function(event){
		var myUser=$('#user_id').val();
		var myType=this.id;
		var myValue=$('#'+this.id).val();
		var myTarget="stat"+myType;
		$('#'+myTarget).html("").show();
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
			success: function(data){
				$('#'+myTarget).html(data).fadeOut(3000);
			}
		});
	});
	

	$(".menu_item_edit").live("click",function(){
		myId = this.id.split("_")[1];
		myUrl = base_url + "index.php/menu/edit_item/" + myId;
		$.ajax({
			type:"GET",
			url: myUrl,
			success:function(data){
				showPopup("Edit Menu Item",data,"auto");
			}
		});
	});
	

	$(".menu_item_add").live("click",function(){
		myUrl = base_url + "index.php/menu/create_item/";
		$.ajax({
			type:"GET",
			url: myUrl,
			success:function(data){
				showPopup("Create Menu Item",data,"auto");
			}
		});
	});

	
	$("#browser_warning").live('click',
		function(){
			$(".notice").fadeOut();
		}
	);
	
	}//end document function
);//end ready


function showPopup(myTitle,data,popupWidth,x,y){
	if(!popupWidth){
		popupWidth=300;
	}
	var myDialog=$('<div id="popup">').html(data).dialog({
		autoOpen:false,
		title: myTitle,
		modal: true,
		width: popupWidth
	});
	
	if(x) {
		myDialog.dialog({position:x});
	}


	myDialog.fadeIn().dialog('open',{width: popupWidth});

	return false;
}

function showHelp(myTopic,mySubtopic){
	$.get('ajax.switch.php',{target:"help",helpTopic:myTopic,helpSubtopic:mySubtopic},
			function(data){
				var title="Help with "+ myTopic + ": "+ mySubtopic;
				showNewPopup(title, data, "25%");
	}//end function(data)
);//end get
	
}


