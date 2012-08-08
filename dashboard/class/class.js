$("document").ready(function(){
$("#story-manager-info").show();
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
	$("a.worksheet-data").live("click", function(){showData(this.id);});
	$("a.quiz-data").live("click", function(){showQuizData(this.id);});
	$("a.user-edit").live("click", function(){editUser(this.id);});
	$("a.clear-progress").live("click", function(){clearProgress(this);});
	$("a.clear-worksheet").live("click", function(){clearWorksheet(this);});
	$("a.clear-quiz").live("click", function(){clearQuiz(this);});

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

var showData = function(id){
	open(1000,500);
	story = id.substr(10);
	console.log(story);
	$("#popup-content").load("ajax/worksheet-data.php?story="+story);
}

var showQuizData = function(id){
	open(1000,500);
	story = id.substr(5);
	console.log(story);
	$("#popup-content").load("ajax/quiz-data.php?story="+story);
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

var editUser = function(user_id) {
	user_id = user_id.substr(5);
	open(1000, 500);
	$("#popup-content").load("ajax/user-edit.php?user_id="+user_id);
	
}

var clearProgress = function(test){
	story_id = test.id;
	user_id = $(test).attr("class").substr(26);
	answer = confirm("Are you sure you want to delete this student's progress?");
	if (answer)
	{
		$.ajax ({
			type: "POST",
			url: "actions/progressClear.php",
			data: "user_id="+user_id+"&story_id="+story_id,
			success: function(phpfile){
				$("#update").html(phpfile);
				console.log(phpfile);
			}
		});
	}
}

var clearWorksheet = function(test){
	story_id = test.id;
	user_id = $(test).attr("class").substr(27);
	answer = confirm("Are you sure you want to delete this student's worksheet answers?");
	if (answer)
	{
		$.ajax ({
			type: "POST",
			url: "actions/worksheetClear.php",
			data: "user_id="+user_id+"&story_id="+story_id,
			success: function(phpfile){
				$("#update").html(phpfile);
				console.log(phpfile);
			}
		});
	}
}

var clearQuiz = function(test){
	story_id = test.id;
	user_id = $(test).attr("class").substr(22);
	answer = confirm("Are you sure you want to delete this student's quiz data?");
	if (answer)
	{
		$.ajax ({
			type: "POST",
			url: "actions/quizClear.php",
			data: "user_id="+user_id+"&story_id="+story_id,
			success: function(phpfile){
				$("#update").html(phpfile);
				console.log(phpfile);
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

