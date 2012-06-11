$("document").ready(function(){

$(function() {
		$( "#all, #class" ).sortable({
			connectWith: ".connectedSortable",
			receive: function(event, ui) {
				if (this.id == "class") {
					data="class_id="+class_id,
					$("ul#class li").each(function(){
						data = data+"&"+this.id+"="+$(this).index();
					});
					$.ajax({
						type: "POST",
						url: "actions/newList.php",
						data: data,
						success: function(phpfile){
							$("#saved").html(phpfile);
						}
					});
				}
				else {
					toRemove = $(ui.item).attr('id');
					data = "class_id="+class_id+"&"+toRemove+"=x";
					$.ajax({
						type: "POST",
						url: "actions/remove-story.php",
						data: data,
						success: function(phpfile){
							$("saved").html(phpfile);
						}
					});
				
				}
			
			}
		}).disableSelection();
	});


	$(".close-icon, #fadebackground").live("click", function(){close();});	
	$("#save-new-code").click(function(){
		newCode = $("#enroll-code").val();
		$.ajax({
			type: "POST",
			url: "actions/save-new-code.php",
			data: "newCode="+newCode+"&class_id="+class_id,
			success: function(phpfile){
				$("#saved").html(phpfile);
			}
		});
	});
	$('.removeStory').click(function(){
		var answer = confirm("Are you sure you want to remove this story from your class?");
		if (answer) {
		story_id = this.id.substr(6);
		$.ajax({
			type: "POST",
			url: "actions/remove-story.php",
			data: "story_id="+story_id+"&class_id="+class_id,
			success: function(phpfile){
				$("#saved").html(phpfile);
			}
		});
		}
	});
	
	$("#add-story").click(function(){
		addStory();
	
	});
	
});

function addStory(w, h) {
	open(400,400);
	$("#popup-content").load("ajax/add-story.php");



}

var showData = function(){
	open(800,600);
	story = this.id;
	$("#popup-content").load("ajax/worksheet-data.php?story="+story);
}

function open(width, height) {
	$("popup").css({
		"width" : "200",
		"height" : height
	});
	$("#popup, #fadebackground").fadeIn();
}

function close(){
	$("#popup-content").html("");
	$("#popup, #fadebackground").fadeOut();
}