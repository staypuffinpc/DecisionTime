$(document).ready(function(){
	updateList();
	$("#ajax").ajaxStart(function (){$(this).show();}).ajaxStop(function () {$(this).hide();});

	$(".newItem").click(function(){
		info = $(this).attr("class").split(" ");
		$.ajax({
			type: "POST",
			data: "type="+info[0],
			url: "actions/newItem.php",
			success:function(phpfile) {
				$("#update").html(phpfile);
				updateList();
			}
		});
	});

	$("html").keyup(function(e){
		if (e.keyCode == '112') {$("#update").toggle();}
	});

	$(".ce").live("blur", function(){
		data = $(this).attr("class").split(" ");
		text = $(this).text();
		$.ajax({
			type: "POST",
			url: "actions/updateItem.php",
			data: "field="+data[1]+"&text="+text+"&item_id="+data[2],
			success: function(phpfile) {
				$("#update").html(phpfile);
			}
		});
	});
	
	$("select").live("change", function(){
		//console.log("select");
		text = $(this).val();
		//console.log(text);
		data = $(this).attr("class").split(" ");
		$.ajax({
			type: "POST",
			url: "actions/updateItem.php",
			data: "field="+data[1]+"&text="+text+"&item_id="+data[2],
			success: function(phpfile) {
				$("#update").html(phpfile);
			}
		});
	
	});
	
	$(".delete").live("click", function(){
		var answer = confirm("This action cannot be undone. Are you sure you want to delete this item? ")
		if (answer){
		
		data = $(this).attr("class").split(" ");
		$.ajax({
			type: "POST",
			url: "actions/deleteItem.php",
			data: "item_id="+data[1],
			success: function(phpfile) {
				$("#update").html(phpfile);
			updateList();
			}
		});
		}
	});

	$("input:radio").live("click", function(){
		item_id = $(this).attr("name");
		value = $(this).val();
		$.ajax({
			type: "POST",
			url:	"actions/updateAnswer.php",
			data:	"item_id="+item_id+"&value="+value,
			success:function(phpfile){
				$("#update").html(phpfile);
			}
		});
	});


	$(".deleteResponse").live("click", function(){
		var answer = confirm("This action cannot be undone. Are you sure you want to delete this item? ")
		if (answer){
		
		info = $(this).attr("class").split(" ");
		$.ajax({
			type: "POST",
			url:	"actions/deleteResponse.php",
			data:	"id="+info[1],
			success:function(phpfile){
				$("#update").html(phpfile);
				$("."+info[1]).prev().remove();
				$("."+info[1]).remove();
			}
		});
		}
	});


	$(".newResponse").live("click", function(){
		info = $(this).attr("class").split(" ");
		$.ajax({
			type: "POST",
			url:	"actions/newResponse.php",
			data:	"item_id="+info[1],
			success:function(phpfile){
				$("#update").html(phpfile);
			}
		});
	});


});

function updateList(){
	$.ajax({
		type: "POST",
		url: "ajax/itemList.php",
		success: function(phpfile) {
			$("#item-list").html(phpfile);
			$(".ce").attr("contenteditable", true);
		}
	});
}