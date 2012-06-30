var definitionShow = "off";

function line(parent, child, relation_id) { //draws lines
	
	if ($("#"+child).length && $("#"+parent).length && $("#"+parent).hasClass("inactive") == false) {
	var parentPos = $("#"+parent).offset();
	var childPos = $("#"+child).offset();
		
	var theight = childPos.top - parentPos.top;
	
	twidth = parentPos.left - childPos.left;
	height = theight*theight + twidth*twidth;
	
	myheight = Math.sqrt(height);
	myheight = Math.round(myheight);
	
	angle = Math.asin(theight/myheight);
	angle = angle*180/Math.PI;
	
	if (childPos.left>parentPos.left) {angle = angle-90;} else {angle= Math.abs(angle-90);}
	half = myheight/2;
	
	h = Math.cos(angle*Math.PI/180)*half;
	
	newtop = parentPos.top-half+h+25-38;
	left = childPos.left+((parentPos.left-childPos.left)/2)+100;
	
	
	$("#line"+relation_id).css({
		"height" : myheight,
		"top" : newtop,
		"left" : left,
		"-webkit-transform" : "rotate("+angle+"deg)", 
		"-moz-transform" :  "rotate("+angle+"deg)",
		"-ms-transform" : "rotate("+angle+"deg)"
	});
	
	$("#arrow"+relation_id).css({"top": half});
	
	if ($("#"+child).hasClass("inactive")) {
		$("#line"+relation_id).css({"background-color": "#cccccc", "z-index" : 1});
		$("#line"+relation_id+" .arrow").css({"background-image": "url(../img/arrowg.png)" });
	}
}
else {$("#line"+relation_id).hide();}
}

function main() {
	$.ajax({
		type: "POST",
		url: "ajax/worksheetEm.php",
/* 		data: "user="+user+"&page="+page, */
		success: function(phpfile) {
			$(".worksheet").html(phpfile);
		}
	
	
	});

	$("#footer li img, #footer li p").css("opacity",".5");
	$("#page2").fadeOut();
	$("#page1").fadeIn();
	status = 0;
	$("#story img, #story p").css("opacity","1"); //makes story bright
	$("#edit").attr("href", "../admin/page/page.php");

}

function close() {
	$("#fadebackground, .popup, #user").fadeOut();
	definitionShow = "off";
}

function update_answer (user, name, value, story){
	$.ajax({
   		type: "GET",
   		url: "actions/update_answer.php",
   		data: "user="+user+"&name="+name+"&value="+value+"&story="+story,
   		success: function(phpfile){
   			$("#update").html(phpfile);
   			//console.log("function running");
		} //end anonymous function
	}); //end ajax call
}

function definition (term)
{		
	word = $(term).html();
$.ajax({
		
   		type: "GET",
   		url: "actions/get_definition.php",
   		data: "term="+word,
   		success: function(phpfile){
   			var p = $(term);
			var position = p.offset();
			width = $(term).width();
			if (position.top > 300) {var top = position.top-220;} else {var top = position.top+40;}
			if (position.left > 800) {var left = position.left+width-200;} else {var left = position.left;}
			
			$("#definition").animate({"top" : top,"left" :left});

			$("#definition-content").html(phpfile);
			$("#definition").fadeIn();
			$("#definition").draggable();
			definitionShow = "on";
		} //end anonymous function
	}); //end ajax call	
}

function worksheet_announce(n) {
	/* n.stopImmediatePropagation(); */
	$("body").append("<audio autoplay='true'><source src='creaky_door.wav' type='audio/wav' />Your browser does not support the audio element.</audio>");
	$("#worksheet_announce_window").slideToggle().delay(1000).fadeOut(5000);
}

function google_analytics() {
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-23109189-1']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
}

function showPageInstructions() {

	$(".page-instructions").toggle();
	if ($(".page-instructions:visible").length !=0) {instructionsShowing = true; $("#instructionsToggle").removeClass('notShowingInstructions').addClass('showingInstructions');}
	else {instructionsShowing = false;$("#instructionsToggle").removeClass('showingInstructions').addClass('notShowingInstructions');}
	$.ajax({
		type: 	"POST",
		url:	"actions/instructionsShowing.php",
		data:	"instructionsShowing="+instructionsShowing,
		success:function(phpfile){
			$("#update").html(phpfile);
		}
	});
			
}

function navigate(target) {
	if (target == "") {return;}
	if (target == "map") {$("#page2").css({"margin-left":0, "left":0,"width":"auto"});}
			else {$("#page2").css({"margin-left":"-350px", "left":"50%", "width": "700px"});}
		
		$("#footer li img, #footer li p").css("opacity","0.5");
		
		if ($("#page1:visible").length !== 0) { // if page 1 is visible
			$("#"+target+" img, #"+target+" p").css("opacity","1");
			$("#page1").fadeOut("slow");
			$("#page2").fadeIn("slow");
			$("#page2").load("ajax/"+target+".php", function(){if(instructionsShowing == false) {$(".page-instructions").hide();}});
			status = target;
			$("#edit").attr("href", "../admin/"+target+"/index.php");
		}
		else { // if the page is not visible
			if (target=="story") {main();return;}
			$("#"+target+" img, #"+target+" p").css("opacity","1");
			$("#page2").html(" ");
/* 			$("#page2").hide("fast",function(){$("#page2").show();}); */
			$("#page2").load("ajax/"+target+".php", function(){if(instructionsShowing == false) {$(".page-instructions").hide();}});
			status = target;
			$("#edit").attr("href", "../admin/"+target+"/index.php");

		}
}

function toggleHelp() {
$("#help").toggle();
				if ($("#help:visible").length !==0) {
					$("li.core p, li img").css({"opacity" : "1", "color" : "orange"});
					$("li.adminLink p").css({"opacity" : "1", "color" : "#66ffff"});
					$("li.finished p").css({"opacity" : "1", "color" : "green"});
					pos = $("#footer ul").position();
					$("#help-footer").css({"left" : pos.left});
					
					
				}
				else {
					$("li p, li img").css({"opacity" : "0.6", "color" : "white"});

				}


}

function formatGlossary(){
	$("table.glossary td").each(function(){
		$(this).children('p').first().css("margin-top","0px");
	});
	$("table.glossary tr:even").css("background-color", "#e8e8e8");
	$("table.glossary tr:odd").css("background-color", "#ffffff");


}

$(document).ready(function(){
	/* Removed for IE */ 
	//Scroller('viewport');
	google_analytics();
	$("a.tracker").click(function(){
		_gaq.push(['_trackEvent', 'Navigation link', this.id, this.id+' navigation link was clicked']);
	});
	$("#page1").show();
	//$(".page-instructions").live("mouseover", function(){ $(this).draggable().resizable();}); //Didn't seem to be working anyway
	$("#story img, #story p").css("opacity","1"); //makes story bright at the beginning
	$("#edit").css("left",$("#page1").offset().left-61);
	//footer event listner
	$("#footer li.core").click(function(){
		$("textarea, :input").blur();
		_gaq.push(['_trackEvent', 'Footer', this.id, this.id+' in the footer was clicked.']);
		if (status !== this.id && this.id !="story") {navigate(this.id);}
		else {main();}
	});

	
	/*  key listener */
	
	
	$('html').keyup(function(event) {
		if (event.target.nodeName == "TEXTAREA" || event.target.nodeName == "INPUT") {return false;}
		event.preventDefault();
		key = event.keyCode;
		switch (key) {
			case 27: //escape key
				$("textarea, :input").blur();
				if($("#greeting").height()>50) {toggleGreeting();break;}
				if($("#help:visible").length !==0) {toggleHelp();break;}
				if($("#fadebackground:visible").length !==0){close();} // if a popup is up, this closes it
					else { // if not then it escapes the navigation
						if ($("#page1:visible").length !==0) {return;}
						else {main();}
					}
				break;
			case 191:
				toggleHelp();
				
				break;
			case 72: //h key
				window.location="../dashboard/index.php";
				break;
			case 83: // s key
				main();
				break;
			case 71: //g key
				navigate("glossary");
				break;
			case 65: //a key
				navigate("appendices");
				break;
			case 68: // d key
				navigate("discuss");
				break;
			case 87: //w key
				navigate("worksheet");
				break;
			case 77: //m key
				navigate("map");
				break;	
			case 73: // i key
				showPageInstructions();
				break;
			case 69: // e key
				if (author) {
					window.location = "../admin/page/page.php?page_id="+page+"&story="+story;
				}
				break;
			case 86:
				if (author) {
					window.location = "../admin/index.php?story="+story;
				}
				break;
			case 67: // c key
				if (author) {
					var answer = confirm("Are you sure you want to clear your progress data?");
					if (answer) {
						$.ajax({
							url: "actions/progressClear.php",
							success: function(phpfile){$("#update").html(phpfile);location.reload(true);}
						});
					}
				}
				break;
			case 88: //x key
				if (author) {
					var answer = confirm("Are you sure you want to clear your worksheet data?");
					if (answer) {
						$.ajax({
							url: "actions/worksheetClear.php",
							success: function(phpfile){$("#update").html(phpfile);location.reload(true);}
						});
					}
				}
				break;
			case 90: //z key
				if (author) {
					var answer = confirm("Are you sure you want to clear your quiz data?");
					if (answer) {
						$.ajax({
							url: "actions/quizClear.php",
							success: function(phpfile){$("#update").html(phpfile);location.reload(true);}
						});
					}
				}
				break;
		}
	
	
	});//escape key event listener
	
	$("#instructionsToggle").click(function(){showPageInstructions();});
		
	$("#fadebackground,.close-icon").click(function(){close();}); //close event listener
	$("#mainMenu").click(function(){window.location="../dashboard/index.php";});//main menu event listener
	$("#logout").click(function(){window.location="../logout.php";});//logout event listener
	
	$(".submit").live("click", function(){
		alert("Your Worksheet answers have been recorded and submitted.");
	
	});
		
	$(".keyterm").click(function(){
		
		definition(this);
	});
	
	$("#helpToggle").click(function(){toggleHelp();});
	
	
	$('#ajax').hide().ajaxStart(function() {$(this).css({"opacity": "0.7"}).fadeIn();}).ajaxStop(function() {$(this).fadeOut();});
	

	$(":input, textarea").live('change', function(){
		update_answer(user,this.name,this.value,story);
	});
	
	
	$(".casestudy").append("<div class='casestudy-title'>case study</div>");
	$(".example").append("<div class='example-title'>example</div>");
	$(".review").append("<div class='review-title'>review</div>");
	$(".thoughtprovokingquestion").append("<div class='thoughtprovokingquestion-title'>think about it</div>");
	$(".thoughtprovokingquestion").append("<div class='question2-img'><img src='../img/question2.jpg' /></div>");
	$(".tip").append("<div class='tip-title'>tip</div>");
	$(".keytakeaway").append("<div class='keytakeaway-title'><img src='../img/key.jpg' /></div>");
	$(".essentialquestion").append("<div class='essentialquestion-title'><img src='../img/question1.jpg' /></div>");
	$(".trythis").append("<div class='trythis-title'>try this</div>");




});




	
