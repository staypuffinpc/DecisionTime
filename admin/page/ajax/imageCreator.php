<?php


?>

<script>
$("#saveImage").click(function(){
	
	$(".image").each(function(){
		canvas.width = canvas.width;

		var pos = $(this).position();
		var ctx = $("#canvas")[0].getContext("2d");
		var img = new Image();
	    img.onload = function(){
		ctx.drawImage(img,pos.left,pos.top);
	};
	img.src = this.src;
		
	});
	$("#left, #left2").toggle();

});
$("#s").click(function(){
	var data = canvas.toDataURL("image/png");
	
	$.ajax({
		type: 	"POST",
		url:	"actions/save_image.php",
		data:	"image="+data,
		success: function(phpfile) {
			$("#right").html(phpfile);	
		}
	});
});

if ($.browser.webkit) {
	$(".image").mousedown(function(e){
		if (event.preventDefault) event.preventDefault();
	});
}

$(".image").draggable({
	start: function(event, ui) {},
	drag:	function(event, ui) {},
	stop:	function(event, ui) {
			}
});


</script>
<h2>Image Creator</h2>
<div id="left">
	<div id="theCreated">
	<div class="createdImage">
		<img style="top:250px;left:100px" class="image" src="../../img_assets/Ben.png" />
		<img style="top:25px; left:25px;"class="image" src="../../img_assets/Alison.png" />
	</div>
	</div>
<a class="dbutton" id="saveImage">Save Image</a>
</div>
<div id="left2">
<canvas id="canvas" width="480px" height="360px"></canvas>
</div>

<div id="right">
<h4>Assets</h4>

<div class="image">Test</div>
</div>
