$("document").ready(function(){
	var dragging=false;
	
	if ($.browser.webkit) {
	$("img").mousedown(function(e){
		if (event.preventDefault) event.preventDefault();
	});
}
	
	$( "#red, #green, #blue, #red-title, #green-title, #blue-title, #red-login, #green-login, #blue-login, #red-title2, #green-title2, #blue-title2" ).slider({
			orientation: "horizontal",
			range: "min",
			max: 255,
			value: 127,
			slide: refreshSwatch,
			change: refreshSwatch,
			
			
		});
	$("#red, #green, #blue").mouseover(function(){$("#red, #green, #blue").slider({disabled: false})});
	$("#blue-title, #green-title, #red-title").mouseover(function() {$("#blue-title, #green-title, #red-title").slider({disabled: false});});
	$("#blue-login, #green-login, #red-login").mouseover(function() {$("#blue-login, #green-login, #red-login").slider({disabled: false});});
	$("#blue-title2, #green-title2, #red-title2").mouseover(function() {$("#blue-title2, #green-title2, #red-title2").slider({disabled: false});});
	$( "#red, #green, #blue, #red-title, #blue-title, #green-title, #red-login, #blue-login, #green-login, #red-title2, #blue-title2, #green-title2").slider({disabled: true});
	$("#title, #login, #title2").mouseover(function(){dragging=false;});
	
	$( "#height" ).slider({
			orientation: "vertical",
			range: "min",
			min: 0,
			max: 80,
			value: 20,
			slide: changeHeight,
			change: changeHeight,
		});
	
	$( "#radius" ).slider({
			orientation: "vertical",
			range: "min",
			min: 0,
			max: 50,
			value: 8,
			slide: function(){$("#splash").css("border-radius", $("#radius").slider("value"));	$("#radius-value").val($("#radius").slider("value")+"px");},
			change: function(){$("#splash").css("border-radius", $("#radius").slider("value"));$("#radius-value").val($("#radius").slider("value")+"px");},
		});
		
		
$( "#shadow" ).slider({
			orientation: "vertical",
			range: "min",
			min: 0,
			max: 100,
			value: 8,
			slide: function(){$("#splash").css("box-shadow", "0px 0px "+$("#shadow").slider("value")+"px rgba(0,0,0,0.4)");$("#shadow-value").val($("#shadow").slider("value")+"px");},
			change: function(){$("#splash").css("box-shadow", "0px 0px "+$("#shadow").slider("value")+"px rgba(0,0,0,0.4)");$("#shadow-value").val($("#shadow").slider("value")+"px");},
		});
	
	$("#title, #login, #title2, #teacher-splash, .icons").mouseover(function(){$(this).draggable({
		start: function(){dragging=true}
		
	});});
	
	
	$("#title").toggle(
		function(){
			if (dragging) {return;}
			p = $(this).offset();
			w = $(this).width();
			$("#title-editor").css({"top" : p.top-50, "right" : 0}).show();
		},
		function(){
			if (dragging) {return;}
			$("#title-editor").hide();
		}
		);

	$("#login").toggle(
		function(){
			if (dragging) {return;}
			p = $(this).offset();
			//console.log(p.top);
			w = $(this).width();
			$("#login-editor").css({"top" : p.top-50, "right" : 0}).show();
		},
		function(){
			if (dragging) {return;}
			$("#login-editor").hide();
		}
		);
		
	$("#title2").toggle(
		function(){
			if (dragging) {return;}
			p = $(this).offset();
			w = $(this).width();
			$("#title2-editor").css({"top" : p.top-50, "right" : 0}).show();
		},
		function(){
			if (dragging) {return;}
			$("#title2-editor").hide();
		}
		);

	$("select").change(function(){
		//console.log(this.id);
		info=this.id.split("-");
		font = $(this).val();
		$("#"+info[0]).css({"font-family" : "'"+font+"'"});
	
	});
	
	$("#login-size, #title-size, #title2-size").keyup(function(){
				
		info=this.id.split("-");

		size = $(this).val();
		//console.log(size);
		$("#"+info[0]).css({"font-size" : size+"px"});

	
	});

	$("#direct-code").keyup(function(){
			$( "body" ).css( "background-color", "#" + $(this).val() );
			$("#red, #green, #blue").slider({ disabled: true });
			$("#height .ui-slider-range").css({"background": "#" + $(this).val()});
			$("#height .ui-slider-handle").css({"border-color": "#" + $(this).val()});
	
	
	});

	$("input[type=radio]").change(function(){
		bg = "url(img/"+$(this).val()+".png)";
		//console.log(bg);
		$("body").css("background-image" , bg);
	
	});
	
	$("#height-value").keyup(function(){
			$("body").css({"background-size": $(this).val()+"px"});
	});
		
	$("#radius-value").keyup(function(){
			$("#splash").css("border-radius", $(this).val()+"px");
	});
	$("#shadow-value").keyup(function(){
			$("#splash").css("box-shadow", "0px 0px "+$(this).val()+"px rgba(0,0,0,0.4)");
	});

	$("#title-color, #login-color, #title2-color").keyup(function(){
		info = this.id.split("-");
		$("#"+info[0]).css("color", "#"+$(this).val());
		$("#red-"+info[0]+", #blue-"+info[0]+", #green-"+info[0]).slider({disabled: true});
	
	});	

	$("html").keyup(function(e){
	if (e.keyCode == 27) {
		$("#editor, #color").toggle();
	
	}
	
	});

});

function refreshSwatch() {
		info = this.id.split("-");
		if (info[1]) {
			var red = $( "#red-"+info[1] ).slider( "value" ),
				green = $( "#green-"+info[1] ).slider( "value" ),
				blue = $( "#blue-"+info[1] ).slider( "value" ),
				hex = hexFromRGB( red, green, blue );
			$("#"+info[1]).css("color","#"+hex);
			$("#"+info[1]+"-color").val(hex);
		
		}
		else {
			var red = $( "#red" ).slider( "value" ),
				green = $( "#green" ).slider( "value" ),
				blue = $( "#blue" ).slider( "value" ),
				hex = hexFromRGB( red, green, blue );
			$( "body" ).css( "background-color", "#" + hex );
			$("#direct-code").val(hex);
			$("#height .ui-slider-range").css({"background": "#" + hex});
			$("#height .ui-slider-handle").css({"border-color": "#" + hex});
		}
}
	
	function hexFromRGB(r, g, b) {
		var hex = [
			r.toString( 16 ),
			g.toString( 16 ),
			b.toString( 16 )
		];
		$.each( hex, function( nr, val ) {
			if ( val.length === 1 ) {
				hex[ nr ] = "0" + val;
			}
		});
		return hex.join( "" ).toUpperCase();
	}
	
function changeHeight() {
	h = 100 - $("#height").slider("value");
	$("body").css({"background-size": h+"px"});
	$("#height-value").val($("#height").slider("value"));
}