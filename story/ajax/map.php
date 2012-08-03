<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$user_id = $_SESSION['user_id'];
$story = $_SESSION['story'];

$query = "Select story_summary from Stories where story_id='$story'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);

$query_pages = "Select * from Pages where story=$story AND page_top is not null ORDER by page_name ASC"; //mysql query variable
$list_pages = mysql_query($query_pages) or die(mysql_error()); //execute query

$query_page_relations = "Select * from Page_Relations where page_story=$story"; //mysql query variable
$list_page_relations = mysql_query($query_page_relations) or die(mysql_error()); //execute query

$query_user_progress = "Select progress_page from User_Progress where progress_user='$user_id' and progress_story='$story'";
$list_user_progress = mysql_query($query_user_progress) or die(mysql_error()); //execute query
$progress = mysql_fetch_assoc($list_user_progress);//gets info in array
$progress = explode(", ", $progress['progress_page']);
?>
<div class="map-wrapper">

<?php
$top = 0;
$left = 0;
$type_class="blank";
if (in_array($results['story_summary'], $progress)) {$summary = true;} else {$summary = false;}

if (!$summary) {

while ($pages = mysql_fetch_assoc($list_pages)) {  //while 1

	
	if (strlen($pages['page_name'])>20 && strlen($pages['page_name'])>0){$page_name = substr($pages['page_name'],0,17)." . . ." ;}
	else {$page_name=$pages['page_name'];}
	
	if ($pages['page_type']=="Story") {$type_class="story";}
	if ($pages['page_type']=="Teaching") {$type_class="teaching";}
	if ($pages['page_type']=="Appendix") {$type_class="appendix";}
	if (in_array($pages['id'], $progress)){?>
 		<div class="page <?php echo $type_class; ?>" title="<?php echo $pages['page_name'];?>" style="top:<?php echo $pages['page_top']; ?>px;left:<?php echo $pages['page_left']; ?>px" id="<?php echo $pages['id']; ?>">
			<?php echo $page_name; ?>
		</div>
		<?php	
			if($pages['page_top'] > $top) {$top = $pages['page_top'];}
			if($pages['page_left'] > $left) {$left = $pages['page_left'];}
		
	 }
	else {
	$query_child_search = "Select * from Page_Relations where page_child='".$pages['id']."'";
	$list_child_search = mysql_query($query_child_search) or die(mysql_error()); //execute query
	
	while ($child_search = mysql_fetch_assoc($list_child_search)) { //while 2
		if (in_array($child_search['page_parent'], $progress)) {
		?>
		<div class="page inactive" title="<?php echo $pages['page_name'];?>" style="top:<?php echo $pages['page_top']; ?>px;left:<?php echo $pages['page_left']; ?>px" id="<?php echo $pages['id']; ?>">
			<?php echo "?"; ?>
		</div>
		<?php
		if($pages['page_top'] > $top) {$top = $pages['page_top'];}
		if($pages['page_left'] > $left) {$left = $pages['page_left'];}
		break;
		}
	
		} //end while 2
	} //end else
} //end while 1
} //end showing stuff if the summary is visible
else { //if $summary = true



while ($pages = mysql_fetch_assoc($list_pages)) {  //while 1.5

	
	if (strlen($pages['page_name'])>20 && strlen($pages['page_name'])>0){$page_name = substr($pages['page_name'],0,17)." . . ." ;}
	else {$page_name=$pages['page_name'];}

	if ($pages['page_type']=="Story") {$type_class="story";}
	if ($pages['page_type']=="Teaching") {$type_class="teaching";}
	if ($pages['page_type']=="Appendix") {$type_class="appendix";}

	if (in_array($pages['id'], $progress)){?>
 		<div class="page <?php echo $type_class; ?>" title="<?php echo $pages['page_name'];?>" style="top:<?php echo $pages['page_top']; ?>px;left:<?php echo $pages['page_left']; ?>px" id="<?php echo $pages['id']; ?>">
			<?php echo $page_name; ?>
		</div>
	<?php
		if($pages['page_top'] > $top) {$top = $pages['page_top'];}
		if($pages['page_left'] > $left) {$left = $pages['page_left'];}
	
	}
	else {?>
	
		<div class="page inactive" title="<?php echo $pages['page_name'];?>" style="top:<?php echo $pages['page_top']; ?>px;left:<?php echo $pages['page_left']; ?>px" id="<?php echo $pages['id']; ?>">
			<?php echo "?"; ?>
		</div>

		<?php
		
		
	
		
	} //end else
} //end while 1.5




} //end else
for ($i=1;$i<10000000;$i++) {}
while ($relations = mysql_fetch_assoc($list_page_relations)) { // while 3
?>

<div class="line" id="line<?php echo $relations['page_relation_id']; ?>">
	<div title="<?php echo $relations['page_stem']." ".$relations['page_link'].$relations['page_punctuation']; ?>" id="arrow<?php echo $relations['page_relation_id']; ?>" class="arrow">
	</div>
</div>



<script>
	line(<?php echo $relations['page_parent'].", ".$relations['page_child'].", ".$relations['page_relation_id']; ?>);

</script>

<?php } //end while 3
?>
<div id="youarehere">You are<br/>here.</div>
</div>
<script>
//console.log("<?php echo $top; ?>");//console.log("<?php echo $left; ?>");
height = <?php echo $top; ?>*1+300;
left = <?php echo $left; ?>*1+250;
//console.log(height+" "+left);
$('.map-wrapper').css({
	"height" : height,
	"width" : left
});

$(".page").click(function(){
	_gaq.push(['_trackEvent', 'Map Click', this.id, this.id+' on the map was clicked.']); //GA tracking
	if ($(this).hasClass('inactive')) {alert("You have not visited this page yet.");}
	else {window.location = "index.php?page_id="+this.id;}
});

loc = $("#<?php echo $_SESSION['current_page']; ?>").position();
tophere = loc.top-30;
lefthere = loc.left+175;

$("#youarehere").css({"top":tophere,"left":lefthere});
top1 = (loc.top+25-window.innerHeight/2)+"px";
left = (loc.left+100-window.innerWidth/2)+"px";

$("#<?php echo $_SESSION['current_page']; ?>").addClass('current');
$("#viewport").scrollTo({top:top1, left:left}, 800);
google_analytics(); 

</script>
<div class="page-instructions"><a class='page-instructions-toggle'> Use the 'i' key to toggle Instructions.</a>
<p>This map shows where you've been in the story so far.  Green pages contain story-related content, blue pages contain instructional content, and gray pages are ones you have not yet visited but have seen a link to at some point in the story.  The map will grow as you explore the story.  You can click on any page you've already visited to go directly to that part of the story.</p>
<p>(HINT: once you "solve" the story, the entire map will be unlocked and you can visit any page directly from the map.)</p>

</div>

