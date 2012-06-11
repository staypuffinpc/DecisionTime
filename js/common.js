$("document").ready(function(){

	$("#greeting span.name").click(function(e){e.stopImmediatePropagation();toggleGreeting();});
});	
	
function toggleGreeting() {
	h=$("#greeting").height();
	if (h<50)
	
	{
		$("#greeting").css({
			"outline" : "1px solid black",
			"height" : "80px",
			"background-color" : "white",
			"color" : "black",
			"text-decoration" : "none"	
		}).mouseover(function() {
			$(this).css({"background-color" : "white"});
		}).mouseout(function(){$(this).css({"background-color" : "white"});});
	}
	else
	{
		$("#greeting").css({
			"outline" : "0px",
			"height" : "39px",
			"background-color" : "transparent",
			"color" : "white",
			"text-decoration" : "underline"
		}).mouseover(function() {
			$(this).css({"background-color" : "rgba(255,255,255,0.2)"});
		}).mouseout(function(){$(this).css({"background-color" : "transparent"});});
	
	}
	
}

	



