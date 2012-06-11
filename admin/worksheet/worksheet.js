

$(document).ready(function() {
$("#item-list").load("ajax/worksheetList.php");
var data = "action=sorting";		

$("#item-list").sortable({
	start: function(event, ui){$(".ui-state-highlight").css("height", $(ui.helper).height());},
	helper: "clone",
	opacity: 0.4,
	revert: true,
	placeholder: 'ui-state-highlight',
	stop: function() {
		updateOrder();
	}
});



$(".type, .textShort").live("click", function(){
	$(this).next().slideToggle().next().slideToggle().next().slideToggle().next().slideToggle().next().slideToggle().next().slideToggle().next().slideToggle();

});

$(".ce").live("focus", function(){$("#item-list").sortable({"disabled": true});});
$(".ce").live("mouseover", function(){$("#item-list").sortable({"disabled": true});});
$(".ce").live("mouseout", function(){$("#item-list").sortable({"disabled": false});});

$(".ce").live("blur", function(){
	$("#item-list").sortable({"disabled": false});
	item = this;
	text = $(this).html();
	info=$(this).attr("class").split(" ");
	if (info[1] == "response") {text = $(this).parent().html();//console.log(text);}
	$.ajax({
		type: "POST",
		url: "actions/updateItem.php",
		data: "text="+text+"&field="+info[1]+"&id="+info[2],
		success: function(phpfile) {
			$("#update").html(phpfile);
			if (info[1] == "text") {
				if (text.length > 88) {
				text = text.substr(0, 87)+" . . . ";
				}
				$(item).parent().prev().text(" - "+text);
			}
		}
	});
});

$("select").live("change", function(){
	id = $(this).attr('class');
	page = $(this).val();
	$.ajax({
		type: "POST",
		url: "actions/updatePage.php",
		data: "id="+id+"&page="+page,
		success: function(phpfile) {
			$("#update").html(phpfile);
		
		}
		
	
	});
});

$("input[type=checkbox]").live("change", function(){
	id = $(this).attr("class");
	if ($(this).attr("checked") == "checked") {
		embedded = 1;
		$(this).parent().parent().prev().prev().prev().prev().prev().prev().html("embedded").css({"padding": "1px", "display": "none"});
	} 
	else {
	embedded = 0;
			$(this).parent().parent().prev().prev().prev().prev().prev().prev().html("").css({"padding": "0px", "display": "none"});

	}
	
	$.ajax({
		type: "POST",
		url: "actions/updateEmbedded.php",
		data: "embedded="+embedded+"&id="+id,
		success: function(phpfile) {
			$("#update").html(phpfile);
		}
	});
});	

$(".ce").live("keypress", function(e){
		if ($(this).hasClass('answer')) {return;}
		if (e.keyCode == "13") {
			e.preventDefault();
			$(this).blur();
			$("#item-list").sortable({"disabled": false});
		}
});
$(".ce").live("keyup", function(e){
	if (e.keyCode == '27') {$(this).blur();}
});

$(".newItem").live("click", function(){
	type = this.id;
	embedded = "0";
	page = "0"
	$.ajax({
		type: "POST",
		url: "actions/newItem.php",
		data: "type="+type+"&embedded="+embedded,
		success: function(phpfile) {
			$("#update").html(phpfile);
		}
	});
});

$(".delete").live("click", function(){
	var item=this;
	var answer = confirm("This action cannot be undone.Are you sure you want to delete this item? ")
	if(answer){
	worksheet_id = this.id.substr(6);
	$(this).parent().remove();
	$.ajax({
		type: "POST",
		url: "actions/delete_item.php",
		data: "worksheet_id="+worksheet_id,
		success: function(phpfile){
			$("#update").html(phpfile);
			updateOrder();
			
		}
	});
	}
});
$("html").keyup(function(e){
	if (e.keyCode == '112') {$("#update").toggle();}
	
});

$(".addItem").live("click" , function(){
	value = $(this).prev().prev().children("input:last").val();
	value = (1*value)+1;
	info = $(this).attr("class").split(" ");
	$(this).prev().prev().append("<input type=\"radio\" name=\""+info[1]+"\" value=\""+value+"\"><div class=\"ce response "+info[1]+"\" contenteditable=\"true\">new Choice</div><br>").focus();
});

$(".removeItem").live("click" , function() {
	$(this).prev().prev().prev().children("input:last, br:last, div:last").remove();
	/* $(this).prev().prev().prev().children("div:last").remove(); */

});


/* ------------------------------handlers--------------------------- */
var logoutFromMenu = function(){window.location="../../logout.php";};


$("#ajax").ajaxStart(function (){$(this).show();}).ajaxStop(function () {$(this).hide();});


$("#update").draggable();

function updateOrder() {
//console.log("updating order");
		$("ul#item-list li").each(function(){
			data = data+"&"+this.id+"="+$(this).index();
				
		});
		$('li > div.number').each(function(i) {
			var $this = $(this); 
   			$this.text(i+1+". ");
		});

		$.ajax({
			type: "POST",
			url: "actions/update_order.php",
			data: data,
			success: function(phpfile){
			$("#update").append(phpfile);}
		});	
}




$("#logoutFromMenu").click(logoutFromMenu);



}); 