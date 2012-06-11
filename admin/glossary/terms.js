var termChange = function(e){
	unbindThemAll();
	//console.log("function triggered");
	$('#edit_this_term').submit();
	value=$('#edit_this_term').serialize();
	term_id = $("input#term_id").val();
	term = $("input#term").val();
	definition = $("textarea#definition").val();
	
	$('.'+term_id).html(term);
	$('.'+term_id+'D').html(definition);
	$('.'+term_id+'D').css({"background-color" : "transparent", "color" : "black", "font-weight" : "normal"});

	$.ajax({
		type: "POST",
		url: "actions/term_change.php",
		data: value,
		success: function(phpfile){
		$("#update-status").html(phpfile);
		bindThemAll();
		$("#term-editor").html("Click on a row to edit the content.");
		}
	});
};

var newTerm = function(e) {
	unbindThemAll();
	e.stopImmediatePropagation();
	//console.log("new term clicked");
	$.ajax({
		type: "POST",
		url: "actions/new_term.php",
		success: function(phpfile){
		$(".content").load('ajax/term.php?term='+phpfile);
		
		}
	});
	formatGlossary();
	bindThemAll();
};

var editTerm = function(e) {
	id = this.id;
	openInTermEditor(id);
}

var deleteTerm = function(e) {
	e.stopImmediatePropagation();
	var answer = confirm("Are you sure you want to delete this term?");
	//console.log(answer);
	if (answer) {
		info = $(this).attr('class').split(" "),
		//console.log($(this).attr('class'));
		$.ajax({
			type: "POST",
			url: "actions/deleteTerm.php",
			data: "term_id="+info[1],
			success:function(phpfile){$("#update").html(phpfile);$("#"+info[1]).remove();formatGlossary();}
		});
	}
}

var findTerms = function(e) {
	e.stopImmediatePropagation();
	var answer = confirm("This will attempt to add all key terms from your that don't have definitions to the list. Are you sure you want to continue?");
	if (answer) {
		$.ajax({
			url: "actions/findTerms.php",
			success:function(phpfile) {$("#update").html(phpfile);$(".content").load("ajax/term.php");}
		
		});
	}
}

var keyboard = function(e) {if (e.keyCode == '27') //escape event listener
		{
		if($("#fadebackground:visible").length !==0)
			{close();} // if a popup is up, this closes it
		}
		if (e.keyCode == '112') {//console.log("update");$("#update").toggle();}
};


function bindThemAll() {
	$("#term-change").live('click', termChange);
	$("#new-term").live('click', newTerm);
	$(".deleteTerm").live("click", deleteTerm);
	$("#findTerms").live("click", findTerms);
	$("tr.clickable-item").live("click", editTerm);
	$('html').keyup(keyboard);

}

function unbindThemAll() {
	$("tr.clickable-item").unbind();
	$("#term-change").unbind('click', termChange);
	$("#new-term").unbind();
	$(".deleteTerm").unbind();
	$("#findTerms").unbind();
	$("html").unbind();
}

function openInTermEditor(id, left, top) {
$.ajax({
	type: "POST",
	url: "ajax/term_editor.php",
	data: "term_id="+id,
	success: function(phpfile){
		$("#term-editor").html(phpfile);
	}
});

}

function formatGlossary(){
	$("table.glossary td").each(function(){
		$(this).children('p').first().css("margin-top","0px");
	});
	$("table.glossary tr:even").css("background-color", "#e8e8e8");
	$("table.glossary tr:odd").css("background-color", "#ffffff");


}

function markRed(){
$("td span").each(function(){
		if($(this).text() == " No definition provided" || $(this).text() == "No definition provided") {
			$(this).css({"background-color" : "red", "color":"white", "font-weight" : "bold"});
		}
	});

}

$("document").ready(function(){
	bindThemAll();



});