<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$user_id = $_SESSION['user_id'];

if (isset($_GET['left'])) {$left = $_GET['left'];} else {$left = 0;}
if (isset($_GET['top'])) {$top = $_GET['top'];} else {$top = 0;}
if (isset($_GET['page'])) {$pageHL = $_GET['page'];} else {$pageHL = 0;}



if (!isset($_GET['story'])) {$story=$_SESSION['story'];}
else {
$story = $_GET['story'];

$_SESSION['story'] = $story;}
include_once("../db.php");

if (isset($_GET['x'])) {$x = $_GET['x'];}
else {$x = 1;}
$magT = 50/(2*$x);
$magL = 100/$x;
$pw = $magL*2;
$ph = $magT*2;
$f = 16/$x;
$img_size = 20/$x;
$arrow_size = 30/$x;
$arrow_location = -14/$x;
$relate_right = 52/$x;
$edit_page_right = 28/$x;
$delete_right = 3/$x;
$grid_size = 210/$x;
$external_size = 10/$x;
$start_finish_summary_height = 17/$x;
$padding = 3/$x;
$start_finish_summary_font = 14/$x;

$gridw = 210/$x;
$gridh = 60/$x;

$_SESSION['gridw'] = $gridw;
$_SESSION['gridh'] = $gridh;
$_SESSION['x'] = $x;
$_SESSION['ph'] = $ph;

$_SESSION['magT'] = $magT;
$_SESSION['magL'] = $magL;


?>
<html>
<head>
<title><?php echo $story_info['story_topic']; ?>: <?php echo $story_info['story_name']; ?></title>
<link href="../../styles/style.css" rel="stylesheet" type="text/css" />

<link href="admin.css" rel="stylesheet" type="text/css" />
  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>	


  
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-ui.js"></script>
<script type="text/javascript" src="../../js/common.js"></script>

<script type="text/javascript" src="../../js/jquery.client.js"></script>
<script type="text/javascript" src="../../js/jquery-scroll.js"></script>

<script type="text/javascript" src="admin.js"></script>



<script type="text/javascript">
<?php 
$h = 0;
$w = 0;
if ($story == NULL) {?>
window.location = "../dashboard/";
<?php
}
?>
$(document).ready(function(){
window.scroll(<?php echo $left; ?>, <?php echo $top; ?>);
});
var x = <?php echo $x; ?>;
var gridw = 210/<?php echo $x; ?>;
var gridh = 60/<?php echo $x; ?>;
var story = <?php echo $story; ?>;

</script>
</head>
<body id="mainbody">
<div id="header"><?php echo $story_info['story_topic']; ?>: <?php echo $story_info['story_name']; ?>
<a id="home" class="upperLeft" href='../../dashboard/index.php'></a>
<div id="greeting"><?php echo "<img src='../".$_SESSION['user_image']."'/> <span class='name'> ".$_SESSION['user_name']."</span>"; ?><a id="logoutFromMenu" class="btn blockButton" href="../../logout.php">Logout</a></div>

</div>

<?php

while ($pages = mysql_fetch_assoc($list_pages)) { 
if (strlen($pages['page_name'])>20 && strlen($pages['page_name'])>0){$page_name = substr($pages['page_name'],0,17)." . . ." ;}
else {$page_name=$pages['page_name'];}
if ($pages['page_type']=="Story") {$type_class="story";}
if ($pages['page_type']=="Teaching") {$type_class="teaching";}
if ($pages['page_type']=="Appendix") {$type_class="appendix";}
if ($pages['page_type']==NULL) {$type_class="blank";}
$query = "Select worksheet_id from Worksheet where worksheet_page = '{$pages['id']}' and embedded = '1'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);
if ($results['worksheet_id']== NULL) {$embed = "";}
else{$embed = "<div class='embed' title='This page has embedded worksheet items.'>?</div>";}

?>
 
<div class="page <?php echo $type_class; if ($pages['id'] == $pageHL) {echo " current";}?> " title="<?php echo $pages['page_name'];?>" style="top:<?php echo $pages['page_top']/$x; ?>;left:<?php echo $pages['page_left']/$x; ?>;" id="<?php echo $pages['id']; ?>">
	<?php echo $page_name; ?>
	<a title="View this page in the story." class="goto-page" href="../../story/index.php?page_id=<?php echo $pages['id'];?>&story=<?php echo $story; ?>"></a>
	<div class="edit-page" id="edit<?php echo $pages['id'];?>" title="Edit"></div>
	<div class="delete" id="delete<?php echo $pages['id'];?>" title="Delete"></div>
	<div class="relate"   id="relate<?php echo $pages['id'];?>" title="Add New Link"></div>
	<?php
	if ($pages['id'] == $story_info['story_first_page']) {echo "<div id='start' class='start-finish-summary' title='Click twice. On the Second click keep the mouse key down and drag to a new page.'>Start</div>";}
	if ($pages['id'] == $story_info['story_summary']) {echo "<div id='summary' class='start-finish-summary' title='Click twice. On the Second click keep the mouse key down and drag to a new page.'>Summary</div>";}
	if ($pages['finish_page'] == "true") {echo "<div class='start-finish-summary finish'>Finish</div>";}
	echo $embed;
	?>
</div>

<?php
	if($pages['page_top'] > $h) {$h = $pages['page_top'];}
	if($pages['page_left'] > $w) {$w = $pages['page_left'];}
	

} /* end while */
while ($relations = mysql_fetch_assoc($list_page_relations)) { 

	if ($relations['page_external'] == "false") {?>
		<div class="line" id="line<?php echo $relations['page_relation_id']; ?>"><div title="<?php echo $relations['page_stem']." ".$relations['page_link'].$relations['page_punctuation']; ?>" id="arrow<?php echo $relations['page_relation_id']; ?>" class="arrow"></div></div>
		<script>line(<?php echo $relations['page_parent'].", ".$relations['page_child'].", ".$relations['page_relation_id'].", ".$magT.", ".$magL; ?>);</script>
	<?php }
	else {
	$query = "Select page_top, page_left from Pages where id = '{$relations['page_parent']}'";
	$run = mysql_query($query) or die(mysql_error());
	$results = mysql_fetch_assoc($run);
	$linkTop = $results['page_top']/$x + $ph + 4/$x+2;
	$linkLeft = $results['page_left']/$x;
	
	$query = "Select s.story_id, s.story_name, p.id from Stories s,	Pages p	where s.story_id = p.story and p.id = '{$relations['page_child']}'";
	$run = mysql_query($query) or die(mysql_error());
	$results = mysql_fetch_assoc($run);
	
	$linkName = $results['story_name'];
	echo <<<EOF
	<script> $("#{$relations['page_parent']}").append("<a title='This page links to another story' class='linkToStory' id='line{$relations['page_relation_id']}' style='top:55;left:-2;'>$linkName</a><a class='deleteExLink' id='ExLink{$relations['page_relation_id']}' onClick='deleteLinkToStory({$relations['page_relation_id']})'></a>");
	</script>
EOF;
	}
} /* end while */
?>

<!-- <div id="newpage" class="page" style="top:40;left:450;z-index=99">New Page</div> -->
<div id="update"></div>
<div id="fadebackground"></div>
<div id="hud">
<h1>Toolbar</h1>
<a class="btn" id="edit">Edit Story Info</a>
<a class="btn" id="permissions">Permissions</a>
<a class="btn" id="print" href="../print/index.php?story=<?php echo $story; ?>">Print Manager</a>
<a class="btn" id="new_page">Add New Page</a>
<h1>
Zoom (<span id="factor"></span>)
</h1>
<div id="zoom"></div>
</div>

<?php
	$h=$h+50;
	$w=$w+200;

?>

<div id="mapgrid"></div>
<script>
$("#mapgrid").css({
	"width" : <?php echo $w/$x; ?>,
	"height" : <?php echo $h/$x; ?>,
});

$("body").css({
	"background-size" : "<?php echo $grid_size; ?>px"
});



$(".page").css({
	"width"	: <?php echo $pw; ?>,
	"height": <?php echo $ph; ?>,
	"font-size" : "<?php echo $f; ?>px",
	"padding"	: <?php echo $padding; ?>,
});

$(".linkToStory").css({
	"width"	: <?php echo $pw; ?>,
	"font-size" : "<?php echo $f-4; ?>px",
	"padding"	: <?php echo $padding; ?>,
});

$(".relate, .edit-page, .delete").css({
	"background-size": "<?php echo $img_size; ?>px",
	"width": "<?php echo $img_size; ?>px",
	"height": "<?php echo $img_size; ?>px",
});


$(".relate").css({
	"right" : "<?php echo $relate_right; ?>px"
});

$(".delete").css({
	"right" : "<?php echo $delete_right; ?>px"
});


$(".edit-page").css({
	"right" : "<?php echo $edit_page_right; ?>px"
});

$(".arrow").css({
	"background-size": "<?php echo $arrow_size; ?>px",
	"left" : "<?php echo $arrow_location; ?>px",
	"width" : "<?php echo $arrow_size; ?>px",
	"height" : "<?php echo $arrow_size; ?>px",

});

$(".goto-page").css({
	"background-size": "<?php echo $external_size; ?>px",
	"width": "<?php echo $external_size; ?>px",
	"height": "<?php echo $external_size; ?>px",

});

$(".start-finish-summary").css({
	"padding"	: <?php echo $padding; ?>,
	"height": <?php echo $start_finish_summary_height; ?>,
	"font-size" : "<?php echo $start_finish_summary_font; ?>px"

});
	


</script>
<div id="ajax">Processing<img src="../../img/ajax-loader.gif" /></div>

<div id="popup"><div class="close-icon"></div><div id="popup-content"></div></div>
<div id="selector"></div>
<div id="pageRightClick">
	<a class="pageRightClickOption" id="editPage">Edit Page</a>
	<a class="pageRightClickOption" id="duplicate">Duplicate</a>
	<a class="pageRightClickOption" id="delete">Delete</a>
	<a class="pageRightClickOption" id="toggleFinish">Toggle Finish Page</a>
	<a class="pageRightClickOption" id="linkToStory">Link to other Story</a>
	<a class="pageRightClickOption" id="deleteLink" onclick="delete_relation(this);">Delete Link</a>
	<a class="pageRightClickOption" id="editLink" onclick="pageRelation();">Edit Link</a>
</div>

</body>
</html>