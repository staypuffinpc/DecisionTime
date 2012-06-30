$(document).ready(function() {

var top;
var bottom;
var left;
var right;
var mouse_down = false;
var meta_down;
var multiple_drag;
var start_pos;
var startValue;

/* zoomValue(x); */

$("#zoom").slider({
	min: -5,
	max: 5,
	value: zoomValue(x),
	slide: function( event, ui ) {
		switch (ui.value) {
			case -5:x = .5; break;
			case -4:x = .6; break;
			case -3:x = .75; break;
			case -2:x = 1; break;
			case -1:x = 1.3; break;
			case 0:x = 1.5; break;
			case 1: x = 1.8; break;
			case 2: x = 2.0; break;
			case 3: x = 2.5; break;
			case 4: x = 3.0; break;
			case 5: x = 5.0; break;
		
		}		
				$( "span#factor" ).html( x );},
	stop: function(event, ui) {
		
		window.location="index.php?x=" + x;}
});

$( "span#factor" ).html(x);

/* ------------------------------handlers--------------------------- */
var togglePageClass = function(e) {
	$("#pageRightClick").hide();
/* 	unbindThemAll(); */
	var selectorKey = 0;
	if ($.client.os == "Mac") {selectorKey = e.metaKey;}
	if ($.client.os !== "Mac") {selectorKey = e.ctrlKey;}
	if (selectorKey) {
		e.stopImmediatePropagation();
		$(this).toggleClass("selected"); 
		$("#update").append("selected");
	}
/* 	bindThemAll(); */
};

var logoutFromMenu = function(){window.location="../logout.php";};

var editStory= function(){ 
	width = 400;
	height = 300;
	open(width, height);
	$("#popup-content").load("ajax/"+this.id+".php");
};

var permissions = function(e){
	width = 400;
	height = 400;
	open(width, height);
	$("#popup-content").load("ajax/"+this.id+".php");


};

var newPage = function(e){ 
	unbindThemAll();
	e.stopImmediatePropagation();
	$.ajax({
		type: "POST",
			url: "ajax/new_page.php",
			success: function(phpfile){
			$("#update").append(phpfile);
			}
		});	
	bindThemAll();
};

var keyboard = function(e) {if (e.keyCode == '27') //escape event listener
		{
		if($("#fadebackground:visible").length !==0)
			{close();} // if a popup is up, this closes it
		}
		if (e.keyCode == '112') {//console.log("update");$("#update").toggle();}
}};

var selectorStart = function(e){
	//console.log("selector-start");
	$("#pageRightClick").hide();
	mouse_down = true;
	$("#selector").css("background-color", "#666666");
	$(".page").removeClass("selected");
	$("#selector").hide();
	left = e.pageX;
	top = e.pageY;
	
	return false;
}; 

var selectorMove = function(e){

	if (mouse_down) {
		unbindThemAll();
		right = e.pageX;
		bottom = e.pageY;
		width = Math.abs(right-left);
		height = Math.abs(bottom-top);
		if (left>right) {l = right;} else {l=left;}
		if (bottom<top) {t = bottom;} else {t=top;}
		$("#selector").css({
			"top":t,
			"left":l,
			"width":width,
			"height":height
		}).show();
	bindThemAll();
	}
return false;
};


var selectorEnd = function(e){
	if (mouse_down) {
		unbindThemAll();
		mouse_down = false;
		right = e.pageX;
		bottom = e.pageY;
		width = Math.abs(right-left);
		height = Math.abs(bottom-top);
		if (left>right) {left = right;}
		if (bottom<top) {top = bottom;}
		
		t = Math.floor(top/gridh)*gridh;
 		l = Math.floor(left/gridw)*gridw;
 		
 		width = width + left - l;
 		height = height + top - t;
		width = Math.ceil(width/gridw)*gridw;
 		height = Math.ceil(height/gridh)*gridh;
 		if (width < gridw) {width = gridw;}
 		if (height < gridh) {height = gridh;}
		
		$("#selector").css({
			"top":t,
			"left":l,
			"width":width,
			"height":height
		}).hide();
		
		$.ajax({
				type: "POST",
					url: "actions/select_pages.php",
					data: "top="+t*x+"&left="+l*x+"&width="+width*x+"&height="+height*x,
					success: function(phpfile){
					$("#update").html(phpfile);
					bindThemAll();}
				});
		return false;
	}
	
}; 

var editPage = function(e){
	e.stopImmediatePropagation();
	left=document.body.scrollLeft;
	top=document.body.scrollTop;
	if ($(this).parent().attr("class").indexOf("page")== -1){id=$(this).parent().attr("class");}
	else {id=this.id.substr(4);}
	window.location=("../page/page.php?page_id="+id+"&left="+left+"&top="+top);
};

var deletePage = function(e){
	e.stopImmediatePropagation();
	unbindThemAll();
	if ($(this).parent().attr("class").indexOf("page")== -1){id=$(this).parent().attr("class");}
	else {id=this.id.substr(6);}
	var answer = confirm("This action cannot be undone. All associated links to this page will also be deleted. Are you sure you want to delete this page? ")
		if(answer) {
			$("#update").load("actions/delete_page.php?page_id="+id);
			$("#"+id).fadeOut();
		}
		else {}
	bindThemAll();
};

var pageRelation = function(e){
	e.stopImmediatePropagation();
	unbindThemAll();
	//console.log($(this).parent().attr("class"));
	relation_id = this.id.substr(5);
	if (relation_id == "ink") {relation_id= $(this).parent().attr("class").substr(5);}
	//console.log(relation_id);
	
	width = 700;
	height = 150;
	open(width, height);
	$.ajax({
		type: "POST",
			url: "ajax/page_relation.php",
			data: "relation_id="+relation_id,
			success: function(phpfile){
			$("#popup-content").append(phpfile);
			}
		});
	bindThemAll();
};


var relatePage = function(){
	$(this).draggable({
	revert: true,
	start: function(event, ui) {unbindThemAll();},
	stop: function(event, ui) {bindThemAll();}
});
};

var closeOnClick = function(){close();}; 

var closeOnClick = function(){close();}; 

var hidePageRightClick = function() {
	$("#pageRightClick").hide();
};




var startMover = function(e) {
/* 	$(".page").draggable("disabled",true); */
	$(this).draggable({
	revert: "invalid",
	start: function(event, ui){unbindThemAll();},
	stop: function(event, ui){bindThemAll();/* $(".page").draggable("disabled", false) */;}
	
	});
		
}





var showContextmenu = function(e){

	$("#pageRightClick").css({
	"left" : e.pageX,
	"top" : e.pageY	
	}).show().removeClass().addClass(this.id);
	if ($(this).attr("class").indexOf("page") !== -1) {$("#editPage, #duplicate, #delete, #toggleFinish, #linkToStory").show	();$("#deleteLink, #editLink").hide();}
	if ($(this).attr("class").indexOf("arrow") !== -1) {$("#editPage, #duplicate, #delete, #toggleFinish, #linkToStory").hide();$("#deleteLink, #editLink").show();}
	return false;
}

var toggleFinish = function(e) {
	e.stopImmediatePropagation();
	id=$(this).parent().attr("class");
	
$.ajax({
		type: "POST",
		url: "actions/toggleFinish.php",
		data: "id="+id,
		success: function(phpfile){
			$("update").html(phpfile);
			if ($("#"+id+" div").last().attr("class") == "start-finish-summary finish") 
				{$("#"+id+" div").last().remove();} 
			else 
				{$("#"+id).append("<div class='start-finish-summary finish'>Finish</div>");}
		}
	});

}

var showTop = function(e) {
	$("#toolbar, #header").css({"opacity":"0.8"});
}

var hideTop = function(e) {
		$("#toolbar, #header").css({"opacity":"0.2"});

}

var hudShow = function(e) {
	$("#hud").css({
		"background-color" : "rgba(0, 0, 0, 0.5)",
		"color" : "rgba(255, 255, 255, 1.0)"
	
	}).draggable();
	$("#hud .btn").css("opacity","0.90");
}

var hudHide = function(e) {
	$("#hud").css({
		"background-color" : "rgba(0, 0, 0, 0.1)",
		"color" : "rgba(255, 255, 255, 0.3)"
	
	});
	$("#hud .btn").css("opacity","0.2");

}

var removeUser = function(e) {
	e.stopImmediatePropagation();
	unbindThemAll();
	user_id = this.id.substr(5);
	var answer = confirm("Are you sure you want to revoke author access to this user?");
	if (answer) {
		$.ajax({
			type: "POST",
			url: "actions/removeUser.php",
			data: "user_id="+user_id,
			success: function(phpfile){
				$("#update").html(phpfile);
				$("#authorList").load("ajax/authorList.php");
			}
		});
	
	
	
	}
	//console.log(user_id);
	bindThemAll();

}

var linkToStory = function(e) {
	e.stopImmediatePropagation();
	unbindThemAll();
	page_id=$(this).parent().attr("class");
	width = 700;
	height = 400;
	open(width, height);
	
$.ajax({
		type: "POST",
			url: "ajax/linkToStory.php",
			data: "page_id="+page_id,
			success: function(phpfile){
			$("#popup-content").append(phpfile);
			}
		});

	bindThemAll();
}

/* --------------------------end-handlers--------------------------- */

/* resizeGrid(lowest, rightest); */
$(window).resize(function(){
/* 	resizeGrid(lowest, rightest); */
});

$("#ajax").ajaxStart(function (){$(this).show();}).ajaxStop(function () {$(this).hide();bindThemAll();});
$("#fadebackground, .close-icon").click(closeOnClick)
$("#update").draggable();
$("#mapgrid").click(function(){});




/* sets pages and droppable regions */
$(".page").droppable({
	accept: ".relate, #start, #summary",
	drop: function(event, ui) {
	if ($(ui.draggable).hasClass("relate")) {
		//console.log('relate');
		child = this.id;
		parent = $(ui.draggable).attr("id").substr(6);
		
		$.ajax({
			type: "POST",
			url: "actions/add_relation.php",
			data: "parent="+parent+"&child="+child,
			success: function(phpfile){
				$("#update").append(phpfile);}
			});
	}
	if ($(ui.draggable).attr('id') == "start") {
		//console.log("start");
		$("#start").remove();
		$("#"+this.id).append("<div class='start-finish-summary' id='start' title='Click twice. On the Second click keep the mouse key down and drag to a new page.'>Start</div>");
		$.ajax({
			type: "POST",
			url: "actions/update_start.php",
			data: "page_id="+this.id,
			success: function(phpfile){
				$("#update").html(phpfile);
				bindThemAll();
			}	
		
		
		});
	}
	if ($(ui.draggable).attr('id') == "summary") {
		//console.log("summary");
		$("#summary").remove();
		$("#"+this.id).append("<div class='start-finish-summary' id='Summary' title='Click twice. On the Second click keep the mouse key down and drag to a new page.'>Summary</div>");
		$.ajax({
			type: "POST",
			url: "actions/update_summary.php",
			data: "page_id="+this.id,
			success: function(phpfile){
				$("#update").html(phpfile);
				bindThemAll();
			}	
		
		
		});
	}
	}

});


$(".page").live("contextmenu", showContextmenu);
$(".arrow").live("contextmenu", showContextmenu);
/* actions for dragging pages */




	$(".page").draggable({
	grid: [gridw, gridh],

	start: function(event, ui) {
					unbindThemAll();

		
		if ($(this).hasClass('selected')) {
			multiple_drag = true;
			start_pos = $(this).position()
			$(this).addClass('dragger');
		}
		else {$(".selected").removeClass('selected');}
		$(".line").fadeOut();
		//console.log("x: "+x+", w: "+gridw+", h:"+gridh);
	},
	drag: function(event, ui) {/* 		$.ajax({type: "POST", url: "actions/change_lines.php", data: "page="+this.id, success: function(phpfile){$("#update").append(phpfile);}}); */
	},
	stop: function(event, ui) {
		$(this).removeClass('temp-new-page');
	
	var Stoppos = $(this).position();
 	t = Stoppos.top;
 	l = Stoppos.left;
 	if (t<gridh){t=gridh;$(this).css({"top" : t});}
 	if (l<gridw){l=gridw;$(this).css({"left" : l});} 
 		$(this).css({"top" : t, "left" : l});
 		
		$(".line").fadeIn();
		if (multiple_drag) {
 			top_dis = t-start_pos.top;
 			left_dis = l- start_pos.left;
 			dragger = false;
 			movingMany(top_dis, left_dis, dragger);
 		}

 			$.ajax({
				type: "POST",
				url: "actions/change_location.php",
				data: "page="+this.id+"&top="+t*x+"&left="+l*x,
				success: function(phpfile){
				$("#update").append(phpfile);}
			});
		if (multiple_drag) {/* location.reload(true); */}
		$(".selected").removeClass('dragger');
/* 		bindThemAll(); */

	}
});

/* binding and unbinding functions */
bindThemAll();

function bindThemAll() {
	//console.log("bound");
	$("body").bind("click",hidePageRightClick);
	$(".page").click(togglePageClass);
	$("#logoutFromMenu").click(logoutFromMenu);
	$("#edit").click(editStory);
	$("#permissions").click(permissions);
	$("#new_page").click(newPage);
	$('html').keyup(keyboard);
	$("#mapgrid").mousedown(selectorStart);
	$("#mapgrid").mousemove(selectorMove);
	$("html").mouseup(selectorEnd);
	$(".edit-page, #editPage").live('click', editPage);
	$(".delete, #delete").live('click', deletePage);
	$(".arrow, #editLink, .linkToStory").live('click', pageRelation);
	$(".relate").live('mouseover', relatePage);
	$("#start").live("click", startMover);
	$("#summary").live("click", startMover);
	$("#toggleFinish").live("click", toggleFinish);
	$("#hud").mouseover(hudShow);
	$("#hud").mouseout(hudHide);
	$(".removeUser").live("click", removeUser);
	$("#linkToStory").live("click", linkToStory);
}

function unbindThemAll() {
	//console.log("unbound");
	$("body").unbind("click",hidePageRightClick);
	$(".page").unbind('click', togglePageClass);
	$("#logoutFromMenu").unbind('click', logoutFromMenu);
	$("#edit").unbind('click', editStory);
	$("#permissions").unbind('click', permissions);
	$("#new_page").unbind('click', newPage);
	
	$('html').unbind('keyup', keyboard);
	$("#mapgrid").unbind('mousedown', selectorStart);
	$("#mapgrid").unbind('mousemove', selectorMove);
	$("html").unbind('mouseup', selectorEnd);
	$(".edit-page, #edit-page").unbind('click', editPage);
	$(".delete, #delete").unbind('click', deletePage);
	$(".arrow, #editLink, .linkToStory").unbind('click', pageRelation);
	$(".relate").unbind('mouseover', relatePage);
	$(".removeUser").unbind("click", removeUser);
	$("#linkToStory").unbind("click", linkToStory);


	$("#start").unbind();
	$("#summary").unbind();
	
	$("#toggleFinish").unbind("click", toggleFinish);
/* 	$("#top-stuff").unbind(); */
	$("#hud").unbind();
}

/* end of binding functions */

}); //end of document.ready




function movingMany (top_dis, left_dis, dragger) {
	$(".selected").each(function(){
	 			
	 			if (!$(this).hasClass('dragger')) {
	 			pos_page = $(this).position();
	 			new_top = pos_page.top+top_dis;
	 			new_left =pos_page.left+left_dis ;
	 			if (new_top<60) {new_top = 60;/* top_dis = top_dis + 120 + new_top; dragger = true; movingMany(top_dis, left_dis, dragger); return; */}
	 			if (new_left<210) {new_left = 210;/* left_dis = left_dis + 210 + new_left; dragger = true; movingMany(top_dis, left_dis, dragger); return; */}

	 			$(this).css({"top" : new_top, "left" :new_left });
	 			
	 			$.ajax({
					type: "POST",
					url: "actions/change_location.php",
					data: "page="+this.id+"&top="+new_top*x+"&left="+new_left*x,
					success: function(phpfile){
					$("#update").append(phpfile);}
				});
	 			}
	 		});
/* 	 if (dragger) {$(this).animate({"top" : new_top, "left" :new_left });} */
}

function close() { // closes popup
	$("#popup-content").html("");
	$("#fadebackground, #popup").fadeOut();
}

function open(width, height) { //opens popup
	$("#popup").css({
		"width": width,
		"height": height,
		"left" : "50%",
		"top" : "50%",
		"margin-left" : -1*width/2,
		"margin-top" :-1*height/2
	});
	$("#fadebackground, #popup").fadeIn();
}

function update_story() { // loads php to update story
	if(!$("#story_name").val()) {alert("You must have a story name");$("#story_name_label").css("color" , "red");return false;}

	value=$('form').serialize();
		$.ajax({
		type: "POST",
			url: "actions/edit.php",
			data: value,
			success: function(phpfile){
			$("#update").append(phpfile);
			
			topic = $("input[name=story_topic]").val();
			name = $("input[name=story_name]").val();
			$("#header").html(topic+": "+name);
			close();
			}
		});
}

function update_relation() { // loads php to update story
	value=$('form').serialize();
		$.ajax({
		type: "POST",
			url: "actions/update_relation.php",
			data: value,
			success: function(phpfile){
			$("#update").append(phpfile);
			close();
			}
		});
}

function delete_relation(child) { // loads php to update story
	if ($(child).parent().attr("class") !== undefined) {value = "page_relation_id="+$(child).parent().attr("class").substr(5);}
	else {value=$('form').serialize();}
	//console.log(value);
	
		$.ajax({
		type: "POST",
			url: "actions/delete_relation.php",
			data: value,
			success: function(phpfile){
			$("#update").append(phpfile);
			close();
			}
		});
}

function line(parent, child, relation_id, magT, magL) { //draws lines

	var parentPos = $("#"+parent).position();
	var childPos = $("#"+child).position();
	
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
	
	newtop = parentPos.top-half+h+magT;
	left = childPos.left+((parentPos.left-childPos.left)/2)+magL;
	
	
	$("#line"+relation_id).css({
	"height" : myheight,
	"top" : newtop,
	"left" : left,
	"-webkit-transform" : "rotate("+angle+"deg)", 
	"-moz-transform" :  "rotate("+angle+"deg)"
	});
	
	$("#arrow"+relation_id).css({
	"top": half
	});
}

function resizeGrid(lowest,rightest) {
	l=lowest+60;
	r=rightest+210;
	mheight = window.innerHeight;
	mwidth = window.innerWidth;
	if (mwidth < r) {width = r;} else {width=mwidth-20;}
	if (mheight < l) {height = l;} else {height=mheight-20;}
	$("#mapgrid").css({"height":height, "width":width});
}

function zoomValue(x) {
	switch (x) {
		case .5 : startValue = -5; break;
		case .6: startValue = -4; break;
		case .75: startValue = -3; break;
		case 1: startValue = -2; break;
		case 1.3: startValue = -1; break;
		case 1.5: startValue = 0; break;
		case 1.8: startValue = 1; break;
		case 2.0: startValue = 2; break;
		case 2.5: startValue = 3; break;
		case 3.0: startValue = 4; break;
		case 5.0: startValue = 5; break;
	}
	//console.log(startValue);
	return startValue;
}

function addLinkToStory() {
	value=$("form").serialize();
	//console.log(value);
	$.ajax({
			type: "POST",
			url: "actions/add_relation.php",
			data: value,
			success: function(phpfile){
				$("#update").append(phpfile);
				location.reload(true);}
			});

}

function deleteLinkToStory(relation_id) {
	answer = confirm("Are you sure you wish to delete this link?")
	if (answer) {
		$.ajax({
			type: "POST",
			url: "actions/delete_relation",
			data: "page_relation_id="+relation_id,
			success: function(phpfile){
				$("#update").html(phpfile);
			}
		});
	$("#ExLink"+relation_id).hide();
	}

}
