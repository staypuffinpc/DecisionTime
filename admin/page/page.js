$(document).ready(function() {

/* worksheet listeners */
$("#item-list").sortable({
	start: function(event, ui){$(".ui-state-highlight").css("height", $(ui.helper).height());},
	helper: "clone",
	opacity: 0.4,
	placeholder: 'ui-state-highlight',
	stop: function() {
		updateOrder();
	}
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
		url: "../worksheet/actions/updateItem.php",
		data: "text="+text+"&field="+info[1]+"&id="+info[2],
		success: function(phpfile) {
			$("#update").html(phpfile);
		}
	});
});

$("select").live("change", function(){
	id = $(this).attr('class');
	page = $(this).val();
	$.ajax({
		type: "POST",
		url: "../worksheet/actions/updatePage.php",
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
	} 
	else {
	embedded = 0;

	}
	
	$.ajax({
		type: "POST",
		url: "../worksheet/actions/updateEmbedded.php",
		data: "embedded="+embedded+"&id="+id,
		success: function(phpfile) {
			$("#update").html(phpfile);
		}
	});
});	

$(".ce").live("keypress", function(e){
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
	embedded = '1';
	$.ajax({
		type: "POST",
		url: "../worksheet/actions/newItem.php",
		data: "type="+type+"&embedded="+embedded,
		success: function(phpfile) {
			$("#update").html(phpfile);
			$("ul#item-list").load("../page/ajax/worksheetList.php");
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
		url: "../worksheet/actions/delete_item.php",
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

/* end of worksheet listeners. */

	/*
height = $("#hiddenDiv").height();
	$("textarea#content").css({"height":height});
*/
	$("#menu").draggable();
	$("#menuToggle").toggle(function() {$("#menu").fadeIn();$(this).html("Hide Menu");}, function() {$("#menu").fadeOut();$(this).html("Show Menu");});
	$("#borrowToggle").toggle(
		function(){
			$(this).html("Hide Content Borrower");
			xinha_editors.content.sizeEditor(window.innerWidth/2-210); 
			xinha_editors.references.sizeEditor(window.innerWidth/2-210); 

			$("#page1").css({"width" : "50%", "margin-left" : 0, "left" : 0});
			$("#borrowedContentPane").show();
		},
		function(){
			$(this).html("View Content Borrower");
			xinha_editors.content.sizeEditor(694); 
			xinha_editors.references.sizeEditor(694); 
			$("#page1").animate({"width" : "904", "margin-left" : "-452px", "left" : "50%"});
			$("#borrowedContentPane").hide();
		}
	
	);
	$("#imageCreator").click(function(){
		popup(this.id, 1100, 600);	
	});
	
	
	
	$(".close-icon, #fadebackground").click(function(){close();});
	$("#navigation_choices").sortable({
		placeholder: 'ui-state-highlight',
		stop: function() {updateNavigationOrder();}
	});
	$("#addSubheading").click(function(){addSubheading();});
	$(".page_stem, .page_link, .page_punctuation").live("focus", function(){
		$("#navigation_choices").sortable({"disabled" : true});
	});
	
	$(".page_stem, .page_link, .page_punctuation").live("mouseover", function(){
		$("#navigation_choices").sortable({"disabled" : true});
	});
	$(".page_stem, .page_link, .page_punctuation").live("mouseout", function(){
		$("#navigation_choices").sortable({"disabled" : false});
	});
	
	
	$(".page_stem, .page_link, .page_punctuation").attr("contenteditable", true);
	$(".page_stem, .page_link, .page_punctuation").keypress(function(e){
		if (e.keyCode == 13) {$(this).blur();}
	});
	
	$(".page_stem, .page_link, .page_punctuation").live("blur", function(){
		theclass = $(this).attr("class");
		theclassarray = theclass.split(" ");
		text = $(this).html();
		$("#navigation_choices").sortable({"disabled" : false});
	$.ajax({
			type: "POST",
			url: "actions/updateLinks.php",
			data: "id="+theclassarray[1]+"&text="+text+"&class="+theclassarray[0],
			success: function(phpfile) {
				$("#update").html(phpfile);
			}
		});
	});
	
	$(".deleteLink").live("click", function(){
		parent = this;
		var answer = confirm("This action cannot be undone. Are you sure you want to delete this link?");
		if (answer) {
			id = this.id.substr(6);
			$.ajax({
				type: "POST",
				url: "actions/deleteLink.php",
				data: "id="+id,
				success: function(phpfile) {
					$("#update").html(phpfile);
					$(parent).parent().remove();			
				}
			});
		}
	});
	
	


});

function addSubheading() {
	var text = prompt("Please enter Subheading text.");
	$.ajax({
		type: "POST",
		url: "actions/addSubheading.php",
		data: "text="+text,
		success: function(phpfile){
			$("#navigation_choices").append(phpfile);
		}
	});
}

function updateNavigationOrder() {
	data = "action=sorting";
	$("ul#navigation_choices li").each(function(){
		data = data+"&"+this.id+"="+$(this).index();
	});
	$.ajax({
		type: "POST",
		url: "actions/update_order.php",
		data: data,
		success: function(phpfile){
		$("#update").append(phpfile);}
	});	
}

function popup(id, width, height) {
	$("#popup").css({
		"width": width,
		"height": height,
		"left" : "50%",
		"top" : "50%",
		"margin-left" : -1*width/2,
		"margin-top" :-1*height/2
	});
	$.ajax({
		type: "POST",
		url: "ajax/"+id+".php",
		success: function(phpfile){
			$("#popup-content").html(phpfile);
			$("#popup, #fadebackground").fadeIn();
		}
	});
}

function close() {
	$("#popup, #fadebackground").fadeOut();
}

function update_page() { // loads php to update story
	
	$('form').submit();
	$.ajax({
		type: "POST",
			url: "actions/update_page.php",
			data: $('form').serialize(),
			success: function(phpfile){
			$("#update").html(phpfile);
			}
		});
}
function update_exit(left, top, page) { // loads php to update story
	update_page();
	setTimeout("window.location='../map/index.php?page="+page+"&left="+left+"&top="+top+"'",1000);

}

function view(page_id) { // loads php to update story
		$('form').submit();
	$.ajax({
		type: "POST",
			url: "actions/update_page.php",
			data: $('form').serialize(),
			success: function(phpfile){
			$("#update").html(phpfile);
			window.location='../../story/index.php?page_id='+page_id;

			}
		});

}

function updateOrder() {
i=0;
//console.log("updating order");
		$("ul#item-list li").each(function(){
			
			data = data+"&"+this.id+"="+itemOrder[i];
			i++;
			//console.log(data);	
		});
		j=0;
		$('li > div.number').each(function(i) {
			
			var $this = $(this); 
   			$this.text(itemOrder[j]+1+". ");j++;
		});

		$.ajax({
			type: "POST",
			url: "../worksheet/actions/update_order.php",
			data: data,
			success: function(phpfile){
			$("#update").append(phpfile);}
		});	
data = "";
}
