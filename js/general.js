﻿$(document).ready(function(){
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
		myDialog.dialog({position:x})
	}


	myDialog.fadeIn().dialog('open',{width: popupWidth});

	return false;
}

function showHelp(myTopic,mySubtopic){
	$.get('ajax.switch.php',{target:"help",helpTopic:myTopic,helpSubtopic:mySubtopic},
			function(data){
				var title="Help with "+ myTopic + ": "+ mySubtopic
				showNewPopup(title, data, "25%");
	}//end function(data)
);//end get
	
}

function showSidebar(title,data,containerWidth,contentWidth,sidebarWidth){
	var sidebarLeft=parseInt(contentWidth)+2+"%";
	//$('#title').html(title);
	$('#content').animate( {
		width : '65%'
	}, 'fast');
	var narrTextWidth = $("#narrText_ifr").width();
	var contentWidth = $("#content").width();
	var percent = narrTextWidth / contentWidth
	if(percent > .7) {
		$("#narrText_ifr").css({width: '70%'});
	}
	$('#sidebar').css({height:'95%'});
	$('#sidebar').html(data);
	$('#sidebar').animate({width:sidebarWidth,left:sidebarLeft},'normal').fadeIn();
}

function closeSidebar(){
	var myWidth=$('#popupSidebar').width();
	$('#popupSidebar').fadeOut();
	var mainWidth=$('#popupContainer').width();
	$('#popupContent').animate({width:'95%'},'normal');
	$('#popupContainer').animate({width:mainWidth-myWidth},'normal');
}
/*
    @function getYear
    @params myTerm string
    @params myGrade string
    @dependencies NARRATIVE_EDIT_INC
   description:  parses the year from the information supplied and determines the student's current grade. 
*/
function getYear(myTerm,myGrade){
	var termName=myTerm.replace(/ [0-9]{4}/gi,"");
	
	var myYear=myTerm.replace(/Mid-Year |Year-End /gi, "")	
	myYear=parseInt(myYear);
	if(termName=="Year-End"){
		myYear=myYear-1;
	}
	var now=new Date;
	now=now.getFullYear();
	var diff=parseInt(now)-myYear;
	var reportGrade=parseInt(myGrade)-diff;
	if(reportGrade==0){reportGrade="K"}
	$('#stuGrade').val(reportGrade);
	//document.getElementById('stuGrade').value=reportGrade;
}
