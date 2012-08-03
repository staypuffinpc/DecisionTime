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


	$(".close-icon, #fadebackground").live("click", function(){close();}); //launches close popup function
	$("a.delete-user").live("click", function(){delete_user(this.id);}); //launches delete user function	
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

	$("#footer li").click(function(){
		page = this.id;
		$(".management-window").hide();
		$("#"+page+"-info").show();
	});
	
	$("#add-member").click(function(){
		open(400,200);
		$("#popup-content").load("ajax/add-member.php");
		
	});
	
});

function Story(w, h) {
	open(400,400);
	$("#popup-content").load("ajax/add-story.php");



}

var showData = function(){
	open(800,600);
	story = this.id;
	$("#popup-content").load("ajax/worksheet-data.php?story="+story);
}

var delete_user = function(user_id){
	$("#ajax").show();
	var answer = confirm("Are you sure that you want to remove this person from the class?");
	if (answer) {
		$.ajax({
			type: "POST",
			url: "actions/delete-user.php",
			data: "user_id="+user_id,
			success: function(phpfile){
				$("#saved").html(phpfile);
				$("#member-list-info").load("ajax/member-list.php");
				$("#ajax").hide();
			}
		});
	}

	
}

function open(width, height) {
	$("#popup").css({
		"width": width,
		"height": height,
		"left" : "50%",
		"top" : "50%",
		"margin-left" : -1*width/2,
		"margin-top" :-1*height/2	});
	$("#popup, #fadebackground").fadeIn();
}

function close(){
	$("#popup-content").html("");
	$("#popup, #fadebackground").fadeOut();
}

