document.addEventListener("touchmove", function(e){e.preventDefault();}, false); 

function isTouchDevice(){
	try{
		document.createEvent("TouchEvent");
		return true;
	}catch(e){
		return false;
	}
}
function Scroller(id){
	if(isTouchDevice){ //if touch events exist...
		var el=document.getElementById(id);
		var scrollStartPos=0;
		document.getElementById(id).addEventListener("touchstart", function(event) {
		scrollStartPos=this.scrollTop+event.touches[0].pageY;
		scrollStartPosX = this.scrollLeft+event.touches[0].pageX;
		/* event.preventDefault(); */
		},false);
		document.getElementById(id).addEventListener("touchmove", function(event) {
		this.scrollTop=scrollStartPos-event.touches[0].pageY;
		this.scrollLeft=scrollStartPosX-event.touches[0].pageX;
/* 		event.preventDefault(); */
		},false);
	}
}
